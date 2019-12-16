<?php

namespace App\Controller;

use App\Constants\RoleConst;
use App\Entity\Admin;
use App\Entity\User;
use App\Entity\WarehouseWorker;
use App\Form\AdminType;
use App\Form\UserType;
use App\Form\WarehouseWorkerType;
use App\Repository\UserRepository;
use App\Repository\WarehouseWorkerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class WarehouseWorkerController
 * @package App\Controller
 * @Route("/worker")
 */
class WarehouseWorkerController extends AbstractController
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="warehouse_worker_index")
     */
    public function index(WarehouseWorkerRepository $warehouseWorkerRepository, PaginatorInterface $paginator, Request $request)
    {
        $pagination = $paginator->paginate(
            $warehouseWorkerRepository->findAll(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('administrator/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/register", name="warehouse_worker_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $worker = new WarehouseWorker();

        $form = $this->createForm(WarehouseWorkerType::class, $worker);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $user = $worker->getBaseUser();

            $user->setRoles([RoleConst::ROLE_WAREHOUSE_WORKER]);

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $this->entityManager->persist($worker);
            $this->entityManager->flush();

            return $this->redirectToRoute('warehouse_worker_index');
        }


        return $this->render('administrator_registration/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

