<?php

namespace ST\UserBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function getGoodUser($username){
        $qb = $this->createQueryBuilder('a');

        $qb
            ->select('a')
            ->where('a.username = :username')
            ->setParameter('username', $username)
        ;

        return $qb->getQuery()->getResult();
    }
}
