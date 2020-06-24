<?php

namespace App\Controller;

use App\Entity\FamilyStatus;
use App\Form\FamilyStatusType;
use App\Repository\FamilyStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/family/status")
 */
class FamilyStatusController extends AbstractController
{
    /**
     * @Route("/", name="family_status_index", methods={"GET"})
     */
    public function index(FamilyStatusRepository $familyStatusRepository): Response
    {
        return $this->render('family_status/index.html.twig', [
            'family_statuses' => $familyStatusRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="family_status_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $familyStatus = new FamilyStatus();
        $form = $this->createForm(FamilyStatusType::class, $familyStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($familyStatus);
            $entityManager->flush();

            return $this->redirectToRoute('family_status_index');
        }

        return $this->render('family_status/new.html.twig', [
            'family_status' => $familyStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="family_status_show", methods={"GET"})
     */
    public function show(FamilyStatus $familyStatus): Response
    {
        return $this->render('family_status/show.html.twig', [
            'family_status' => $familyStatus,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="family_status_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FamilyStatus $familyStatus): Response
    {
        $form = $this->createForm(FamilyStatusType::class, $familyStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('family_status_index');
        }

        return $this->render('family_status/edit.html.twig', [
            'family_status' => $familyStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="family_status_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FamilyStatus $familyStatus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$familyStatus->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($familyStatus);
            $entityManager->flush();
        }

        return $this->redirectToRoute('family_status_index');
    }
}
