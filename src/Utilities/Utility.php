<?php


namespace App\Utilities;


use App\Repository\ExperienceRepository;
use Doctrine\ORM\EntityManagerInterface;

class Utility
{
    private $experienceRepository;
    private $em;

    public function __construct(ExperienceRepository $experienceRepository, EntityManagerInterface $em)
    {
        $this->experienceRepository = $experienceRepository;
        $this->em = $em;
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
            $experience = $this->experienceRepository->findOneBy(['id'=>$id]);
            $experience->setFlag($flag);
        }elseif ($flag === 2){
            $experience = $this->experienceRepository->findOneBy(['id'=>$id]);
            $experience->setFlag($flag);
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