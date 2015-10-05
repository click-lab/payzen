<?php

namespace Clab\PayzenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="clab_payzen_response")
 * @ORM\Entity(repositoryClass="Clab\PayzenBundle\Entity\Repository\PayzenResponseRepository")
 */
class PayzenResponse
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
     * @ORM\Column(name="is_verified", type="boolean")
     */
    private $is_verified;

    /**
     * @ORM\Column(name="transactionId", type="integer", nullable=true)
     */
    private $transactionId;

    /**
     * @ORM\Column(name="vads_auth_result", type="string", length=255, nullable=true)
     */
    private $vads_auth_result;

    /**
     * @ORM\Column(name="vads_trans_status", type="string", length=255, nullable=true)
     */
    private $vads_trans_status;

    /**
     * @ORM\Column(name="vads_order_id", type="string", length=255, nullable=true)
     */
    private $vads_order_id;

    /**
     * @ORM\Column(name="vads_order_info", type="string", length=255, nullable=true)
     */
    private $vads_order_info;

    /**
     * @ORM\Column(name="clab_type", type="string", length=255, nullable=true)
     */
    private $clab_type;

    /**
     * @ORM\Column(name="clab_identifier", type="string", length=255, nullable=true)
     */
    private $clab_identifier;

    /**
     * @ORM\Column(name="parameters", type="text", nullable=true)
     */
    private $parameters;

    public function __construct()
    {
	   $this->created = new \DateTime();
	   $this->updated = new \DateTime();
       $this->is_verified = false;
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

    public function setIsVerified($isVerified)
    {
        $this->is_verified = $isVerified;
        return $this;
    }

    public function isVerified() { return $this->getIsVerified(); }
    public function getIsVerified()
    {
        return $this->is_verified;
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

    public function setVadsAuthResult($vadsAuthResult)
    {
        $this->vads_auth_result = $vadsAuthResult;
        return $this;
    }

    public function getVadsAuthResult()
    {
        return $this->vads_auth_result;
    }

    public function setVadsTransStatus($vadsTransStatus)
    {
        $this->vads_trans_status = $vadsTransStatus;
        return $this;
    }

    public function getVadsTransStatus()
    {
        return $this->vads_trans_status;
    }

    public function setVadsOrderId($vadsOrderId)
    {
        $this->vads_order_id = $vadsOrderId;
        return $this;
    }

    public function getVadsOrderId()
    {
        return $this->vads_order_id;
    }

    public function setVadsOrderInfo($vadsOrderInfo)
    {
        $this->vads_order_info = $vadsOrderInfo;
        return $this;
    }

    public function getVadsOrderInfo()
    {
        return $this->vads_order_info;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setClabType($clabType)
    {
        $this->clab_type = $clabType;
        return $this;
    }

    public function getClabType()
    {
        return $this->clab_type;
    }

    public function setClabIdentifier($clabIdentifier)
    {
        $this->clab_identifier = $clabIdentifier;
        return $this;
    }

    public function getClabIdentifier()
    {
        return $this->clab_identifier;
    }
}
