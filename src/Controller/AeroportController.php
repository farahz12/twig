<?php

namespace App\Controller;

use App\Entity\Aeroport;
use App\Form\AeroportType;
use App\Repository\AeroportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AeroportController extends AbstractController
{
    #[Route('/aeroports', name: 'list_aeroports')]
    public function listAeroports(AeroportRepository $aeroportRepository): Response
    {
        $aeroports = $aeroportRepository->findAll();

        return $this->render('aeroport/list.html.twig', [
            'aeroports' => $aeroports,
        ]);
    }

    #[Route('/aeroport/add', name: 'add_aeroport')]
    public function addAeroport(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aeroport = new Aeroport();
        $form = $this->createForm(AeroportType::class, $aeroport);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aeroport);
            $entityManager->flush();

            return $this->redirectToRoute('list_aeroports');
        }

        return $this->renderForm('aeroport/add.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/aeroport/edit/{id}', name: 'edit_aeroport')]
public function editAeroport(Request $request, Aeroport $aeroport, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(AeroportType::class, $aeroport);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('list_aeroports');
    }

    return $this->renderForm('aeroport/edit.html.twig', [
        'form' => $form,
        'aeroport' => $aeroport,
    ]);
}

}
