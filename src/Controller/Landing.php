<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class Landing extends AbstractController
{
    public function landingFunction(): Response
    {
        $errorMessage = '';
        // Must return something to skip Response Error

        return $this->render('landing.html.twig', [
            'error' => $errorMessage,
        ]);
    }
}