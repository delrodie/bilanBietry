<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Form\ExperienceType;
use App\Repository\ActiviteRepository;
use App\Repository\EffectifRepository;
use App\Repository\ExperienceRepository;
use App\Repository\ImageRepository;
use App\Utilities\Utility;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/experience")
 */
class ExperienceController extends AbstractController
{
    private $activiteReposiroty;
    private $imageRepository;
    private $effectifRepository;
    private $experienceRepository;
    private $utility;

    public function __construct(ActiviteRepository $activiteRepository,ExperienceRepository $experienceRepository, EntityManagerInterface $em, ImageRepository$imageRepository, EffectifRepository $effectifRepository, Utility $utility)
    {
        $this->activiteReposiroty = $activiteRepository;
        $this->imageRepository = $imageRepository;
        $this->effectifRepository = $effectifRepository;
        $this->experienceRepository = $experienceRepository;
        $this->utility = $utility;
    }

    /**
     * @Route("/", name="experience_index", methods={"GET"})
     */
    public function index(ExperienceRepository $experienceRepository): Response
    {
        return $this->render('experience/index.html.twig', [
            'experiences' => $experienceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="experience_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        // Verification de session
        $encours = $this->utility->getSession(); //dd($encours);
        if ($encours['flag']){
            if ($encours['flag'] === 1){
                $activite = $this->activiteReposiroty->findOneBy(['experience'=>$encours['id']]);
                return $this->redirectToRoute('effectif_new',['activite'=>$activite->getId()]);
            }elseif ($encours['flag'] === 2){
                $activite = $this->activiteReposiroty->findOneBy(['experience'=>$encours['id']]);
                $effectif = $this->effectifRepository->findOneBy(['activite'=>$activite->getId()]);
                return $this->redirectToRoute('image_new',['effectif'=>$effectif->getId()]);
            }elseif ($encours['flag'] === 3){
                $activite = $this->activiteReposiroty->findOneBy(['experience'=>$encours['id']]);
                $effectif = $this->effectifRepository->findOneBy(['activite'=>$activite->getId()]);
                $image = $this->imageRepository->findOneBy(['effectif'=>$effectif->getId()]);
                return $this->redirectToRoute('fonctionnement_new',['image'=>$image->getId()]);
            }else{
                return $this->redirectToRoute('bilan_fin');
            }
        }

        $experience = new Experience();
        $form = $this->createForm(ExperienceType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($experience);
            $entityManager->flush();

            // Initialisation de la session
            $this->utility->setSession($experience->getId());

            return $this->redirectToRoute('activite_new',['experience' => $experience->getId()]);
        }

        return $this->render('experience/new.html.twig', [
            'experience' => $experience,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="experience_show", methods={"GET"})
     */
    public function show(Experience $experience): Response
    {
        return $this->render('experience/show.html.twig', [
            'experience' => $experience,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="experience_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Experience $experience): Response
    {
        $form = $this->createForm(ExperienceType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            // Si une activité est lée a cette experience redirigé vers edit sinon new
            $activite = $this->activiteReposiroty->findOneBy(['experience'=>$experience->getId()]);
            if ($activite)
                return $this->redirectToRoute('activite_edit',['id'=> $activite->getId(),'experience' => $experience->getId()]);
            else
                return $this->redirectToRoute('activite_new',['experience' => $experience->getId()]);

        }

        return $this->render('experience/edit.html.twig', [
            'experience' => $experience,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="experience_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Experience $experience): Response
    {
        if ($this->isCsrfTokenValid('delete'.$experience->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($experience);
            $entityManager->flush();
        }

        return $this->redirectToRoute('experience_index');
    }
}
