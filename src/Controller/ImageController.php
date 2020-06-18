<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\EffectifRepository;
use App\Repository\FonctionnementRepository;
use App\Repository\ImageRepository;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/image")
 */
class ImageController extends AbstractController
{
    private $effectifRepositif;
    private $utility;
    private $fonctionnementRepository;

    public function __construct(EffectifRepository $effectifRepository, Utility $utility, FonctionnementRepository $fonctionnementRepository)
    {
        $this->effectifRepositif = $effectifRepository;
        $this->utility = $utility;
        $this->fonctionnementRepository = $fonctionnementRepository;
    }

    /**
     * @Route("/", name="image_index", methods={"GET"})
     */
    public function index(ImageRepository $imageRepository): Response
    {
        return $this->render('image/index.html.twig', [
            'images' => $imageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{effectif}/new", name="image_new", methods={"GET","POST"})
     */
    public function new(Request $request, $effectif): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image, ['effectif'=>$effectif]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            $this->utility->addFlag($effectif, 3);

            return $this->redirectToRoute('fonctionnement_new',['image'=>$image->getId()]);
        }

        return $this->render('image/new.html.twig', [
            'image' => $image,
            'effectif' => $this->effectifRepositif->findOneBy(['id'=>$effectif]),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="image_show", methods={"GET"})
     */
    public function show(Image $image): Response
    {
        return $this->render('image/show.html.twig', [
            'image' => $image,
        ]);
    }

    /**
     * @Route("/{id}/edit/{effectif}", name="image_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Image $image, $effectif): Response
    {
        $form = $this->createForm(ImageType::class, $image,['effectif'=>$effectif]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            // Si une activité est lée a cette experience redirigé vers edit sinon new
            $fonctionnement = $this->fonctionnementRepository->findOneBy(['image'=>$image->getId()]);
            if ($fonctionnement)
                return $this->redirectToRoute('fonctionnement_edit',['id'=> $fonctionnement->getId(),'image' => $image->getId()]);
            else
                return $this->redirectToRoute('fonctionnement_new',['image' => $image->getId()]);
        }

        return $this->render('image/edit.html.twig', [
            'image' => $image,
            'effectif' => $this->effectifRepositif->findOneBy(['id'=>$effectif]),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="image_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Image $image): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('image_index');
    }
}
