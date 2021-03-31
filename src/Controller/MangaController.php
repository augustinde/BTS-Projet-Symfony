<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Form\MangaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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

        if($form->isSubmitted()&&$form->isValid()){

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
            $resultat='Produit inséré avec l\'id'.$manga->getId();
        }
        return $this->render('manga/addManga.html.twig',['resultat'=>$resultat,'form'=>$form->createView()
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
    public function deleteManga(EntityManagerInterface $em){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

    }

    /**
     * @Route("viewManga/{idManga}", name="view_manga")
     * @param int $idManga
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function viewManga(int $idManga, EntityManagerInterface $em): Response
    {

        $repositoryManga=$em->getRepository('App\Entity\Manga');
        $manga=$repositoryManga->findOneBy(['id'=>$idManga]);

    return $this->render('manga/viewManga.html.twig',['manga'=>$manga]);

    }
}
