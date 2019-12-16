<?php

namespace App\Controller;

use App\Constants\RoleConst;
use App\Entity\Delivery;
use App\Entity\WarehouseWorker;
use App\Form\DeliveryType;
use App\Form\InquiryType;
use App\Repository\DeliveryRepository;
use App\Service\Mailer;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/delivery")
 */
class DeliveryController extends AbstractController
{


    /**
     * @Route("/", name="delivery_index", methods={"GET"})
     */
    public function index(DeliveryRepository $deliveryRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $deliveryList = [];
        if ($this->isGranted(RoleConst::ROLE_WAREHOUSE_WORKER))
        {
            $deliveryList = $deliveryRepository->findAllUnassignedDeliveries();
        }else{
            $deliveryList = $deliveryRepository->findAll();
        }

        $pagination = $paginator->paginate(
            $deliveryList,
            $request->query->getInt('page', 1),
            15
        );


        return $this->render('delivery/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/{id}/inquiry", name="delivery_inquiry", methods={"GET","POST"})
     */
    public function inquiry(Delivery $delivery, Mailer $mailer, Request $request)
    {

        $form = $this->createForm(InquiryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData()['message'];

            $mailer->sendInquireToAdmin($message . "\nFOR DELIVERY\n Label = " . $delivery->getLabel() . ", Id = " . $delivery->getId(), $this->getUser()->getUsername());

            return $this->redirectToRoute('delivery_index');
        }

        return $this->render('delivery/inquiry.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/assign", name="delivery_assign_to_warehouse", methods={"GET","POST"})
     */
    public function assignToWarehouse(Delivery $delivery)
    {

        /** @var WarehouseWorker $warehouseWorker */
        $warehouseWorker = $this->getUser()->getWarehouseWorker();

        $warehouseWorker->getWarehouse()->addDelivery($delivery);

        $delivery->setStatus(1);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('delivery_index');
    }

    /**
     * @Route("/new", name="delivery_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $delivery = new Delivery();
        $form = $this->createForm(DeliveryType::class, $delivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $delivery->setCreatedAt(new \DateTime());
            $delivery->setUpdatedAt(new \DateTime());

            $delivery->setStatus(0);

            $delivery->setClient($this->getUser()->getClient());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($delivery);
            $entityManager->flush();

            return $this->redirectToRoute('delivery_index');
        }

        return $this->render('delivery/new.html.twig', [
            'delivery' => $delivery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delivery_show", methods={"GET"})
     */
    public function show(Delivery $delivery): Response
    {
        return $this->render('delivery/show.html.twig', [
            'delivery' => $delivery,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="delivery_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Delivery $delivery): Response
    {
        $form = $this->createForm(DeliveryType::class, $delivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('delivery_index');
        }

        return $this->render('delivery/edit.html.twig', [
            'delivery' => $delivery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delivery_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Delivery $delivery): Response
    {
        if ($this->isCsrfTokenValid('delete' . $delivery->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($delivery);
            $entityManager->flush();
        }

        return $this->redirectToRoute('delivery_index');
    }
}
