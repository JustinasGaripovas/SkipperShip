<?php

namespace App\Controller;

use App\Constants\RoleConst;
use App\Entity\Admin;
use App\Entity\Client;
use App\Entity\User;
use App\Form\AdminType;
use App\Form\ClientType;
use App\Form\UserType;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ClientController
 * @package App\Controller
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="client_index")
     */
    public function index(ClientRepository $clientRepository, PaginatorInterface $paginator, Request $request, Mailer $mailer)
    {
        $pagination = $paginator->paginate(
            $clientRepository->findAll(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('client/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/register", name="client_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $client = new Client();

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $client->getBaseUser();

            $user->setRoles([RoleConst::ROLE_CLIENT]);

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $this->entityManager->persist($client);
            $this->entityManager->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('administrator_registration/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}

