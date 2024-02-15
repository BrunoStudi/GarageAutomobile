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
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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




    #[Route('/filter-cars', name: 'filter_cars', methods: ['POST'])]
    public function filterCars(Request $request, VoitureRepository $voitureRepository, LoggerInterface $logger): JsonResponse
    {
        // Retrieve min and max price values from the AJAX request
        $minPrice = (float) $request->request->get('minPrice');
        $maxPrice = (float) $request->request->get('maxPrice');
    
        // Query the database to fetch cars within the specified price range
        $cars = $voitureRepository->findByPriceRange($minPrice, $maxPrice);
    
        // Serialize the result to JSON with photo paths included
        $serializedCars = [];
        foreach ($cars as $car) {
            $photoPath = null;
            if ($car->getImages()->count() > 0) {
                $photoPath = '/uploads/voiture' . '/' . $car->getImages()->first()->getName();
            }
    
            $logger->info('Photo path for car ID ' . $car->getId() . ': ' . $photoPath);
    
            $serializedCars[] = [
                'id' => $car->getId(),
                'Titre' => $car->getTitre(),
                'imageUrl' => $photoPath, // Change 'photoPath' to 'imageUrl'
                // Add other properties you want to include in the response
            ];
        }
    
        return new JsonResponse($serializedCars);
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

            foreach ($images as $image) {
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
    public function edit(Request $request, Voiture $voiture, EntityManagerInterface $entityManager, PictureService $pictureService): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('image')->getData();

            // Remove existing images
            foreach ($voiture->getImages() as $image) {
                $voiture->removeImage($image);
                $entityManager->remove($image); // Optionally, delete the file from the storage
            }

            // Add new images
            foreach ($images as $image) {
                // Define destination folder
                $folder = '';
                // Add new image
                $fichier = $pictureService->add($image, $folder);

                $img = new Image();
                $img->setName($fichier);
                $voiture->addImage($img);
            }

            // Persist changes
            $entityManager->flush();

            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }






    #[Route('/{id}', name: 'app_voiture_delete', methods: ['GET', 'POST'])]
    public function delete(int $id, Voiture $voiture, VoitureRepository $voitureRepository, EntityManagerInterface $entityManager): Response
    {
        $voiture = $voitureRepository->find($id);
        $entityManager->remove($voiture);
        $entityManager->flush();


        return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
    }







    #[Route('/details/{id}', name: 'voiture_details', methods: ['GET', 'POST'])]
    public function details(int $id, VoitureRepository $voitureRepository, Request $request): Response
    {
        $voiture = $voitureRepository->find($id);
        return $this->render('voiture/details.html.twig', [
            'voiture' => $voiture,
        ]);
    }




    #[Route('/details/contacts/{id}', name: 'contacts_details', methods: ['GET', 'POST'])]
    public function contacts(int $id, VoitureRepository $voitureRepository, Request $request): Response
    {
        $voiture = $voitureRepository->find($id);
        $contacts = $voiture->getFormulaireContact();

        return $this->render('voiture/consultecontact.html.twig', [
            'contacts' => $contacts,
        ]);
    }
}
