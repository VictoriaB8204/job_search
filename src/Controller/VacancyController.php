<?php

namespace App\Controller;

use App\Entity\Vacancy;
use App\Form\VacancyModerateType;
use App\Form\VacancyType;
use App\Repository\OrganizationRepository;
use App\Repository\VacancyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vacancy")
 */
class VacancyController extends AbstractController
{
    /**
     * @Route("/", name="vacancy_index", methods={"GET"})
     */
    public function index(VacancyRepository $vacancyRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('vacancy/index.html.twig', [
            'vacancies' => $vacancyRepository->findBy(['user_id' => $this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/vacancy_in_moderate", name="vacancy_in_moderate", methods={"GET"})
     */
    public function vacancy_in_moderate(VacancyRepository $vacancyRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('vacancy/moderate_index.html.twig', [
            'vacancies' => $vacancyRepository->findBy(['moderation_status' => 'на рассмотрении']),
        ]);
    }

    /**
     * @Route("/{id}/moderate_vacancy", name="moderate_show_vacancy", methods={"GET","POST"})
     */
    public function moderate(Request $request, Vacancy $vacancy): Response
    {
        $form = $this->createForm(VacancyModerateType::class, $vacancy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vacancy_in_moderate');
        }

        return $this->render('vacancy/moderate_show.html.twig', [
            'vacancy' => $vacancy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="vacancy_new", methods={"GET","POST"})
     */
    public function new(Request $request, OrganizationRepository $organizationRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $vacancy = new Vacancy();

        $vacancy->setUserId($this->getUser());
        $vacancy->setModerationStatus('на рассмотрении');

        $form = $this->createForm(VacancyType::class, $vacancy, [
            'userOrganizations' => $vacancy->getUserId()->getOrganizations()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vacancy);
            $entityManager->flush();

            return $this->redirectToRoute('vacancy_index');
        }

        return $this->render('vacancy/new.html.twig', [
            'vacancy' => $vacancy,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="vacancy_show", methods={"GET"})
     */
    public function show(Vacancy $vacancy): Response
    {
        return $this->render('vacancy/show.html.twig', [
            'vacancy' => $vacancy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vacancy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vacancy $vacancy): Response
    {
        $vacancy->setModerationStatus('на рассмотрении');
        $vacancy->setRefuseReason(null);

        $form = $this->createForm(VacancyType::class, $vacancy, [
            'userOrganizations' => $vacancy->getUserId()->getOrganizations()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vacancy_index');
        }

        return $this->render('vacancy/edit.html.twig', [
            'vacancy' => $vacancy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vacancy_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Vacancy $vacancy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vacancy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vacancy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vacancy_index');
    }
}
