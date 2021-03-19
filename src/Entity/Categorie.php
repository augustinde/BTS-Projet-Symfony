<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="Serie", mappedBy="categorie")
     */
    private $series;

    public function addSerie(Serie $series){
        $this->series[] = $series;
        $series->setCategorie($this);
        return $this;
    }

    public function __construct()
    {
        $this->series = new ArrayCollection();

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

    /**
     * @return ArrayCollection
     */
    public function getSeries(): ArrayCollection
    {
        return $this->series;
    }

    /**
     * @param ArrayCollection $series
     */
    public function setSeries(ArrayCollection $series): void
    {
        $this->series = $series;
    }
}
