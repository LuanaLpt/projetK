<?php

namespace App\Controller;

use App\Entity\Art;
use App\Form\ArtType;
use App\Repository\ArtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function dashboard(ArtRepository $artRepository): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'projets' => $artRepository->findBy(['type' => 'Projet']),
            'produits' => $artRepository->findBy(['type' => 'Produit']),
        ]);
    }
    #[Route('/admin/dashboard/delete/{id}', name: 'app_admin_delete', methods: ['GET', 'POST'])]
    public function deleteArt(Art $art,
                              EntityManagerInterface $entityManager): Response
    {
        foreach (array_merge($art->getMainImages()->toArray(), $art->getTransiImages()->toArray()) as $image) {
            $filePath = $this->getParameter('images_directory') . '/' . $image->getFilename();
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $entityManager->remove($art);
        $entityManager->flush();

        $this->addFlash('success', 'Le projet ou produit ont été supprimés !');

        return $this->redirectToRoute('admin_dashboard');
    }
    #[Route('/admin/dashboard/edit/{id}', name: 'app_admin_edit', methods: ['GET', 'POST'])]
    public function editDashboard(Art $art,
                                  Request $request,
                                  EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtType::class, $art);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mainImages = $form->get('mainImages')->getData();
            $transiImages = $form->get('transiImages')->getData();

            if ($mainImages) {
                foreach ($art->getMainImages() as $oldMainImage) {
                    $oldFilePath = $this->getParameter('images_directory') . '/' . $oldMainImage->getFilename();
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                    $entityManager->remove($oldMainImage);
                }


                foreach ($mainImages as $mainImageFile) {
                    $newFileName = uniqid() . '.' . $mainImageFile->guessExtension();
                    $mainImageFile->move($this->getParameter('images_directory'), $newFileName);

                    $mainImageEntity = new \App\Entity\MainImage();
                    $mainImageEntity->setFilename($newFileName);
                    $mainImageEntity->setArt($art);
                    $art->addMainImage($mainImageEntity);
                    $entityManager->persist($mainImageEntity);
                }
            }

            if ($transiImages) {
                foreach ($art->getTransiImages() as $oldTransiImage) {
                    $oldFilePath = $this->getParameter('images_directory') . '/' . $oldTransiImage->getFilename();
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                    $entityManager->remove($oldTransiImage);
                }

                foreach ($transiImages as $transiImageFile) {
                    $newFileName = uniqid() . '.' . $transiImageFile->guessExtension();
                    $transiImageFile->move($this->getParameter('images_directory'), $newFileName);

                    $transiImageEntity = new \App\Entity\TransiImage();
                    $transiImageEntity->setFilename($newFileName);
                    $transiImageEntity->setArt($art);
                    $art->addTransiImage($transiImageEntity);
                    $entityManager->persist($transiImageEntity);
                }
            }

            $entityManager->flush();
            $this->addFlash('success', 'L\'œuvre a bien été modifiée !');

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/nouveau.html.twig', [
            'artForm' => $form->createView(),
            'art' => $art
        ]);
    }


    #[Route('/admin/art/nouveau', name: 'app_admin_art_new', methods: ['GET', 'POST'])]
    public function nouveau(Request $request,
                            EntityManagerInterface $entityManager): Response
    {
        $art = new Art();
        $form = $this->createForm(ArtType::class, $art);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mainImages = $form->get('mainImages')->getData();
            $transiImages = $form->get('transiImages')->getData();
            if($mainImages){
                foreach ($mainImages as $mainImageFile) {
                    $newFileName = uniqid() . '.' . $mainImageFile->guessExtension();
                    $mainImageFile->move($this->getParameter('images_directory'), $newFileName);

                    $mainImageEntity = new \App\Entity\MainImage();
                    $mainImageEntity->setFilename($newFileName);
                    $mainImageEntity->setArt($art);
                    $art->addMainImage($mainImageEntity);
                    $entityManager->persist($mainImageEntity);
                }
            }
            if($transiImages){
                foreach ($transiImages as $transiImageFile) {
                    $newFileName = uniqid() . '.' . $transiImageFile->guessExtension();
                    $transiImageFile->move($this->getParameter('images_directory'), $newFileName);

                    $transiImageEntity = new \App\Entity\TransiImage();
                    $transiImageEntity->setFilename($newFileName);
                    $transiImageEntity->setArt($art);
                    $art->addTransiImage($transiImageEntity);
                    $entityManager->persist($transiImageEntity);
                }
            }

            $entityManager->persist($art);
            $entityManager->flush();
            $this->addFlash('success', 'L\'œuvre a bien été publiée !');
            return $this->redirectToRoute('app_admin_art_new');
        }
        return $this->render('admin/nouveau.html.twig', [
            'artForm' => $form->createView(),
        ]);
    }
}
