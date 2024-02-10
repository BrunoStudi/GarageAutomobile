<?php

namespace App\Controller;

use App\Entity\Temoignage;
use App\Form\TemoignageType;
use App\Repository\TemoignageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/temoignage')]
class TemoignageController extends AbstractController
{
    #[Route('/', name: 'app_temoignage_index', methods: ['GET'])]
    public function index(TemoignageRepository $temoignageRepository): Response
    {
        return $this->render('temoignage/index.html.twig', [
            'temoignages' => $temoignageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_temoignage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $temoignage = new Temoignage();
        $form = $this->createForm(TemoignageType::class, $temoignage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $note = $request->request->get('note');

           if (empty($note)) {
        // Default the note to 0
        $note = 0;
    }

    // Set the star rating value as the 'note' property of the entity
    $temoignage->setNote((int)$note);
            $entityManager->persist($temoignage);
            $entityManager->flush();

            return $this->redirectToRoute('accueil_app', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('temoignage/new.html.twig', [
            'temoignage' => $temoignage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_temoignage_show', methods: ['GET'])]
    public function show(Temoignage $temoignage): Response
    {
        return $this->render('temoignage/show.html.twig', [
            'temoignage' => $temoignage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_temoignage_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Temoignage $temoignage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TemoignageType::class, $temoignage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_temoignage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('temoignage/edit.html.twig', [
            'temoignage' => $temoignage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_temoignage_delete', methods: ['POST'])]
    public function delete(Request $request, Temoignage $temoignage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$temoignage->getId(), $request->request->get('_token'))) {
            $entityManager->remove($temoignage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_temoignage_index', [], Response::HTTP_SEE_OTHER);
    }
}
