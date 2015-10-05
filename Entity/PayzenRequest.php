<?php

namespace Clab\PayzenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="clab_payzen_request")
 * @ORM\Entity(repositoryClass="Clab\PayzenBundle\Entity\Repository\PayzenRequestRepository")
 */
class PayzenRequest
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(name="transactionId", type="integer")
     */
    private $transactionId;

    /**
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    public function __construct()
    {
	   $this->created = new \DateTime();
	   $this->updated = new \DateTime();
	   $this->amount = 000;
    }

    public function getId()
    {
	   return $this->id;
    }

    public function setCreated($created)
    {
	   $this->created = $created;
	   return $this;
    }

    public function getCreated()
    {
	   return $this->created;
    }

    public function setUpdated($updated)
    {
	   $this->updated = $updated;
	   return $this;
    }

    public function getUpdated()
    {
	   return $this->updated;
    }

    public function setAmount($amount)
    {
	   $this->amount = $amount;
	   return $this;
    }

    public function getAmount()
    {
	   return $this->amount;
    }

    public function setTransactionId($transactionId)
    {
	   $this->transactionId = $transactionId;
	   return $this;
    }

    public function getTransactionId()
    {
	   return $this->transactionId;
    }
}
