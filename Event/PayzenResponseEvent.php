<?php

namespace Clab\PayzenBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Clab\PayzenBundle\Entity\PayzenResponse;

class PayzenResponseEvent extends Event
{
    private $entity;
    private $verified;

    public function __construct(PayzenResponse $entity, $verified = false)
    {
	   $this->entity = $entity;
	   $this->verified = (bool) $verified;
    }

    public function getEntity()
    {
	   return $this->entity;
    }

    public function isVerified()
    {
	   return $this->verified;
    }
}
