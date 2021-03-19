<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Annotations\Annotation;

/**
 * @ORM\Entity(repositoryClass=SerieRepository::class)
 */
class Serie
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
     * @ORM\Column(type="string", length=25)
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity="Manga", mappedBy="serie")
     */
    private $mangas;

    /**
     * @ORM\OneToOne(targetEntity="Categorie")
     * @ORM\JoinColumn(name="categ_id", referencedColumnName="id")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="Editeur", inversedBy="series")
     * @ORM\JoinColumn(name="editeur_id", referencedColumnName="id")
     */
    private $editeur;

    /**
     * @ORM\ManyToOne(targetEntity="Personne", inversedBy="series")
     * @ORM\JoinColumn(name="scenariste_id", referencedColumnName="id")
     */
    private $scenariste;

    /**
     * @ORM\ManyToOne(targetEntity="Personne", inversedBy="series")
     * @ORM\JoinColumn(name="dessinateur_id", referencedColumnName="id")
     */
    private $dessinateur;

    public function addManga(Manga $mangas){
        $this->mangas[] = $mangas;
        $mangas->setSerie($this);
        return $this;
    }

    public function __construct()
    {
        $this->mangas = new ArrayCollection();

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMangas(): ArrayCollection
    {
        return $this->mangas;
    }

    /**
     * @param ArrayCollection $mangas
     */
    public function setMangas(ArrayCollection $mangas): void
    {
        $this->mangas = $mangas;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie): void
    {
        $this->categorie = $categorie;
    }

    /**
     * @return mixed
     */
    public function getEditeur()
    {
        return $this->editeur;
    }

    /**
     * @param mixed $editeur
     */
    public function setEditeur($editeur): void
    {
        $this->editeur = $editeur;
    }

    /**
     * @return mixed
     */
    public function getScenariste()
    {
        return $this->scenariste;
    }

    /**
     * @param mixed $scenariste
     */
    public function setScenariste($scenariste): void
    {
        $this->scenariste = $scenariste;
    }

    /**
     * @return mixed
     */
    public function getDessinateur()
    {
        return $this->dessinateur;
    }

    /**
     * @param mixed $dessinateur
     */
    public function setDessinateur($dessinateur): void
    {
        $this->dessinateur = $dessinateur;
    }
}
