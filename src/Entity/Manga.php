<?php

namespace App\Entity;

use App\Repository\MangaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=MangaRepository::class)
 */
class Manga
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPage;

    /**
     * @ORM\Column(type="integer")
     */
    private $numTome;

    /**
     * @ORM\Column(type="float")
     */
    private $prixManga;

    /**
     * @ORM\Column(type="text")
     */
    private $descManga;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="date")
     */
    private $dateParution;

    /**
     * @ORM\ManyToOne(targetEntity="Serie", inversedBy="mangas")
     */
    protected $serie;

    /**
     * @ORM\OneToMany(targetEntity="Commenter", mappedBy="manga")
     */
    private $comments;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbPage(): ?int
    {
        return $this->nbPage;
    }

    public function setNbPage(int $nbPage): self
    {
        $this->nbPage = $nbPage;

        return $this;
    }

    public function getNumTome(): ?int
    {
        return $this->numTome;
    }

    public function setNumTome(int $numTome): self
    {
        $this->numTome = $numTome;

        return $this;
    }

    public function getPrixManga(): ?float
    {
        return $this->prixManga;
    }

    public function setPrixManga(float $prixManga): self
    {
        $this->prixManga = $prixManga;

        return $this;
    }

    public function getDescManga(): ?string
    {
        return $this->descManga;
    }

    public function setDescManga(string $descManga): self
    {
        $this->descManga = $descManga;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDateParution(): ?\DateTimeInterface
    {
        return $this->dateParution;
    }

    public function setDateParution(\DateTimeInterface $dateParution): self
    {
        $this->dateParution = $dateParution;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param mixed $serie
     */
    public function setSerie($serie): void
    {
        $this->serie = $serie;
    }
}
