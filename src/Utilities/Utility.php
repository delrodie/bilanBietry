<?php


namespace App\Utilities;


use App\Repository\ActiviteRepository;
use App\Repository\EffectifRepository;
use App\Repository\ExperienceRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;

class Utility
{
    private $experienceRepository;
    private $em;
    private $activiteRepository;
    private $imageRepository;
    private $effectifRepository;

    public function __construct(ExperienceRepository $experienceRepository, EntityManagerInterface $em, ActiviteRepository $activiteRepository, ImageRepository$imageRepository, EffectifRepository $effectifRepository)
    {
        $this->experienceRepository = $experienceRepository;
        $this->em = $em;
        $this->activiteRepository = $activiteRepository;
        $this->imageRepository = $imageRepository;
        $this->effectifRepository = $effectifRepository;
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
            $experience = $this->experienceRepository->findOneBy(['id'=>$id]);
            $experience->setFlag($flag);
        }elseif ($flag === 3){
            $effectif = $this->effectifRepository->findOneBy(['id'=>$id]);
            $activite = $this->activiteRepository->findOneBy(['id'=>$effectif->getId()]);
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
}