<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\HorairesOuverture;
use App\Form\HorairesOuvertureType;



class HorairesOuvertureController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


     //////////////////////////////////////// Ajouter Horaires d'Ouverture //////////////////////////////////////////

     
    #[Route('admin/horaires-ouverture/ajouter', name: 'ajouter_horaires_ouverture')]
    public function create(Request $request): Response
    {
            $user = $this->getUser();
            $horairesOuverture = new HorairesOuverture();
            $form = $this->createForm(HorairesOuvertureType::class, $horairesOuverture);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $horairesOuverture->setUtilisateur($user);
                $this->entityManager->persist($horairesOuverture);
                $this->entityManager->flush();

                // Redirect to a success page or render a success message
                return $this->redirectToRoute('horaires_ouverture');
            }

            return $this->render('horaires_ouverture/ajouter.html.twig', [
                'form' => $form->createView(),
            ]);
       
    }


       //////////////////////////////////////// Afficher Horaires d'Ouverture //////////////////////////////////////////


    #[Route('/horaires-ouverture', name: 'horaires_ouverture')]
    public function index(): Response
{
    

    $horairesOuvertures = $this->entityManager->getRepository(HorairesOuverture::class)->findAll();

    return $this->render('horaires_ouverture/afficher.html.twig', [
        'horairesOuvertures' => $horairesOuvertures,
    ]);

}


   //////////////////////////////////////// Modifier Horaires d'Ouverture //////////////////////////////////////////


   #[Route('admin/horaires-ouverture/{id}', name: 'modifier_horaires_ouverture')]
   public function update(Request $request, HorairesOuverture $horairesOuverture): Response
   {

    
       $form = $this->createForm(HorairesOuvertureType::class, $horairesOuverture);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
           $this->entityManager->flush();

           // Redirect to a success page or render a success message
           return $this->redirectToRoute('horaires_ouverture');
       }

       return $this->render('horaires_ouverture/modifier.html.twig', [
           'form' => $form->createView(),
       ]);
   }


    //////////////////////////////////////// Supprimer Horaires d'Ouverture //////////////////////////////////////////

    #[Route('admin/horaires-ouverture/{id}/supprimer', name: 'supprimer_horaires_ouverture')]

    public function delete(Request $request, HorairesOuverture $horairesOuverture): Response
    {
        


            $this->entityManager->remove($horairesOuverture);
            $this->entityManager->flush();
    
            // Redirect or return a response indicating success
            return $this->redirectToRoute('horaires_ouverture');
        
        
    
       
    }




}

