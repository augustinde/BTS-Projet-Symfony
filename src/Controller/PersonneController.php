<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    /**
     * @Route("/personne", name="personne")
     */
    public function index(): Response
    {
        return $this->render('personne/index.html.twig', [
            'controller_name' => 'PersonneController',
        ]);
    }

    /**
     * @Route("addpersonne", name="create_personne")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function formCreatePersonne(Request $request, EntityManagerInterface $em) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $personne=new Personne();
        $form=$this->createForm(PersonneType::class,$personne);

        $form->handleRequest($request);
        $resultat='Complétez le formulaire pour inserer une personne';

        if($form->isSubmitted()&&$form->isValid()){
            dump($personne);
            $em->persist($personne);
            $em->flush();
            $resultat='Personne inséré avec l\'id'.$personne->getId();
        }
        return $this->render('personne/addpersonne.html.twig',['resultat'=>$resultat,'form'=>$form->createView()
        ]);


    }
}
