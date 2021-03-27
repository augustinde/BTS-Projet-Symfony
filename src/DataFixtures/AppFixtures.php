<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Manga;
use App\Entity\Personne;
use App\Entity\Serie;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $categorie = new Categorie();
        $categorie->setNom("Combat");
        $manager->persist($categorie);

        $dessinateur = new Personne();
        $dessinateur->setNom("Paure");
        $dessinateur->setPrenom("Alain");
        $dessinateur->setType("Dessinateur");
        $manager->persist($dessinateur);

        $scenariste = new Personne();
        $scenariste->setNom("Doe");
        $scenariste->setPrenom("John");
        $scenariste->setType("Scenariste");
        $manager->persist($scenariste);


        $editeur = new Editeur();
        $editeur->setNom("Hermes");
        $manager->persist($editeur);

        $serie = new Serie();
        $serie->setNom("Pokemon");
        $serie->setCategorie($categorie);
        $serie->setScenariste($scenariste);
        $serie->setDessinateur($dessinateur);
        $serie->setEditeur($editeur);
        $serie->setEtat("En cours de parution");
        $manager->persist($serie);

        $manga = new Manga();
        $manga->setSerie($serie);
        $manga->setDescManga("Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.");
        $manga->setImage("noImage.png");
        $manga->setNbPage(25);
        $manga->setNumTome(1);
        $manga->setPrixManga(25.99);
        $manga->setDateParution(new DateTime("now"));
        $manager->persist($manga);
        $manager->flush();
    }
}
