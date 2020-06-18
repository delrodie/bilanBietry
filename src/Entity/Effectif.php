<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EffectifRepository")
 */
class Effectif
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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q12;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q13;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q14;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q15;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $q16;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $flag;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Activite", inversedBy="effectif", cascade={"persist", "remove"})
     */
    private $activite;

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

    public function getQ12(): ?bool
    {
        return $this->q12;
    }

    public function setQ12(?bool $q12): self
    {
        $this->q12 = $q12;

        return $this;
    }

    public function getQ13(): ?bool
    {
        return $this->q13;
    }

    public function setQ13(?bool $q13): self
    {
        $this->q13 = $q13;

        return $this;
    }

    public function getQ14(): ?bool
    {
        return $this->q14;
    }

    public function setQ14(?bool $q14): self
    {
        $this->q14 = $q14;

        return $this;
    }

    public function getQ15(): ?bool
    {
        return $this->q15;
    }

    public function setQ15(?bool $q15): self
    {
        $this->q15 = $q15;

        return $this;
    }

    public function getQ16(): ?bool
    {
        return $this->q16;
    }

    public function setQ16(?bool $q16): self
    {
        $this->q16 = $q16;

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

    public function getActivite(): ?Activite
    {
        return $this->activite;
    }

    public function setActivite(?Activite $activite): self
    {
        $this->activite = $activite;

        return $this;
    }
}
