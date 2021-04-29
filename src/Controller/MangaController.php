<?php

namespace App\Controller;

use App\Entity\SearchManga;
use App\Form\CommenterType;
use App\Entity\Commenter;
use App\Entity\Manga;
use App\Form\MangaType;
use App\Form\SearchMangaFormType;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
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
     * @param Request $request
     * @return Response
     */
    public function listMangas(EntityManagerInterface $em, Request $request): Response
    {
        $repositoryManga= $em->getRepository('App\Entity\Manga');
        $mangaCollection=$repositoryManga->findAllAsc();


        $searchManga = new SearchManga();

        $form_searchManga = $this->createForm(SearchMangaFormType::class,$searchManga);
        $form_searchManga->handleRequest($request);

        if($form_searchManga->isSubmitted() && $form_searchManga->isValid()){

            $mangaCollection = [];
            $dataSearch = new SearchManga();

            $dataSearch->setIdSerie($form_searchManga->get('idSerie')->getData());
            $dataSearch->setCategorie($form_searchManga->get('categorie')->getData());
            $dataSearch->setEditeur($form_searchManga->get('editeur')->getData());
            $dataSearch->setDessinateur($form_searchManga->get('dessinateur')->getData());
            $dataSearch->setScenariste($form_searchManga->get('scenariste')->getData());
            $mangaCollection = $repositoryManga->findSearch($dataSearch);
        }

        return $this->render('manga/list_mangas.html.twig',['formSearch' => $form_searchManga->createView(), 'mangaCollection'=>$mangaCollection]);

    }

    /**
     * @Route("updateManga/{idManga}", name="update_manga")
     * @param Request $request
     * @param int $idManga
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function updateManga(Request $request, int $idManga, EntityManagerInterface $em, SluggerInterface $slugger){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $repositoryManga = $em->getRepository('App\Entity\Manga');
        $manga = $repositoryManga->findOneBy(['id' => $idManga]);

        $form_update_manga = $this->createForm(MangaType::class, $manga);
        $form_update_manga->handleRequest($request);

        if($form_update_manga->isSubmitted() && $form_update_manga->isValid()){

            $imageFile = $form_update_manga->get('image')->getData();

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
            }

            $em->flush();
        }

        return $this->render(
            'manga/updateManga.html.twig',
            [
                'manga'=>$manga,
                'form'=>$form_update_manga->createView(),
            ]);
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
        $resultat='';

        $repositoryManga=$em->getRepository('App\Entity\Manga');
        $manga=$repositoryManga->findOneBy(['id'=>$idManga]);

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
                $resultat = array(
                    'res' => 'success',
                    'message' => 'Commentaire ajouté.'
                );

            }else{
                $resultat = array(
                    'res' => 'error',
                    'message' => 'Erreur lors de l\'ajout du commentaire.'
                );
            }
            
        }

        $repositoryCommenter=$em->getRepository('App\Entity\Commenter');
        $commentCollection=$repositoryCommenter->findBy(['manga'=>$idManga]);

        return $this->render(
            'manga/viewManga.html.twig',
            [
                'manga'=>$manga,
                'resultat'=>$resultat,
                'form'=>$form_comment->createView(),
                'commentCollection'=>$commentCollection,
                'user'=>$user
            ]);

    }
}
