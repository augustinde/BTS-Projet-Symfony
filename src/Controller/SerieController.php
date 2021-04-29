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

    /**
     * @Route("listeseries", name="list_series")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function listSeries(EntityManagerInterface $em) : Response
    {
        $repoSerie = $em->getRepository('App\Entity\Serie');
        $serieCollection = $repoSerie->findAll();

        return $this->render('serie/list_serie.html.twig', ['serieCollection' => $serieCollection]);
    }

    /**
     * @Route("updateSerie/{idSerie}", name="update_serie")
     * @param Request $request
     * @param int $idSerie
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function updateSerie(Request $request, int $idSerie, EntityManagerInterface $em){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $repoSerie = $em->getRepository('App\Entity\Serie');
        $serie = $repoSerie->findOneBy(['id' => $idSerie]);

        $form_update_serie = $this->createForm(SerieType::class, $serie);
        $form_update_serie->handleRequest($request);

        if($form_update_serie->isSubmitted() && $form_update_serie->isValid()){


            $serie->setNom($form_update_serie->get('nom')->getData());
            $serie->setEtat($form_update_serie->get('etat')->getData());
            $serie->setCategorie($form_update_serie->get('categorie')->getData());
            $serie->setEditeur($form_update_serie->get('editeur')->getData());
            $serie->setScenariste($form_update_serie->get('scenariste')->getData());
            $serie->setDessinateur($form_update_serie->get('dessinateur')->getData());

            $em->flush();
        }

        return $this->render(
            'serie/updateSerie.html.twig',
            [
                'serie'=>$serie,
                'form'=>$form_update_serie->createView(),
            ]);
    }

}
