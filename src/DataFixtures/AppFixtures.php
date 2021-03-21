<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Manga;
use App\Entity\Personne;
use App\Entity\Serie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use MongoDB\Driver\Manager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

  /*      for($i = 0; $i < 5; $i++){
            $categorie = new Categorie();
            $categorie->setNom("categ".$i);
            $manager->persist($categorie);
        }

        $personne = new Personne();
        $personne->setNom("Paure");
        $personne->setPrenom("Alain");
        $personne->setType("Dessinateur");
        $manager->persist($personne);

        $personne = new Personne();
        $personne->setNom("Doe");
        $personne->setPrenom("John");
        $personne->setType("Scenariste");
        $manager->persist($personne);

        for($l = 0; $l < 5; $l++){
            $editeur = new Editeur();
            $editeur->setNom("Editeur".$l);
            $manager->persist($editeur);

        }

        for($m = 0; $m < 5; $m++){
            $serie = new Serie();
            $serie->setNom("Serie".$m);
            $serie->setCategorie($m);
            $serie->setScenariste(1);
            $serie->setDessinateur(2);
            $serie->setEditeur($m);
            $serie->setEtat("En cours de parution");
            $manager->persist($serie);
        }

        for($n = 0; $n < 5; $n++){
            $manga = new Manga();
            $manga->setSerie();
        }*/


    }
}
