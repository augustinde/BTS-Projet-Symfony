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

    /**
     * @Route("viewSeriesPersonne/{idPersonne}", name="view_series_personne")
     * @param int $idPersonne
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function listSeries(int $idPersonne, EntityManagerInterface $em):Response
    {
        $repoSerie = $em->getRepository("App\Entity\Serie");
        $serieCollection = $repoSerie->findByDessinateurOrScenariste($idPersonne);
        dump($serieCollection);
        $repoPersonne = $em->getRepository("App\Entity\Personne");
        $personne = $repoPersonne->findOneBy(['id' => $idPersonne]);


        return $this->render('personne/listSeriesPersonne.html.twig',['serieCollection'=>$serieCollection, 'personne' => $personne]);

    }

    /**
     * @Route("listePersonne", name="list-personne")
     * @param EntityManagerInterface $em
     */

    public function listPersonne(EntityManagerInterface $em): Response{
        $repoPersonne = $em->getRepository('App\Entity\Personne');
        $personneCollection = $repoPersonne->findAll();


        return $this->render('personne/listPersonne.html.twig',['personneCollection'=>$personneCollection]);
    }


    /**
     * @Route("updatePersonne/{idPersonne}", name="update_personne")
     * @param Request $request
     * @param int $idPersonne
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function updatePersonne(Request $request, int $idPersonne, EntityManagerInterface $em){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $repoPersonne = $em->getRepository('App\Entity\Personne');
        $personne = $repoPersonne->findOneBy(['id' => $idPersonne]);

        $form_update_personne = $this->createForm(PersonneType::class, $personne);
        $form_update_personne->handleRequest($request);

        if($form_update_personne->isSubmitted() && $form_update_personne->isValid()){


            $personne->setNom($form_update_personne->get('nom')->getData());
            $personne->setPrenom($form_update_personne->get('prenom')->getData());
            $personne->setType($form_update_personne->get('type')->getData());

            $em->flush();
        }

        return $this->render(
            'personne/updatePersonne.html.twig',
            [
                'personne'=>$personne,
                'form'=>$form_update_personne->createView(),
            ]);
    }

}
