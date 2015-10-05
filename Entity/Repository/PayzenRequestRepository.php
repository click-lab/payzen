<?php

namespace Clab\PayzenBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PayzenRequestRepository extends EntityRepository
{
    public function getTodayTransactions()
    {
    	$today = date_create('today');
    	$tomorrow = date_create('tomorrow');

    	$qb = $this->createQueryBuilder('pr')
    	    ->where('pr.created >= :today')
    	    ->andWhere('pr.created < :tomorrow')
    	    ->setParameter('today', $today)
    	    ->setParameter('tomorrow', $tomorrow);

    	$qb->orderBy('pr.id', 'desc');

    	$query = $qb->getQuery();

    	return $query->getResult();
    }

    public function getLastTransaction()
    {
    	$today = date_create('today');
    	$tomorrow = date_create('tomorrow');

    	$qb = $this->createQueryBuilder('pr')
    	    ->where('pr.created >= :today')
    	    ->andWhere('pr.created < :tomorrow')
    	    ->setParameter('today', $today)
    	    ->setParameter('tomorrow', $tomorrow);

    	$qb->orderBy('pr.id', 'desc');
    	$qb->setMaxResults(1);

    	$query = $qb->getQuery();
    	return $query->getSingleResult();
    }
}