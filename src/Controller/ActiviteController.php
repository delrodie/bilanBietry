<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use App\Repository\EffectifRepository;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activite")
 */
class ActiviteController extends AbstractController
{
    private $utility;
    private $effectifRepository;

    public function __construct(Utility $utility, EffectifRepository $effectifRepository)
    {
        $this->utility = $utility;
        $this->effectifRepository = $effectifRepository;
    }

    /**
     * @Route("/", name="activite_index", methods={"GET"})
     */
    public function index(ActiviteRepository $activiteRepository): Response
    {
        return $this->render('activite/index.html.twig', [
            'activites' => $activiteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{experience}/new/", name="activite_new", methods={"GET","POST"})
     */
    public function new(Request $request, $experience): Response
    {
        $this->utility->getSession();

        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite,['experience'=>$experience]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activite);
            $entityManager->flush();

            // Mise a jour du flag
            $this->utility->addFlag($activite->getExperience()->getId(), 1);

            return $this->redirectToRoute('effectif_new',['activite'=>$activite->getId()]);
        }

        return $this->render('activite/new.html.twig', [
            'activite' => $activite,
            'experience' => $experience,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activite_show", methods={"GET"})
     */
    public function show(Activite $activite): Response
    {
        return $this->render('activite/show.html.twig', [
            'activite' => $activite,
        ]);
    }

    /**
     * @Route("/{id}/edit/{experience}", name="activite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Activite $activite, $experience): Response
    {
        $form = $this->createForm(ActiviteType::class, $activite, ['experience' => $experience]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            // Si une activité est lée a cette experience redirigé vers edit sinon new
            $effectif = $this->effectifRepository->findOneBy(['activite'=>$activite->getId()]);
            if ($effectif)
                return $this->redirectToRoute('effectif_edit',['id'=> $effectif->getId(),'activite' => $activite->getId()]);
            else
                return $this->redirectToRoute('effectif_new',['activite' => $activite->getId()]);

        }

        return $this->render('activite/edit.html.twig', [
            'activite' => $activite,
            'experience' => $experience,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Activite $activite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('activite_index');
    }
}
