<?php

namespace App\Controller;

use App\Constants\RoleConst;
use App\Entity\Admin;
use App\Entity\Courier;
use App\Entity\User;
use App\Form\AdminType;
use App\Form\CourierType;
use App\Form\UserType;
use App\Repository\CourierRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
        $this->denyAccessUnlessGranted(RoleConst::ROLE_ADMIN);

        $pagination = $paginator->paginate(
            $courierRepository->findAll(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('administrator/index.html.twig', [
            'pagination' => $pagination
        ]);
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

            return $this->redirectToRoute('courier_index');
        }


        return $this->render('administrator_registration/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

