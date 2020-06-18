<?php

namespace App\Controller;

use App\Entity\Fonctionnement;
use App\Form\FonctionnementType;
use App\Repository\FonctionnementRepository;
use App\Repository\ImageRepository;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fonctionnement")
 */
class FonctionnementController extends AbstractController
{
    private $utility;
    private $imageRepository;

    public function __construct(Utility $utility, ImageRepository $imageRepository)
    {
        $this->utility = $utility;
        $this->imageRepository= $imageRepository;
    }

    /**
     * @Route("/", name="fonctionnement_index", methods={"GET"})
     */
    public function index(FonctionnementRepository $fonctionnementRepository): Response
    {
        return $this->render('fonctionnement/index.html.twig', [
            'fonctionnements' => $fonctionnementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{image}/new", name="fonctionnement_new", methods={"GET","POST"})
     */
    public function new(Request $request, $image): Response
    {
        $fonctionnement = new Fonctionnement();
        $form = $this->createForm(FonctionnementType::class, $fonctionnement,['image'=>$image]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fonctionnement);
            $entityManager->flush();

            $this->utility->addFlag($image, 4);

            return $this->redirectToRoute('bilan_fin');
        }

        return $this->render('fonctionnement/new.html.twig', [
            'fonctionnement' => $fonctionnement,
            'image' => $this->imageRepository->findOneBy(['id'=>$image]),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fonctionnement_show", methods={"GET"})
     */
    public function show(Fonctionnement $fonctionnement): Response
    {
        return $this->render('fonctionnement/show.html.twig', [
            'fonctionnement' => $fonctionnement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fonctionnement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fonctionnement $fonctionnement): Response
    {
        $form = $this->createForm(FonctionnementType::class, $fonctionnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fonctionnement_index');
        }

        return $this->render('fonctionnement/edit.html.twig', [
            'fonctionnement' => $fonctionnement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fonctionnement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Fonctionnement $fonctionnement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fonctionnement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fonctionnement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fonctionnement_index');
    }
}
