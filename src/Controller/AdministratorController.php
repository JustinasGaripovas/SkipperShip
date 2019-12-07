<?php

namespace App\Controller;

use App\Constants\RoleConst;
use App\Repository\AdministratorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function index(AdministratorRepository $administratorRepository, PaginatorInterface $paginator, Request $request)
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
}
