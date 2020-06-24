<?php

namespace App\Controller;

use App\Entity\Responses;
use App\Form\ResponsesType;
use App\Repository\ResponsesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/responses")
 */
class ResponsesController extends AbstractController
{
    /**
     * @Route("/", name="responses_index", methods={"GET"})
     */
    public function index(ResponsesRepository $responsesRepository): Response
    {
        return $this->render('responses/index.html.twig', [
            'responses' => $responsesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="responses_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $response = new Responses();
        $form = $this->createForm(ResponsesType::class, $response);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($response);
            $entityManager->flush();

            return $this->redirectToRoute('responses_index');
        }

        return $this->render('responses/new.html.twig', [
            'response' => $response,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="responses_show", methods={"GET"})
     */
    public function show(Responses $response): Response
    {
        return $this->render('responses/show.html.twig', [
            'response' => $response,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="responses_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Responses $response): Response
    {
        $form = $this->createForm(ResponsesType::class, $response);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('responses_index');
        }

        return $this->render('responses/edit.html.twig', [
            'response' => $response,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="responses_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Responses $response): Response
    {
        if ($this->isCsrfTokenValid('delete'.$response->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($response);
            $entityManager->flush();
        }

        return $this->redirectToRoute('responses_index');
    }
}
