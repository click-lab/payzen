<?php

namespace Clab\PayzenBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PayzenFileRepository extends EntityRepository
{
    public function getLastTransaction()
    {
        $today = date_create('today');
        $tomorrow = date_create('tomorrow');

        $qb = $this->createQueryBuilder('pf')
            ->where('pf.created >= :today')
            ->andWhere('pf.created < :tomorrow')
            ->setParameter('today', $today)
            ->setParameter('tomorrow', $tomorrow);

        $qb->orderBy('pf.id', 'desc');
        $qb->setMaxResults(1);

        $query = $qb->getQuery();
        return $query->getSingleResult();
    }
}
