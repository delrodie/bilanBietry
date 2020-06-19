<?php


namespace App\Utilities;


use App\Repository\ActiviteRepository;
use App\Repository\EffectifRepository;
use App\Repository\ExperienceRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;

class Utility
{
    private $experienceRepository;
    private $em;
    private $activiteRepository;
    private $imageRepository;
    private $effectifRepository;
    private $session;
    private $router;

    public function __construct(ExperienceRepository $experienceRepository, EntityManagerInterface $em, ActiviteRepository $activiteRepository, ImageRepository$imageRepository, EffectifRepository $effectifRepository, SessionInterface $session, RouterInterface $router)
    {
        $this->experienceRepository = $experienceRepository;
        $this->em = $em;
        $this->activiteRepository = $activiteRepository;
        $this->imageRepository = $imageRepository;
        $this->effectifRepository = $effectifRepository;
        $this->session = $session;
        $this->router = $router;
    }

    /**
     * Mise a jour du flag dans les différentes tables
     *
     * @param $id
     * @param $flag
     * @return bool
     */
    public function addFlag($id, $flag)
    {
        // Si le flag est 4 alors mise a jour des différentes tables sinon la table experience
        if ($flag === 4){
            $image = $this->imageRepository->findOneBy(['id'=>$id]);
            $effectif = $this->effectifRepository->findOneBy(['id'=>$image->getEffectif()->getId()]);
            $activite = $this->activiteRepository->findOneBy(['id'=>$effectif->getActivite()->getId()]);
            $experience = $this->experienceRepository->findOneBy(['id'=>$activite->getExperience()->getId()]);
            $experience->setFlag($flag);
            $activite->setFlag(3);
            $effectif->setFlag(2);
            $image->setFlag(1);
        }elseif ($flag === 3){
            $effectif = $this->effectifRepository->findOneBy(['id'=>$id]);
            $activite = $this->activiteRepository->findOneBy(['id'=>$effectif->getActivite()->getId()]);
            $experience = $this->experienceRepository->findOneBy(['id'=>$activite->getExperience()->getId()]);
            $experience->setFlag($flag);
            $activite->setFlag(2);
            $effectif->setFlag(1);
        }elseif ($flag === 2){
            $activite = $this->activiteRepository->findOneBy(['id'=>$id]);
            $experience = $this->experienceRepository->findOneBy(['id'=>$activite->getExperience()->getId()]);
            $experience->setFlag($flag);
            $activite->setFlag(1);
        }elseif ($flag === 1){
            $experience = $this->experienceRepository->findOneBy(['id'=>$id]);
            $experience->setFlag($flag);
        }else{
            return false;
        }

        $this->em->flush();

        return true;

    }

    /**
     * @param $experience
     * @return bool
     */
    public function setSession($experience)
    {
        $this->session->set('encours', $experience);

        return true;
    }

    /**
     * Recuperation dela session
     *
     * @return RedirectResponse
     */
    public function getSession()
    {
        $id = $this->session->get('encours');
        $experience = $this->experienceRepository->findOneBy(['id'=>$id]) ;

        // Si aucune experience alors initialiser le remplissage du formulaire
        // sinon rediriger vers le formulaire adequat
        if (!$experience){
            return new RedirectResponse($this->router->generate('experience_new'));
        }else{
            $flag = $experience->getFlag();
            if ($flag === 1){
                return new RedirectResponse($this->router->generate('activite_new',['experience'=>$experience->getId()]));
            }elseif($flag === 2){
                $activite = $this->activiteRepository->findOneBy(['experience'=>$experience->getId()]);
                return new RedirectResponse($this->router->generate('effectif_new',['activite'=>$activite->getId()]));
            }elseif($flag === 3){
                $activite = $this->activiteRepository->findOneBy(['experience'=>$experience->getId()]);
                $effectif = $this->effectifRepository->findOneBy(['activite'=>$activite->getId()]);
                return  new RedirectResponse($this->router->generate('image_new',['effectif'=>$effectif->getId()]));
            }elseif($flag === 4){
                $activite = $this->activiteRepository->findOneBy(['experience'=>$experience->getId()]);
                $effectif = $this->effectifRepository->findOneBy(['activite'=>$activite->getId()]);
                $image = $this->imageRepository->findOneBy(['effectif'=>$effectif->getId()]);
                return new RedirectResponse($this->router->generate('fonctionnement_new',['image'=>$image->getId()]));
            }else{
                return new RedirectResponse($this->router->generate('app_accueil'));
            }
        }
    }
}