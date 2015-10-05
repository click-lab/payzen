<?php

namespace Clab\PayzenBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Clab\PayzenBundle\Entity\PayzenAccount;

class PayzenAccountEvent extends Event
{
    private $account;

    public function __construct(PayzenAccount $account)
    {
       $this->account = $account;
    }

    public function getAccount()
    {
       return $this->account;
    }
}
