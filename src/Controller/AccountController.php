<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit_account", name="edit_account")
     */
    public function edit(Request $request): Response
    {
        $user = $this->getUser();
        $user->setPlainPassword(" ");
        $form = $this->createForm(AccountType::class, $user);

        // 2) обработайте отправку (произойдёт только в POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) сохраните Пользователя!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->render('account/index.html.twig', [
                'user' => $user,
            ]);
        }

        return $this->render('account/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
