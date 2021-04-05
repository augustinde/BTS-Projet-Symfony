<?php

namespace App\Controller;

use App\Form\CommenterType;
use App\Entity\Commenter;
use App\Entity\Manga;
use App\Form\MangaType;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Extra\Intl\IntlExtension;


class MangaController extends AbstractController
{
    /**
     * @Route("/manga", name="manga")
     */
    public function index(): Response
    {
        return $this->render('manga/baseAdministrateur.html.twig', [
            'controller_name' => 'MangaController',
        ]);
    }

    /**
     * @Route("addmanga", name="create_manga")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function formCreateManga(Request $request,EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $manga=new Manga();
        $form=$this->createForm(MangaType::class,$manga);

        $form->handleRequest($request);
        $resultat='Complétez le formulaire pour inserer un manga';

        if($form->isSubmitted() && $form->isValid()){

            $repositoryManga= $em->getRepository('App\Entity\Manga');
            $checkSManga=$repositoryManga->findOneBy(['serie' => $manga->getSerie(), 'numTome' => $manga->getNumTome()]);

            if($checkSManga == null){

                $imageFile = $form->get('image')->getData();

                if($imageFile){
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                    try{
                        $imageFile->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                    } catch (FileException $e){

                    }
                    $manga->setImage($newFilename);
                }else{
                    $manga->setImage('noImage.png');
                }

                $em->persist($manga);
                $em->flush();
                $resultat = array(
                    'res' => 'success',
                    'message' => 'Manga inséré avec l\'id '.$manga->getId()
                );

            }else{
                $resultat = array(
                    'res' => 'error',
                    'message' => 'Ce manga existe déjà !'
                );
            }
        }
        return $this->render(
            'manga/addManga.html.twig',
            [
                'resultat'=>$resultat,
                'form'=>$form->createView()
            ]);
    }

    /**
     * @Route("listemangas", name="list_mangas")
     * @param EntityManagerInterface $em
     * @return Response
     *
     */
    public function listMangas(EntityManagerInterface $em){
        $repositoryManga= $em->getRepository('App\Entity\Manga');
        $mangaCollection=$repositoryManga->findAll();

        dump($mangaCollection);

        return $this->render('manga/list_mangas.html.twig',['mangaCollection'=>$mangaCollection]);

    }

    /**
     * @Route("deleteManga/{idManga}", name="delete_manga")
     * @param EntityManagerInterface $em
     */
    public function deleteManga(int $idManga, EntityManagerInterface $em){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $repositoryManga= $em->getRepository('App\Entity\Manga');
        $manga=$repositoryManga->findOneBy(['id'=>$idManga]);

        $em->remove($manga);
        $em->flush();

        return $this->render('manga/deleteManga.html.twig', ['manga' => $manga]);

    }

    /**
     * @Route("viewManga/{idManga}", name="view_manga")
     * @param Request $request
     * @param int $idManga
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function viewManga(Request $request, int $idManga, EntityManagerInterface $em): Response
    {

        $repositoryManga=$em->getRepository('App\Entity\Manga');
        $manga=$repositoryManga->findOneBy(['id'=>$idManga]);

        $repositoryCommenter=$em->getRepository('App\Entity\Commenter');
        $commentCollection=$repositoryCommenter->findBy(['manga'=>$idManga]);

        $comment=new Commenter();
        $form_comment=$this->createForm(CommenterType::class,$comment);
        $form_comment->handleRequest($request);

        $user = $this->getUser();
        if($form_comment->isSubmitted() && $form_comment->isValid()){

            $repositoryCommenter=$em->getRepository('App\Entity\Commenter');
            $checkComment=$repositoryCommenter->findBy(['utilisateur'=>$user, 'manga' => $idManga]);

            if($checkComment == null){

                $comment->setNote($form_comment->get('note')->getData());
                $comment->setManga($manga);
                $comment->setUtilisateur($user);
                $comment->setPostedAt(new DateTime('NOW', new DateTimeZone('Europe/Paris')));

                $em->persist($comment);
                $em->flush();
            }

            
        }
        return $this->render(
            'manga/viewManga.html.twig',
            [
                'manga'=>$manga,
                'form'=>$form_comment->createView(),
                'commentCollection'=>$commentCollection,
                'user'=>$user
            ]);

    }
}
