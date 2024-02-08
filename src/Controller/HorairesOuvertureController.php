<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HorairesOuvertureController extends AbstractController
{
    #[Route('/horaires/ouverture', name: 'app_horaires_ouverture')]
    public function index(): Response
    {
        return $this->render('horaires_ouverture/index.html.twig', [
            'controller_name' => 'HorairesOuvertureController',
        ]);
    }
}
