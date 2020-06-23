<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index()
    {
        $user = new User();
        $user->setName("Roman");

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
//        return $this->render('account/index.html.twig', [
//            'user' => $user
//        ]);
    }
}
