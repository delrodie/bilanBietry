<?php


namespace App\Utilities;


use App\Repository\ExperienceRepository;

class Utility
{
    private $experienceRepository;

    public function __construct(ExperienceRepository $experienceRepository)
    {
        $this->experienceRepository = $experienceRepository;


    }
}