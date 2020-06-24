<?php

namespace App\Controller;

use App\Entity\PaymentForm;
use App\Form\PaymentFormType;
use App\Repository\PaymentFormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/payment/form")
 */
class PaymentFormController extends AbstractController
{
    /**
     * @Route("/", name="payment_form_index", methods={"GET"})
     */
    public function index(PaymentFormRepository $paymentFormRepository): Response
    {
        return $this->render('payment_form/index.html.twig', [
            'payment_forms' => $paymentFormRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="payment_form_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $paymentForm = new PaymentForm();
        $form = $this->createForm(PaymentFormType::class, $paymentForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paymentForm);
            $entityManager->flush();

            return $this->redirectToRoute('payment_form_index');
        }

        return $this->render('payment_form/new.html.twig', [
            'payment_form' => $paymentForm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="payment_form_show", methods={"GET"})
     */
    public function show(PaymentForm $paymentForm): Response
    {
        return $this->render('payment_form/show.html.twig', [
            'payment_form' => $paymentForm,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="payment_form_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PaymentForm $paymentForm): Response
    {
        $form = $this->createForm(PaymentFormType::class, $paymentForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payment_form_index');
        }

        return $this->render('payment_form/edit.html.twig', [
            'payment_form' => $paymentForm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="payment_form_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PaymentForm $paymentForm): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paymentForm->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paymentForm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('payment_form_index');
    }
}
