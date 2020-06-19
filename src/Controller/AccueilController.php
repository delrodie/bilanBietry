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
        $this->utility->getSession();
        return $this->redirectToRoute('experience_new');
    }

    /**
     * @Route("/bilan/formulaire", name="bilan_fin")
     */
    public function bilan()
    {
        //Verification de la session
        $this->utility->getSession();
        
        return $this->render("accueil/index.html.twig");
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
