<?php

namespace App\Controller;

use App\Entity\EmploymentType;
use App\Form\EmploymentTypeType;
use App\Repository\EmploymentTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/employment/type")
 */
class EmploymentTypeController extends AbstractController
{
    /**
     * @Route("/", name="employment_type_index", methods={"GET"})
     */
    public function index(EmploymentTypeRepository $employmentTypeRepository): Response
    {
        return $this->render('employment_type/index.html.twig', [
            'employment_types' => $employmentTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="employment_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $employmentType = new EmploymentType();
        $form = $this->createForm(EmploymentTypeType::class, $employmentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employmentType);
            $entityManager->flush();

            return $this->redirectToRoute('employment_type_index');
        }

        return $this->render('employment_type/new.html.twig', [
            'employment_type' => $employmentType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employment_type_show", methods={"GET"})
     */
    public function show(EmploymentType $employmentType): Response
    {
        return $this->render('employment_type/show.html.twig', [
            'employment_type' => $employmentType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="employment_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EmploymentType $employmentType): Response
    {
        $form = $this->createForm(EmploymentTypeType::class, $employmentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employment_type_index');
        }

        return $this->render('employment_type/edit.html.twig', [
            'employment_type' => $employmentType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employment_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EmploymentType $employmentType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employmentType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employmentType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('employment_type_index');
    }
}
