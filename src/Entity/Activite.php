<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActiviteRepository")
 */
class Activite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q1;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q2;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q3;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q4;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q5;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q6;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q7;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q8;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q9;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q10;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q11;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $flag;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Experience", cascade={"persist", "remove"})
     */
    private $experience;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Effectif", mappedBy="activite", cascade={"persist", "remove"})
     */
    private $effectif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQ1(): ?bool
    {
        return $this->q1;
    }

    public function setQ1(?bool $q1): self
    {
        $this->q1 = $q1;

        return $this;
    }

    public function getQ2(): ?bool
    {
        return $this->q2;
    }

    public function setQ2(?bool $q2): self
    {
        $this->q2 = $q2;

        return $this;
    }

    public function getQ3(): ?bool
    {
        return $this->q3;
    }

    public function setQ3(?bool $q3): self
    {
        $this->q3 = $q3;

        return $this;
    }

    public function getQ4(): ?bool
    {
        return $this->q4;
    }

    public function setQ4(?bool $q4): self
    {
        $this->q4 = $q4;

        return $this;
    }

    public function getQ5(): ?bool
    {
        return $this->q5;
    }

    public function setQ5(?bool $q5): self
    {
        $this->q5 = $q5;

        return $this;
    }

    public function getQ6(): ?bool
    {
        return $this->q6;
    }

    public function setQ6(?bool $q6): self
    {
        $this->q6 = $q6;

        return $this;
    }

    public function getQ7(): ?bool
    {
        return $this->q7;
    }

    public function setQ7(?bool $q7): self
    {
        $this->q7 = $q7;

        return $this;
    }

    public function getQ8(): ?bool
    {
        return $this->q8;
    }

    public function setQ8(?bool $q8): self
    {
        $this->q8 = $q8;

        return $this;
    }

    public function getQ9(): ?bool
    {
        return $this->q9;
    }

    public function setQ9(?bool $q9): self
    {
        $this->q9 = $q9;

        return $this;
    }

    public function getQ10(): ?bool
    {
        return $this->q10;
    }

    public function setQ10(?bool $q10): self
    {
        $this->q10 = $q10;

        return $this;
    }

    public function getQ11(): ?bool
    {
        return $this->q11;
    }

    public function setQ11(?bool $q11): self
    {
        $this->q11 = $q11;

        return $this;
    }

    public function getFlag(): ?int
    {
        return $this->flag;
    }

    public function setFlag(?int $flag): self
    {
        $this->flag = $flag;

        return $this;
    }

    public function getExperience(): ?Experience
    {
        return $this->experience;
    }

    public function setExperience(?Experience $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getEffectif(): ?Effectif
    {
        return $this->effectif;
    }

    public function setEffectif(?Effectif $effectif): self
    {
        $this->effectif = $effectif;

        // set (or unset) the owning side of the relation if necessary
        $newActivite = null === $effectif ? null : $this;
        if ($effectif->getActivite() !== $newActivite) {
            $effectif->setActivite($newActivite);
        }

        return $this;
    }
}
