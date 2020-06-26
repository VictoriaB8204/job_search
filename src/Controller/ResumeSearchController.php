<?php


namespace App\Controller;

use App\Entity\Resume;
use App\Form\ResumeSearchType;
use App\Repository\ResumeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resume_search")
 */
class ResumeSearchController extends AbstractController
{

    /**
     * @Route("/", name="resume_search_index")
     */
    public function index(Request $request, ResumeRepository $resumeRepository): Response
    {
        $resume_for_search = new Resume();
        $form = $this->createForm(ResumeSearchType::class, $resume_for_search);

        $search_parameters = ['status' => 'актуально', 'moderation_status' => 'опубликовано'];
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($resume_for_search->getSalary())
                $search_parameters = array_merge($search_parameters, ['salary' => $resume_for_search->getSalary()]);

            if($resume_for_search->getSalary() === 0)
                $search_parameters = array_merge($search_parameters, ['salary' => 0]);

            if($resume_for_search->getPositionId())
                $search_parameters = array_merge($search_parameters, ['position_id' => $resume_for_search->getPositionId()]);

            return $this->render('resume_search/index.html.twig', [
                'resumes' => $resumeRepository->findBy($search_parameters),
                'form' => $form->createView(),
            ]);
        }

        return $this->render('resume_search/index.html.twig', [
            'resumes' => $resumeRepository->findBy($search_parameters),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="resume_search_show", methods={"GET"})
     */
    public function show(Resume $resume): Response
    {
        return $this->render('resume_search/show.html.twig', [
            'resume' => $resume,
        ]);
    }

    /**
     * @Route("/{id}/user", name="resume_search_show_user", methods={"GET"})
     */
    public function show_user(Resume $resume): Response
    {
        return $this->render('resume_search/show_user.html.twig', [
            'user' => $resume->getUserId(),
        ]);
    }
//
//    /**
//     * @Route("/{id}/respond", name="resume_respond", methods={"GET"})
//     */
//    public function respond(Resume $resume): Response
//    {
//        return $this->render('resume_search/respond.html.twig', [
//            'resume' => $resume,
//        ]);
//    }
}