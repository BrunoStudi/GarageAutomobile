<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurController extends AbstractController
{

    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $userRepository = $entityManager->getRepository(Utilisateur::class);
        $employeUsers = $userRepository->findBy(['roles' => 'ROLE_EMPLOYE']);
    
        return $this->render('/utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
            'employeUsers' => $employeUsers,
        ]);
    }
    


    #[Route('/admin/user/{id}/delete', name: 'app_delete_user')]
    public function delete(Utilisateur $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'User deleted successfully.');

        return $this->redirectToRoute('app_utilisateur');
    }



    #[Route('/admin/user/{id}/update', name: 'app_update_user')]
    public function update(Utilisateur $user, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // If user provided a new password, hash and set it
            if ($form->get('plainPassword')->getData() !== null) {
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }
    
            $entityManager->flush();
    
            $this->addFlash('success', 'User updated successfully.');
    
            return $this->redirectToRoute('app_utilisateur');
        }
    
        return $this->render('utilisateur/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    
}
