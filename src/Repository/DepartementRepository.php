<?php

namespace App\Repository;

use App\Entity\Departement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Departement>
 *
 * @method Departement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departement[]    findAll()
 * @method Departement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departement::class);
    }
   // public function orderbyname(){
       // return $this -> createQueryBuilder('a')
           // ->orderBy('a.name','Desc')
            //->getQuery()
            //->getResult();
    //}
    //public function searchbyalph()
        //{
           // return $this ->createQueryBuilder('a')
           //->where('a.name LIKE: name')
           //->setParametres(['firstname' => 'L%', 'lastname'=>'Couzens'])
           //->getQuery()
           //->getResult();
        //}
        public function Searchbyname($name){
         return $this->createQueryBuilder('a')
        ->where('a.name = :name')
        ->setParameter('name', $name)
        ->getQuery()
        ->getResult();
        }
        public function minmax($min,$max){
            $em = $this-> getEntityManager();
            return $em->createQuery('SELECT a from App\Entity\Departement a where a.nbrSalle BETWEEN ?1 and :max ' )

            ->setParameters(['1'=>$min ,'max'=>$max]) 
            ->getResult() ;
        
        }

//    /**
//     * @return Departement[] Returns an array of Departement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Departement
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
