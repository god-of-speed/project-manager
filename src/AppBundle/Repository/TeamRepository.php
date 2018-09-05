<?php

namespace AppBundle\Repository;

/**
 * TeamRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TeamRepository extends \Doctrine\ORM\EntityRepository
{
    public function findId($id){
        return $this->createQueryBuilder('cat')
                    ->andWhere("cat.id = :searchTerm")
                    ->setParameter('searchTerm',$id)
                    ->getQuery()
                    ->execute();
    }
    public function findAllOrdered(){
        return $this->createQueryBuilder('cat')
                    ->orderBy('cat.id','ASC')
                    ->getQuery()
                    ->execute();
    }
}