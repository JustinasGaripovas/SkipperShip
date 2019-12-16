<?php

namespace App\Controller;

use App\Constants\RoleConst;
use App\Entity\Admin;
use App\Entity\Courier;
use App\Entity\Delivery;
use App\Entity\User;
use App\Entity\Warehouse;
use App\Form\AdminType;
use App\Form\CourierType;
use App\Form\UserType;
use App\Repository\CourierRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CourierController
 * @package App\Controller
 * @Route("/courier")
 */
class CourierController extends AbstractController
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="courier_index")
     */
    public function index(CourierRepository $courierRepository, PaginatorInterface $paginator, Request $request)
    {
        $pagination = $paginator->paginate(
            $courierRepository->findAll(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('courier/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/{id}/delivery", name="courier_delivery_index", methods={"GET"})
     */
    public function indexDelivery(Courier $courier, PaginatorInterface $paginator,Request $request)
    {
        $pagination = $paginator->paginate(
            $courier->getDelivery(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('courier/delivery/index.html.twig', [
            'pagination' => $pagination,
            'courier' => $courier
        ]);
    }


    /**
     * @ParamConverter("courier", options={"mapping": {"id_courier" : "id"}})
     * @ParamConverter("delivery", options={"mapping": {"id_delivery" : "id"}})
     *
     * @Route("/{id_courier}/delivery/{id_delivery}/cancel", name="courier_delivery_cancel", methods={"GET","POST"})
     */
    public function cancelCourier(Courier $courier, Delivery $delivery, Request $request)
    {

        $delivery->setStatus(3);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('courier_delivery_index',['id'=>$courier->getId()]);
    }

    /**
     * @ParamConverter("courier", options={"mapping": {"id_courier" : "id"}})
     * @ParamConverter("delivery", options={"mapping": {"id_delivery" : "id"}})
     *
     * @Route("/{id_courier}/delivery/{id_delivery}/delivered", name="courier_delivery_delivered", methods={"GET","POST"})
     */
    public function deliveredCourier(Courier $courier, Delivery $delivery, Request $request)
    {

        $delivery->setStatus(4);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('courier_delivery_index',['id'=>$courier->getId()]);
    }


    /**
     * @Route("/register", name="courier_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $courier = new Courier();

        $form = $this->createForm(CourierType::class, $courier);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $user = $courier->getBaseUser();

            $user->setRoles([RoleConst::ROLE_COURIER]);

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $this->entityManager->persist($courier);
            $this->entityManager->flush();

            return $this->redirectToRoute('delivery_index');
        }


        return $this->render('administrator_registration/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

