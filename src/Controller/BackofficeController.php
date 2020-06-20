<?php


namespace App\Controller;


use App\Repository\ActiviteRepository;
use App\Repository\EffectifRepository;
use App\Repository\ExperienceRepository;
use App\Repository\FonctionnementRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BackofficeController
 * @Route("/backoffice")
 */
class BackofficeController extends AbstractController
{
    private $experienceRepository;
    private $activiteRepository;
    private $effectifRepository;
    private $imageRepository;
    private $fonctionnementRepository;

    public function __construct(ExperienceRepository $experienceRepository, ActiviteRepository $activiteRepository, EffectifRepository $effectifRepository, ImageRepository $imageRepository, FonctionnementRepository $fonctionnementRepository)
    {
        $this->experienceRepository = $experienceRepository;
        $this->activiteRepository = $activiteRepository;
        $this->effectifRepository = $effectifRepository;
        $this->imageRepository = $imageRepository;
        $this->fonctionnementRepository = $fonctionnementRepository;
    }

    /**
     * @Route("/", name="tableau_bord")
     */
    public function tbord()
    {
        return $this->render("accueil/backend_index.html.twig",[
            'experiences' => $this->experienceRepository->findBy(['flag'=>4]),
            'activites' => $this->activiteRepository->findBy(['flag'=>3]),
            'effectifs' => $this->effectifRepository->findBy(['flag'=>2]),
            'images' => $this->imageRepository->findBy(['flag'=>1]),
            'fonctionnements' => $this->fonctionnementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{experienceID}", name="formulaire_reponse", methods={"GET"})
     */
    public function reponse(Request $request, $experienceID)
    {
        $experience = $this->experienceRepository->findOneBy(['id'=>$experienceID]);
        $activite = $this->activiteRepository->findOneBy(['experience'=>$experience->getId()]);
        $effectif = $this->effectifRepository->findOneBy(['activite'=>$activite->getId()]);
        $image = $this->imageRepository->findOneBy(['effectif'=>$effectif->getId()]);
        $fonctionnement = $this->fonctionnementRepository->findOneBy(['image'=>$image->getId()]);

        return $this->render("accueil/backend_reponse.html.twig",[
            'experience' => $experience,
            'activite' => $activite,
            'effectif' => $effectif,
            'image' => $image,
            'fonctionnement' => $fonctionnement
        ]);
    }
}