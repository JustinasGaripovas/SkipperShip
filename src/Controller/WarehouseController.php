<?php

namespace App\Controller;

use App\Constants\RoleConst;
use App\Entity\Delivery;
use App\Entity\Warehouse;
use App\Form\CourierAssignType;
use App\Form\InquiryType;
use App\Form\WarehouseType;
use App\Repository\WarehouseRepository;
use App\Service\Mailer;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/warehouse")
 */
class WarehouseController extends AbstractController
{
    /**
     * @Route("/", name="warehouse_index", methods={"GET"})
     */
    public function index(WarehouseRepository $warehouseRepository): Response
    {


        return $this->render('warehouse/index.html.twig', [
            'warehouses' => $warehouseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/delivery", name="warehouse_delivery_index", methods={"GET"})
     */
    public function indexDelivery(Warehouse $warehouse, PaginatorInterface $paginator,Request $request)
    {
        $pagination = $paginator->paginate(
            $warehouse->getDeliveries(),
            $request->query->getInt('page', 1),
            15
        );

        return $this->render('warehouse/delivery/index.html.twig', [
            'pagination' => $pagination,
            'warehouse' => $warehouse
        ]);
    }

    /**
     * @ParamConverter("warehouse", options={"mapping": {"id_warehouse" : "id"}})
     * @ParamConverter("delivery", options={"mapping": {"id_delivery" : "id"}})
     *
     * @Route("/{id_warehouse}/delivery/{id_delivery}/inquiry", name="warehouse_delivery_inquiry", methods={"GET","POST"})
     */
    public function inquiry(Warehouse $warehouse, Delivery $delivery, Mailer $mailer, Request $request)
    {

        $form = $this->createForm(InquiryType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData()['message'];
            $target = $form->getData()['target'];

            if ($target == 0 && $delivery->getCourier() !== null && $delivery->getCourier()->getBaseUser() !== null)
            {
                $mailer->sendInquireToCourier($delivery->getCourier()->getBaseUser(), $message . "\nFOR DELIVERY\n Label = " . $delivery->getLabel() . ", Id = " . $delivery->getId());
            }

            if ($target == 1 && $delivery->getClient() !== null && $delivery->getClient()->getBaseUser() !== null){
                $mailer->sendInquireToClient($delivery->getClient()->getBaseUser(), $message . "\nFOR DELIVERY\n Label = " . $delivery->getLabel() . ", Id = " . $delivery->getId(), $delivery->getClient()->getBaseUser());
            }

            return $this->redirectToRoute('warehouse_index');
        }

        return $this->render('warehouse/delivery/inquiry.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @ParamConverter("warehouse", options={"mapping": {"id_warehouse" : "id"}})
     * @ParamConverter("delivery", options={"mapping": {"id_delivery" : "id"}})
     *
     * @Route("/{id_warehouse}/delivery/{id_delivery}/assign", name="warehouse_delivery_assign", methods={"GET","POST"})
     */
    public function assignCourier(Warehouse $warehouse, Delivery $delivery, Mailer $mailer, Request $request)
    {
        $form = $this->createForm(CourierAssignType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courier = $form->getData()['courier'];

            $delivery->setCourier($courier);
            $delivery->setStatus(2);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('warehouse_index');
        }

        return $this->render('warehouse/delivery/inquiry.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="warehouse_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $warehouse = new Warehouse();
        $form = $this->createForm(WarehouseType::class, $warehouse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($warehouse);
            $entityManager->flush();

            return $this->redirectToRoute('warehouse_index');
        }

        return $this->render('warehouse/new.html.twig', [
            'warehouse' => $warehouse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="warehouse_show", methods={"GET"})
     */
    public function show(Warehouse $warehouse): Response
    {
        return $this->render('warehouse/show.html.twig', [
            'warehouse' => $warehouse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="warehouse_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Warehouse $warehouse): Response
    {
        $form = $this->createForm(WarehouseType::class, $warehouse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('warehouse_index');
        }

        return $this->render('warehouse/edit.html.twig', [
            'warehouse' => $warehouse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="warehouse_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Warehouse $warehouse): Response
    {
        if ($this->isCsrfTokenValid('delete'.$warehouse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($warehouse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('warehouse_index');
    }
}
