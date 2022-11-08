<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use mysqli;

class Homepage extends AbstractController
{
    public function browseFunction(): Response
    {
        session_start();

        if(session_id() == '') {
            header('Location: /login');
            die();
        }

        $errorMessage = '';

        return $this->render('homepage.html.twig', [
            'error' => $errorMessage,
        ]);
    }
}