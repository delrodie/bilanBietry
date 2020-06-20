<?php


namespace App\Utilities;




use App\Repository\ActiviteRepository;
use App\Repository\EffectifRepository;
use App\Repository\ExperienceRepository;
use App\Repository\FonctionnementRepository;
use App\Repository\ImageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Twig\Environment;

class GestionMail
{
    private $swift_mail;
    private $template;
    private $experienceRepository;
    private $activiteRepository;
    private $effectifRepository;
    private $imageRepository;
    private $fonctionnementRepository;

    public function __construct(\Swift_Mailer $swift_mail, Environment $template, ExperienceRepository $experienceRepository, ActiviteRepository $activiteRepository, EffectifRepository $effectifRepository, ImageRepository $imageRepository, FonctionnementRepository $fonctionnementRepository)
    {
        $this->swift_mail= $swift_mail;
        $this->template = $template;
        $this->experienceRepository = $experienceRepository;
        $this->activiteRepository = $activiteRepository;
        $this->effectifRepository = $effectifRepository;
        $this->imageRepository = $imageRepository;
        $this->fonctionnementRepository = $fonctionnementRepository;
    }

    /**
     * Envoie de mail apres action
     *
     * @param $objet
     * @param $
     * @param null $code
     * @return bool
     */
    public function envoiMail($id)
    {
        $objet = "FORMULAIRE DU BILAN DE SANTE DU CLUB N0: ".$id;
        $experience = $this->experienceRepository->findOneBy(['id'=>$id]);
        $activite = $this->activiteRepository->findOneBy(['experience'=>$experience->getId()]);
        $effectif = $this->effectifRepository->findOneBy(['activite'=>$activite->getId()]);
        $image = $this->imageRepository->findOneBy(['effectif'=>$effectif->getId()]);
        $fonctionnement = $this->fonctionnementRepository->findOneBy(['image'=>$image->getId()]);
        // Envoi de mail de
        $email = (new \Swift_Message($objet))
            ->setFrom('delrodieamoikon@gmail.com')
            ->setTo('delrodieamoikon@gmail.com')
            ->setBody(
                $this->template->render('accueil/mail.html.twig',[
                    'experience' => $experience,
                    'activite' => $activite,
                    'effectif' => $effectif,
                    'image' => $image,
                    'fonctionnement' => $fonctionnement
                ]),
                'text/html'
            )
            ;
        $this->swift_mail->send($email);

        return true;
    }

    /**
     * Les messages pour l'envoi de mail
     * 0 = Message de confirmation de creation de compte
     *
     * @param $code
     * @return string
     */
    protected function contenu($code):?string
    {
        $confirmation = "Votre inscription a été effectuée avec succès";
        $default = "l'utilisateur est connecté";

        switch ($code){
            case 0:
                $contenu = $confirmation;
                break;
            default:
                $contenu = $default;
                break;
        }

        return $contenu;
    }
}