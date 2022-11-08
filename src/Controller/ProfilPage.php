<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use mysqli;

class ProfilPage extends AbstractController
{

    public function profilFunction(): Response
    {
        session_start();

        $id = $_SESSION['id'];

        $errorMessage = '';
        // Must return something to skip Response Error

        return $this->render('ProfilPage.html.twig', [
            'error' => $errorMessage,
            'id' => $id,
        ]);
    }
}