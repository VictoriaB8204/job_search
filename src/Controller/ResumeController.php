<?php

namespace App\Controller;

use App\Entity\Resume;
use App\Form\ResumeModerateType;
use App\Form\ResumeType;
use App\Repository\ResumeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resume")
 */
class ResumeController extends AbstractController
{
    /**
     * @Route("/", name="resume_index", methods={"GET"})
     */
    public function index(ResumeRepository $resumeRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('resume/index.html.twig', [
            'resumes' => $resumeRepository->findBy(['user_id' => $this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/resume_in_moderate", name="resume_in_moderate", methods={"GET"})
     */
    public function resume_in_moderate(ResumeRepository $resumeRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('resume/moderate_index.html.twig', [
            'resumes' => $resumeRepository->findBy(['moderation_status' => 'на рассмотрении']),
        ]);
    }

    /**
     * @Route("/{id}/moderate", name="moderate_show", methods={"GET","POST"})
     */
    public function moderate(Request $request, Resume $resume): Response
    {
        $form = $this->createForm(ResumeModerateType::class, $resume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resume_in_moderate');
        }

        return $this->render('resume/moderate_show.html.twig', [
            'resume' => $resume,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="resume_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $resume = new Resume();

        $resume->setUserId($this->getUser());
        $resume->setModerationStatus('на рассмотрении');

        $form = $this->createForm(ResumeType::class, $resume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resume);
            $entityManager->flush();

            return $this->redirectToRoute('resume_index');
        }

        return $this->render('resume/new.html.twig', [
            'resume' => $resume,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resume_show", methods={"GET"})
     */
    public function show(Resume $resume): Response
    {
        return $this->render('resume/show.html.twig', [
            'resume' => $resume,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="resume_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Resume $resume): Response
    {
        $resume->setModerationStatus('на рассмотрении');

        $form = $this->createForm(ResumeType::class, $resume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resume_index');
        }

        return $this->render('resume/edit.html.twig', [
            'resume' => $resume,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resume_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Resume $resume): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resume->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($resume);
            $entityManager->flush();
        }

        return $this->redirectToRoute('resume_index');
    }
}
