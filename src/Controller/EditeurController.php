<?php

namespace App\Controller;

use App\Entity\Editeur;
use App\Form\EditeurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditeurController extends AbstractController
{
    /**
     * @Route("/editeur", name="editeur")
     */
    public function index(): Response
    {
        return $this->render('editeur/index.html.twig', [
            'controller_name' => 'EditeurController',
        ]);
    }

    /**
     * @Route("addediteur", name="create_editeur")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function formCreateEditeur(Request $request, EntityManagerInterface $em) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $editeur=new Editeur();
        $form=$this->createForm(EditeurType::class,$editeur);

        $form->handleRequest($request);
        $resultat='Complétez le formulaire pour insérer un éditeur';

        if($form->isSubmitted()&&$form->isValid()){

            $repositoryEditeur=$em->getRepository('App\Entity\Editeur');
            $checkEditeur=$repositoryEditeur->findBy(['nom'=>$editeur->getNom()]);

            if($checkEditeur == null) {

                $em->persist($editeur);
                $em->flush();

                $resultat = array(
                    'res' => 'success',
                    'message' => 'Editeur inséré avec l\'id '.$editeur->getId()
                );

            }else{
                $resultat = array(
                    'res' => 'error',
                    'message' => 'Cet editeur existe déjà !'
                );

            }
        }
        return $this->render(
            'editeur/addediteur.html.twig',
            [
                'resultat'=>$resultat,
                'form'=>$form->createView()
            ]
        );

    }

    /**
     * @Route("listeEditeur", name="list-editeur")
     * @param EntityManagerInterface $em
     */

    public function listEditeur(EntityManagerInterface $em): Response{
        $repositoryEditeur= $em->getRepository('App\Entity\Editeur');
        $editeurCollection=$repositoryEditeur->findAll();


        return $this->render('editeur/listEditeur.html.twig',['editeurCollection'=>$editeurCollection]);
    }


    /**
     * @Route("viewSeriesEditeur/{idEditeur}", name="view_series_editeur")
     * @param int $idEditeur
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function listSeries(int $idEditeur, EntityManagerInterface $em): Response
    {
        $repoSerie = $em->getRepository("App\Entity\Serie");
        $serieCollection = $repoSerie->findBy(['editeur' => $idEditeur]);

        $repoEditeur = $em->getRepository("App\Entity\Editeur");
        $editeur = $repoEditeur->findOneBy(['id' => $idEditeur]);

        return $this->render('editeur/listSeriesEditeur.html.twig',['serieCollection'=>$serieCollection, 'editeur' => $editeur]);

    }

}
