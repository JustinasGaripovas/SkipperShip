<?php

namespace App\Controller;

use App\Constants\RoleConst;
use App\Entity\Admin;
use App\Entity\User;
use App\Form\AdminType;
use App\Form\UserType;
use App\Repository\AdminRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdministratorController
 * @package App\Controller
 * @Route("/admin")
 */
class AdministratorController extends AbstractController
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="admin_index")
     */
    public function index(AdminRepository $adminRepository, PaginatorInterface $paginator, Request $request)
    {

        $pagination = $paginator->paginate(
            $adminRepository->findAll(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('administrator/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/register", name="admin_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $admin = new Admin();

        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $user = $admin->getBaseUser();

            $user->setRoles([RoleConst::ROLE_ADMIN]);

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $this->entityManager->persist($admin);
            $this->entityManager->flush();

            return $this->redirectToRoute('delivery_index');
        }


        return $this->render('administrator_registration/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

