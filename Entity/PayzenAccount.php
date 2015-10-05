<?php

namespace Clab\PayzenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="clab_payzen_account")
 * @ORM\Entity(repositoryClass="Clab\PayzenBundle\Entity\Repository\PayzenAccountRepository")
 */
class PayzenAccount
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
     * @ORM\Column(name="identifier", type="string", length=255, nullable=true)
     */
    private $identifier;

    /**
     * @ORM\Column(name="vads_identifier_status", type="string", length=255, nullable=true)
     */
    private $vads_identifier_status;

    /**
     * @ORM\Column(name="vads_cust_email", type="string", length=255, nullable=true)
     */
    private $vads_cust_email;

    /**
     * @ORM\Column(name="vads_card_number", type="string", length=255, nullable=true)
     */
    private $vads_card_number;

    /**
     * @ORM\Column(name="vads_card_brand", type="string", length=255, nullable=true)
     */
    private $vads_card_brand;

    /**
     * @ORM\Column(name="vads_card_country", type="string", length=255, nullable=true)
     */
    private $vads_card_country;

    /**
     * @ORM\Column(name="vads_expiry_month", type="string", length=255, nullable=true)
     */
    private $vads_expiry_month;

    /**
     * @ORM\Column(name="vads_expiry_year", type="string", length=255, nullable=true)
     */
    private $vads_expiry_year;

    /**
     * @ORM\Column(name="vads_cust_id", type="string", length=255, nullable=true)
     */
    private $vads_cust_id;

    /**
     * @ORM\Column(name="clab_type", type="string", length=255, nullable=true)
     */
    private $clab_type;

    /**
     * @ORM\Column(name="clab_identifier", type="string", length=255, nullable=true)
     */
    private $clab_identifier;

    public function __construct()
    {
       $this->created = new \DateTime();
       $this->updated = new \DateTime();
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

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setVadsIdentifierStatus($vadsIdentifierStatus)
    {
        $this->vads_identifier_status = $vadsIdentifierStatus;
        return $this;
    }

    public function getVadsIdentifierStatus()
    {
        return $this->vads_identifier_status;
    }

    public function setVadsCustEmail($vadsCustEmail)
    {
        $this->vads_cust_email = $vadsCustEmail;
        return $this;
    }

    public function getVadsCustEmail()
    {
        return $this->vads_cust_email;
    }

    public function setVadsCardNumber($vadsCardNumber)
    {
        $this->vads_card_number = $vadsCardNumber;
        return $this;
    }

    public function getVadsCardNumber()
    {
        return $this->vads_card_number;
    }

    public function setVadsCardBrand($vadsCardBrand)
    {
        $this->vads_card_brand = $vadsCardBrand;
        return $this;
    }

    public function getVadsCardBrand()
    {
        return $this->vads_card_brand;
    }

    public function setVadsCardCountry($vadsCardCountry)
    {
        $this->vads_card_country = $vadsCardCountry;
        return $this;
    }

    public function getVadsCardCountry()
    {
        return $this->vads_card_country;
    }

    public function setVadsExpiryMonth($vadsExpiryMonth)
    {
        $this->vads_expiry_month = $vadsExpiryMonth;
        return $this;
    }

    public function getVadsExpiryMonth()
    {
        return $this->vads_expiry_month;
    }

    public function setVadsExpiryYear($vadsExpiryYear)
    {
        $this->vads_expiry_year = $vadsExpiryYear;
        return $this;
    }

    public function getVadsExpiryYear()
    {
        return $this->vads_expiry_year;
    }

    public function setVadsCustId($vadsCustId)
    {
        $this->vads_cust_id = $vadsCustId;
        return $this;
    }

    public function getVadsCustId()
    {
        return $this->vads_cust_id;
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
