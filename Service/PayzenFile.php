<?php

namespace Clab\PayzenBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Clab\PayzenBundle\Service\ParameterResolver;

use Clab\PayzenBundle\Service\Payzen;
use Clab\PayzenBundle\Entity\PayzenFile as PayzenFileEntity;

class PayzenFile extends Payzen
{
    protected $em;
    protected $factory;
    protected $container;

    public function __construct(array $parameters, EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;

        $this->initParameters($parameters);
    }

    public function initParameters(array $parameters)
    {
        parent::initParameters($parameters);

        if($this->container->hasParameter('clab_payzen_env')) {
            $env = $this->container->getParameter('clab_payzen_env');
            if($env && $env == 'test') {
                $this->setParameter('vads_ctx_mode', 'TEST');
            }
        }
    }

    public function getTransactionId($amount = 000)
    {
        try {
            $lastTransaction = $this->em->getRepository('ClabPayzenBundle:PayzenFile')->getLastTransaction();
            $lastId = $lastTransaction->getTransactionId();
        } catch(\Exception $e) {
            $lastId = 800000;
        }

        return $lastId + 1;
    }

    public function createEntity()
    {
        $id = $this->getTransactionId();
        $file = new PayzenFileEntity();

        $file->setTransactionId($id);

        $date = $file->getCreated();
        $date->modify('+1 day');

        $name = $date->format('Ymd');
        $name .= '.' . $this->getParameter('vads_site_id') . '.PAY.REQ.';

        if($this->getEnv() == 'TEST') {
            $name .= 'T';
        } else {
            $name .= 'P';
        }

        $name .= '.' . $file->getTransactionId();

        $file->setName($name);

        $header = '00;PAY;02;' . $this->getParameter('vads_site_id');

        if($this->getEnv() == 'TEST') {
            $header .= ';TEST;';
        } else {
            $header .= ';PRODUCTION;';
        }

        $header .= $date->format('Ymd') . ';' . $date->format('His') . ';' . "\n";

        $file->setContent($header);

        return $file;
    }
}