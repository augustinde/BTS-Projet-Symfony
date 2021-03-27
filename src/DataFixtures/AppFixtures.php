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

    }
}
