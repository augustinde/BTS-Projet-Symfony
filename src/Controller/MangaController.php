<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Form\MangaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MangaController extends AbstractController
{
    /**
     * @Route("/manga", name="manga")
     */
    public function index(): Response
    {
        return $this->render('manga/index.html.twig', [
            'controller_name' => 'MangaController',
        ]);
    }

    /**
     * @Route("addmanga", name="create_manga")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function formCreateManga(Request $request,EntityManagerInterface $em): Response
    {
        $manga=new Manga();
        $form=$this->createForm(MangaType::class,$manga);

        $form->handleRequest($request);
        $resultat='Complétez le formulaire pour inserer un manga';

        if($form->isSubmitted()&&$form->isValid()){
            dump($manga);
            $em->persist($manga);
            $em->flush();
            $resultat='Produit inséré avec l\'id'.$manga->getId();
        }
        return $this->render('manga/addManga.html.twig',['resultat'=>$resultat,'form'=>$form->createView()
        ]);
    }

}
