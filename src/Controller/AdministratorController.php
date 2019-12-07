<?php

namespace App\Controller;

use App\Constants\RoleConst;
use App\Entity\Admin;
use App\Entity\User;
use App\Form\AdminType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdministratorController extends AbstractController
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/administrator", name="administrator_index")
     */
    public function index(UserRepository $administratorRepository, PaginatorInterface $paginator, Request $request)
    {
        $this->denyAccessUnlessGranted(RoleConst::ROLE_ADMIN);

        $pagination = $paginator->paginate(
            $administratorRepository->findAll(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('administrator/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $admin = new Admin();

        $formAdmin = $this->createForm(AdminType::class, $admin);
        $formAdmin->handleRequest($request);


        if ($formAdmin->isSubmitted() && $formAdmin->isValid()) {

            $user = $admin->getBaseUser();

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $this->entityManager->persist($admin);
            $this->entityManager->flush();

            return $this->redirectToRoute('administrator_index');
        }


        return $this->render('administrator_registration/_form.html.twig', [
            'formAdmin' => $formAdmin->createView(),
        ]);
    }
}

