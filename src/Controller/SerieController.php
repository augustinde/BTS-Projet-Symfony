<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    /**
     * @Route("/serie", name="serie")
     */
    public function index(): Response
    {
        return $this->render('serie/index.html.twig', [
            'controller_name' => 'SerieController',
        ]);
    }

    /**
     * @Route("addserie", name="create_serie")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function formCreateSerie(Request $request, EntityManagerInterface $em) : Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $serie=new Serie();
        $form=$this->createForm(SerieType::class,$serie);

        $form->handleRequest($request);
        $resultat='Complétez le formulaire pour inserer une série';

        if($form->isSubmitted()&&$form->isValid()){
            dump($serie);
            $em->persist($serie);
            $em->flush();
            $resultat='Serie inséré avec l\'id'.$serie->getId();
        }
        return $this->render('serie/addserie.html.twig',['resultat'=>$resultat,'form'=>$form->createView()
        ]);
    }
}
