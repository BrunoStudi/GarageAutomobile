<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\FormulaireContact;
use App\Form\FormulaireContactType;


class FormulaireContactController extends AbstractController
{
    #[Route('/formulaire/contact', name: 'app_formulaire_contact')]
    public function formulaireContact(Request $request): Response
    {
        $formulaireContact = new FormulaireContact();
        $form = $this->createForm(FormulaireContactType::class, $formulaireContact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle form submission
            // For example, persist the data to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formulaireContact);
            $entityManager->flush();

            // Redirect to a success page or render a success message
            return $this->redirectToRoute('success_page');
        }

        return $this->render('formulaire_contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

 
    #[Route('/formulaire/contact/success', name: 'success_page')]
    public function formulaireContactSuccess(): Response
    {
        return $this->render('formulaire_contact/success.html.twig');
    }
}
