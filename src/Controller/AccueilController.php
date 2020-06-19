<?php

namespace App\Controller;

use App\Utilities\GestionLog;
use App\Utilities\GestionMail;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    private $gestMail;
    private $log;
    private $utility;

    public function __construct(GestionMail $gestionMail, GestionLog $log, Utility $utility)
    {
        $this->gestMail= $gestionMail;
        $this->log = $log;
        $this->utility = $utility;
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
    public function bilan()
    {
        //Verification de la session
        $encours = $this->utility->getSession();
        if ($encours){
            return $this->render("accueil/index.html.twig");
        }else{
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
