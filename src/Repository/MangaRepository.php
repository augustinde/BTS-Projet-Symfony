<?php

namespace App\Repository;

use App\Entity\Manga;
use App\Entity\SearchManga;
use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Manga|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manga|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manga[]    findAll()
 * @method Manga[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MangaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manga::class);
    }

    /**
     * @param SearchManga $searchManga
     * @return int|mixed|string
     */
    public function findSearch(SearchManga $searchManga){

        $query = $this->createQueryBuilder('m')
            ->select('m')
            ->innerJoin('m.serie', 's');
        if(!empty($searchManga->getCategorie())){
            $query->andWhere('s.categorie = :categorie')
                ->setParameter('categorie', $searchManga->getCategorie());

        }
        if(!empty($searchManga->getDessinateur())){
            $query->innerJoin('s.dessinateur', 'd')
                ->andWhere('s.dessinateur = :dessinateur')
                ->setParameter('dessinateur', $searchManga->getDessinateur());

        }
        if(!empty($searchManga->getScenariste())){
            $query->innerJoin('s.scenariste', 'sc')
                ->andWhere('s.scenariste = :scenariste')
                ->setParameter('scenariste', $searchManga->getScenariste());

        }
        if(!empty($searchManga->getEditeur())){
            $query->innerJoin('s.editeur', 'e')
                ->andWhere('s.editeur = :editeur')
                ->setParameter('editeur', $searchManga->getEditeur());

        }
        if(!empty($searchManga->getNom())){
            $query->andWhere('s.nom LIKE :nom')
                ->setParameter('nom', '%'.$searchManga->getNom().'%');

        }
        return $query->getQuery()->getResult();
    }

    /**
     * @return int|mixed|string
     */
    public function findAllAsc(){
        return $this->createQueryBuilder('m')
            ->innerJoin('m.serie', 's')
            ->orderBy('s.nom', 'ASC')
            ->addOrderBy('m.numTome', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Manga[] Returns an array of Manga objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Manga
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
