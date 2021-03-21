<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonneRepository::class)
 */
class Personne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=60, nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="Serie", mappedBy="scenariste")
     */
    private $seriesEcrite;

    /**
     * @ORM\OneToMany(targetEntity="Serie", mappedBy="dessinateur")
     */
    private $seriesDessiner;

    /**
     * @return mixed
     */
    public function getSeriesEcrite()
    {
        return $this->seriesEcrite;
    }

    /**
     * @param mixed $seriesEcrite
     */
    public function setSeriesEcrite($seriesEcrite): void
    {
        $this->seriesEcrite = $seriesEcrite;
    }

    /**
     * @return mixed
     */
    public function getSeriesDessiner()
    {
        return $this->seriesDessiner;
    }

    /**
     * @param mixed $seriesDessiner
     */
    public function setSeriesDessiner($seriesDessiner): void
    {
        $this->seriesDessiner = $seriesDessiner;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    public function __toString()
    {
        return $this->nom . " " . $this->prenom;
    }
}
