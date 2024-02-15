<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FormulaireContactType;
use App\Entity\FormulaireContact;
use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use App\Repository\FormulaireContactRepository;
use Doctrine\ORM\EntityManagerInterface;


class FormulaireContactController extends AbstractController
{


    //////////////////////////////////////// Afficher Contact //////////////////////////////////////////

    #[Route('/formulaire/contact/{id}', name: 'app_formulaire_contact')]
    public function formulaireContact(int $id, Request $request, VoitureRepository $voitureRepository, EntityManagerInterface $entityManager): Response
    {
        $voiture = $voitureRepository->find($id);

        // Create a new FormulaireContact instance
        $formulaireContact = new FormulaireContact();

        // Create the form
        $form = $this->createForm(FormulaireContactType::class, $formulaireContact);

        // Handle form submission
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Set the voiture for the formulaireContact
            $formulaireContact->setVoiture($voiture);

            // Persist and flush the formulaireContact
            $entityManager->persist($formulaireContact);
            $entityManager->flush();

            return $this->redirectToRoute('accueil_app');
        }

        return $this->render('formulaire_contact/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


       //////////////////////////////////////// Supprimer contact //////////////////////////////////////////

    #[Route('/formulaire/contact/delete/{id}', name: 'delete_formulaire_contact', methods: ['GET', 'POST'])]
    public function deleteFormulaireContact($id, EntityManagerInterface $entityManager): Response
    {
        $formulaireContact = $entityManager->getRepository(FormulaireContact::class)->find($id);
        
        if (!$formulaireContact) {
            throw $this->createNotFoundException('Formulaire contact not found');
        }
    
        $voitureId = $formulaireContact->getVoiture()->getId();
        $entityManager->remove($formulaireContact);
        $entityManager->flush();
    
        return $this->redirectToRoute('voiture_details', ['id' => $voitureId]);
    }

    
}
