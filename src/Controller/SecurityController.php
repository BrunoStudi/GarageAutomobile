<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\TemoignageRepository;



class SecurityController extends AbstractController
{

   //////////////////////////////////////// route du page d'accueil + l'envoi des temoignages vers la page d'accueil  //////////////////////////////////////////
    #[Route('/accueil', name: 'accueil_app')]
    public function index(TemoignageRepository $temoignageRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('profil_app');
        }

        $temoignages = $temoignageRepository->findAll();

        return $this->render('accueil.html.twig', [
            'temoignages' => $temoignages,
        ]);
    }


   //////////////////////////////////////// route vers la page du profil connecté  //////////////////////////////////////////

    #[Route('/profil', name: 'profil_app')]
    public function profil(): Response
    {
        return $this->render('profil.html.twig', []);
    }


    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('profil_app');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


   //////////////////////////////////////// Route du déconnection  //////////////////////////////////////////
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
