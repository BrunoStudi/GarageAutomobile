<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\FormulaireContactType;
use App\Entity\FormulaireContact;

class FormulaireContactController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/formulaire/contact', name: 'app_formulaire_contact')]
    public function formulaireContact(Request $request): Response
    {
        $formulaireContact = new FormulaireContact();
        $form = $this->createForm(FormulaireContactType::class, $formulaireContact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle form submission
            // For example, persist the data to the database
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($formulaireContact);
            $entityManager->flush();

            // Redirect to a success page or render a success message
            return $this->redirectToRoute('accueil_app');
        }

        return $this->render('formulaire_contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
