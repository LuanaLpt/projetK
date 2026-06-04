<?php

namespace App\Controller;

use App\Entity\Art;
use App\Form\ArtType;
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
    #[Route('/admin/art/nouveau', name: 'app_admin_art_new', methods: ['GET', 'POST'])]
    public function nouveau(Request $request, EntityManagerInterface $entityManager): Response
    {
        $art = new Art();
        $form = $this->createForm(ArtType::class, $art);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mainImages = $form->get('mainImages')->getData();
            $transiImages = $form->get('transiImages')->getData();
            if($mainImages){
                foreach ($mainImages as $mainImage) {
                    $newFileName = uniqid() . '.' . $mainImage->guessExtension();
                    $mainImage->move($this->getParameter('art_directory'), $newFileName);

                    $mainImage = new \App\Entity\MainImage();
                    $mainImage->setFilename($newFileName);
                    $art->addMainImage($mainImage);
                    $entityManager->persist($mainImage);
                }
            }
            if($transiImages){
                foreach ($transiImages as $transiImage) {
                    $newFileName = uniqid() . '.' . $transiImage->guessExtension();
                    $transiImage->move($this->getParameter('art_directory'), $newFileName);

                    $transiImage = new \App\Entity\TransiImage();
                    $transiImage->setFilename($newFileName);
                    $art->addTransiImage($transiImage);
                    $entityManager->persist($transiImage);
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
