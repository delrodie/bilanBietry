<?php

namespace App\Controller;

use App\Repository\ActiviteRepository;
use App\Repository\EffectifRepository;
use App\Repository\ExperienceRepository;
use App\Repository\ImageRepository;
use App\Utilities\GestionLog;
use App\Utilities\GestionMail;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    private $gestMail;
    private $log;
    private $utility;
    private $activiteReposiroty;
    private $imageRepository;
    private $effectifRepository;
    private $experienceRepository;

    public function __construct(GestionMail $gestionMail, GestionLog $log, Utility $utility, ActiviteRepository $activiteRepository,ExperienceRepository $experienceRepository, ImageRepository$imageRepository, EffectifRepository $effectifRepository)
    {
        $this->gestMail= $gestionMail;
        $this->log = $log;
        $this->utility = $utility;
        $this->activiteReposiroty = $activiteRepository;
        $this->imageRepository = $imageRepository;
        $this->effectifRepository = $effectifRepository;
        $this->experienceRepository = $experienceRepository;
    }

    /**
     * @Route("/", name="app_accueil")
     */
    public function index()
    {
        //$this->utility->getSession();
        return $this->redirectToRoute('experience_new');
    }

    /**
     * @Route("/bilan/formulaire", name="bilan_fin")
     */
    public function bilan() : Response
    {
        //Verification de la session
        $encours = $this->utility->getSession();
        if (!$encours){
            return $this->redirectToRoute('experience_new');
        }

        return $this->render('accueil/index.html.twig');

    }

    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function dashboard(Request $request)
    {
        $user = $this->getUser();
        $this->log->addLog($user, 'dashboard', $request->getClientIp());
        return $this->render("accueil/index.html.twig");
    }
}
