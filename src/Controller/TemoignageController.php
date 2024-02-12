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


class TemoignageController extends AbstractController
{

    #[Route('employe/temoignage', name: 'app_temoignage_index', methods: ['GET'])]
    public function index(TemoignageRepository $temoignageRepository): Response
    {
        return $this->render('temoignage/index.html.twig', [
            'temoignages' => $temoignageRepository->findAll(),
        ]);
    }



    #[Route('temoignage/new', name: 'app_temoignage_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $temoignage = new Temoignage();
        $form = $this->createForm(TemoignageType::class, $temoignage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $note = $request->request->get('note');

            if (empty($note)) {
                $note = 0;
            }

            $temoignage->setNote((int)$note);

            if ($temoignage->getEtat() === null) {
                $temoignage->setEtat(0);
            }

            $entityManager->persist($temoignage);
            $entityManager->flush();

            return $this->redirectToRoute('accueil_app', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('temoignage/new.html.twig', [
            'temoignage' => $temoignage,
            'form' => $form,
        ]);
    }





    #[Route('employe/temoignage/{id}/edit', name: 'app_temoignage_edit', methods: ['GET', 'POST'])]
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




    #[Route('employe/temoignage/{id}', name: 'app_temoignage_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Temoignage $temoignage, EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($temoignage);
        $entityManager->flush();


        return $this->redirectToRoute('app_temoignage_index', [], Response::HTTP_SEE_OTHER);
    }




    #[Route('employe/temoignage/temoignage/{id}/accept', name: 'app_temoignage_accept', methods: ['GET'])]
    public function accept(Temoignage $temoignage, EntityManagerInterface $entityManager): Response
    {
        $temoignage->setEtat(1);
        $entityManager->flush();


        return $this->redirectToRoute('app_temoignage_index');
    }
}
