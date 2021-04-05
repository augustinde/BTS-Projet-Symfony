<?php

namespace App\Controller;

use App\Form\CommenterType;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommenterController extends AbstractController
{
    /**
     * @Route("/commenter", name="commenter")
     */
    public function index(): Response
    {
        return $this->render('commenter/index.html.twig', [
            'controller_name' => 'CommenterController',
        ]);
    }

    /**
     * @Route("updateComment/{idManga}/{idUtilisateur}/{idComment}", name="update_comment")
     * @param int $idManga
     * @param int $idUtilisateur
     * @param int $idComment
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function updateComment(int $idManga, int $idUtilisateur, int $idComment, EntityManagerInterface $em, Request $request){



        $repositoryCommenter = $em->getRepository('App\Entity\Commenter');
        $comment=$repositoryCommenter->findOneBy(['manga' => $idManga, 'utilisateur' => $idUtilisateur, 'id' => $idComment]);

        $user = $this->getUser();

        dump($comment);

        $form_comment=$this->createForm(CommenterType::class,$comment);
        $form_comment->handleRequest($request);

        $resultat = array(
            'res' => 'error',
            'message' => 'Commentaire non modifié.'
        );

        if($form_comment->isSubmitted() && $form_comment->isValid()) {

            if ($comment == null) {

                $error = true;
            }

            $comment->setNote($form_comment->get('note')->getData());
            $comment->setManga($comment->getManga());
            $comment->setUtilisateur($user);
            $comment->setPostedAt(new DateTime('NOW', new DateTimeZone('Europe/Paris')));

            $em->persist($comment);
            $em->flush();
            $resultat = array(
                'res' => 'success',
                'message' => 'Commentaire modifié.'
            );
        }

        return $this->render(
            'commenter/updateComment.html.twig',
            [
                'form'=>$form_comment->createView(),
                'comment' => $comment,
                'user' => $user,
                'resultat' => $resultat
            ]
        );
    }



    /**
     * @Route("deleteComment/{idManga}/{idUtilisateur}/{idComment}", name="delete_comment")
     * @param int $idManga
     * @param int $idUtilisateur
     * @param int $idComment
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function deteleComment(int $idManga, int $idUtilisateur, int $idComment, EntityManagerInterface $em){

        $repositoryCommenter= $em->getRepository('App\Entity\Commenter');
        $comment=$repositoryCommenter->findOneBy(['manga' => $idManga, 'utilisateur' => $idUtilisateur, 'id' => $idComment]);
        $user = $this->getUser();
        dump($comment);
        $error = false;
        if($comment != null){

            $em->remove($comment);
            $em->flush();

        }else{
            $error = true;
        }
        return $this->render(
            'commenter/deleteComment.html.twig',
            [
                'comment' => $comment,
                'user' => $user,
                'rep' => $error,
                'idManga' => $idManga
            ]
        );

    }
}
