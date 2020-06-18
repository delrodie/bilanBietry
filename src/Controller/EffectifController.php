<?php

namespace App\Controller;

use App\Entity\Effectif;
use App\Form\EffectifType;
use App\Repository\ActiviteRepository;
use App\Repository\EffectifRepository;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/effectif")
 */
class EffectifController extends AbstractController
{
    private $activiteRepository;
    private $utility;

    public function __construct(ActiviteRepository $activiteRepository, Utility $utility)
    {
        $this->activiteRepository = $activiteRepository;
        $this->utility = $utility;
    }

    /**
     * @Route("/", name="effectif_index", methods={"GET"})
     */
    public function index(EffectifRepository $effectifRepository): Response
    {
        return $this->render('effectif/index.html.twig', [
            'effectifs' => $effectifRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{activite}/new", name="effectif_new", methods={"GET","POST"})
     */
    public function new(Request $request, $activite): Response
    {
        $effectif = new Effectif();
        $form = $this->createForm(EffectifType::class, $effectif,['activite'=>$activite]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($effectif);
            $entityManager->flush();

            // MAJ du flag
            $this->utility->addFlag($activite, 2);

            return $this->redirectToRoute('effectif_index');
        }


        return $this->render('effectif/new.html.twig', [
            'effectif' => $effectif,
            'activite' => $this->activiteRepository->findOneBy(['id'=>$activite]),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="effectif_show", methods={"GET"})
     */
    public function show(Effectif $effectif): Response
    {
        return $this->render('effectif/show.html.twig', [
            'effectif' => $effectif,
        ]);
    }

    /**
     * @Route("/{id}/edit/{activite}", name="effectif_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Effectif $effectif, $activite): Response
    {
        $form = $this->createForm(EffectifType::class, $effectif, ['activite'=>$activite]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('effectif_index');
        }

        return $this->render('effectif/edit.html.twig', [
            'effectif' => $effectif,
            'activite' => $this->activiteRepository->findOneBy(['id'=>$activite]),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="effectif_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Effectif $effectif): Response
    {
        if ($this->isCsrfTokenValid('delete'.$effectif->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($effectif);
            $entityManager->flush();
        }

        return $this->redirectToRoute('effectif_index');
    }
}
