<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function index(): Response
    {
        return $this->render('utilisateur/baseUser.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    /**
     * @Route("accueil", name="app_accueil")
     * @return Response
     */
    public function accueil() : Response
    {
        return $this->render('utilisateur/accueil.html.twig');
    }



}
