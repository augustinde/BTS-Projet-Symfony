<?php


namespace App\Entity;


class SearchManga
{

    private $categorie;
    private $editeur;
    private $scenariste;
    private $dessinateur;
    private $nom;


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

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }






}