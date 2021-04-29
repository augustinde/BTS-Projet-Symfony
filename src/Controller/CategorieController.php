<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{

    /**
     * @Route("viewSeriesCategorie/{idCateg}", name="view_series_categ")
     * @param int $idCateg
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function listSeries(int $idCateg, EntityManagerInterface $em): Response
    {
        $repoSerie = $em->getRepository("App\Entity\Serie");
        $serieCollection = $repoSerie->findBy(['categorie' => $idCateg]);

        $repoCateg = $em->getRepository("App\Entity\Categorie");
        $categorie = $repoCateg->findOneBy(['id' => $idCateg]);

        return $this->render('categorie/listSeriesCategorie.html.twig',['serieCollection'=>$serieCollection, 'categorie' => $categorie]);

    }
}
