<?php

namespace App\Controller;

use App\Entity\Vacancy;
use App\Form\VacancyModerateType;
use App\Form\VacancySearchType;
use App\Form\VacancyType;
use App\Repository\OrganizationRepository;
use App\Repository\VacancyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VacancySearchController extends AbstractController
{
    /**
     * @Route("/", name="vacancy_search_index", methods={"GET", "POST"})
     */
    public function index(Request $request, VacancyRepository $vacancyRepository): Response
    {
        $vacancy_for_search = new Vacancy();
        $form = $this->createForm(VacancySearchType::class, $vacancy_for_search);

        $search_parameters = ['status' => 'актуальна', 'moderation_status' => 'опубликовано'];
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($vacancy_for_search->getSalary())
                $search_parameters = array_merge($search_parameters, ['salary' => $vacancy_for_search->getSalary()]);

            if($vacancy_for_search->getSalary() === 0)
                $search_parameters = array_merge($search_parameters, ['salary' => 0]);

            if($vacancy_for_search->getPositionId())
                $search_parameters = array_merge($search_parameters, ['position_id' => $vacancy_for_search->getPositionId()]);

            if($vacancy_for_search->getPaymentForm())
                $search_parameters = array_merge($search_parameters, ['payment_form' => $vacancy_for_search->getPaymentForm()]);

            if($vacancy_for_search->getEmploymentType())
                $search_parameters = array_merge($search_parameters, ['employment_type' => $vacancy_for_search->getEmploymentType()]);

            return $this->render('vacancy_search/index.html.twig', [
                'vacancies' => $vacancyRepository->findBy($search_parameters),
                'form' => $form->createView(),
            ]);
        }

        return $this->render('vacancy_search/index.html.twig', [
            'vacancies' => $vacancyRepository->findBy($search_parameters),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/vacancy_search/{id}", name="vacancy_search_show", methods={"GET"})
     */
    public function show(Vacancy $vacancy): Response
    {
        return $this->render('vacancy_search/show.html.twig', [
            'vacancy' => $vacancy,
        ]);
    }

    /**
     * @Route("/vacancy/{id}/user", name="vacancy_search_show_user", methods={"GET"})
     */
    public function show_user(Vacancy $vacancy): Response
    {
        return $this->render('vacancy_search/show_user.html.twig', [
            'user' => $vacancy->getUserId(),
        ]);
    }
}
