<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\Image;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PictureService;
use App\Form\FormulaireContactType;
use App\Entity\FormulaireContact;



#[Route('/voiture')]
class VoitureController extends AbstractController
{

    #[Route('/', name: 'app_voiture_index', methods: ['GET'])]
    public function index(VoitureRepository $voitureRepository): Response
    {
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitureRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_voiture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PictureService $pictureService): Response
    {

        $user = $this->getUser();
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {

            $voiture->setUtilisateur($user);
            $images = $form->get('image')->getData();
            
            foreach($images as $image){
                // On définit le dossier de destination
                $folder = '';

                // On appelle le service d'ajout
                $fichier = $pictureService->add($image, $folder);

                $img = new Image();
                $img->setName($fichier);
                $voiture->addImage($img);
            }
            // Persist the voiture entity along with the associated images
            $entityManager->persist($voiture);
            $entityManager->flush();
    
            // Redirect to the index page or any other appropriate page
            return $this->redirectToRoute('app_voiture_index');
        }
    
        return $this->render('voiture/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }





    #[Route('/{id}/edit', name: 'app_voiture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_voiture_delete', methods: ['POST'])]
    public function delete(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $voiture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($voiture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
    }




    #[Route('/details/{id}', name: 'voiture_details')]
    public function details(int $id, VoitureRepository $voitureRepository, Request $request): Response
    {
        $voiture = $voitureRepository->find($id);
    
        if (!$voiture) {
            throw $this->createNotFoundException('Voiture not found');
        }
    
        // Create an instance of the FormulaireContact entity
        $formulaireContact = new FormulaireContact();
    
        // Create the contact form
        $form = $this->createForm(FormulaireContactType::class, $formulaireContact);
    
        // Handle form submission
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Handle form submission logic here, such as sending an email
            // Redirect or render a response after form submission
        }
    
        return $this->render('voiture/details.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(), // Pass the form view to the template
        ]);
    }
    
}


