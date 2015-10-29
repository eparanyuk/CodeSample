<?php

namespace CeBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class EmailRepository extends EntityRepository
{
    /**
     * Get QueryBuilder for Grid
     *
     * @return QueryBuilder
     */
    public function getGridQueryBuilder()
    {
        return $this->createQueryBuilder('e')->orderBy('e.email', 'ASC');
    }

    /**
     * @param $token
     * @return array
     */
    public function getEmailByToken($token)
    {
        return $this->createQueryBuilder('e')
            ->where('e.token = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getResult()
        ;
    }
}
