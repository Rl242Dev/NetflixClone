<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use mysqli;

class Homepage extends AbstractController
{
    public function browseFunction(): Response
    {
        $errorMessage = '';

        return $this->render('homepage.html.twig', [
            'error' => $errorMessage,
        ]);
    }
}