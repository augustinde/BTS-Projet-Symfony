<?php

namespace App\Entity;

use App\Repository\CommenterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommenterRepository::class)
 */
class Commenter
{

    /**
     * @ORM\Column(type="text")
     */
    private $commentaire;

    /**
     * @ORM\Column(type="float")
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     */
    private $posted_at;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Membre", inversedBy="comments")
     * @ORM\JoinColumn(name="membre_id", referencedColumnName="id", nullable=false)
     */
    private $membre;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Manga", inversedBy="comments")
     * @ORM\JoinColumn(name="manga_id", referencedColumnName="id", nullable=false)
     */
    private $manga;

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getPostedAt(): ?\DateTimeInterface
    {
        return $this->posted_at;
    }

    public function setPostedAt(\DateTimeInterface $posted_at): self
    {
        $this->posted_at = $posted_at;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMembre()
    {
        return $this->membre;
    }

    /**
     * @param mixed $membre
     */
    public function setMembre($membre): void
    {
        $this->membre = $membre;
    }

    /**
     * @return mixed
     */
    public function getManga()
    {
        return $this->manga;
    }

    /**
     * @param mixed $manga
     */
    public function setManga($manga): void
    {
        $this->manga = $manga;
    }
}
