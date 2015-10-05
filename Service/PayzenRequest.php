<?php

namespace Clab\PayzenBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Clab\PayzenBundle\Service\ParameterResolver;

use Clab\PayzenBundle\Service\Payzen;
use Clab\PayzenBundle\Entity\PayzenRequest as PayzenRequestEntity;

class PayzenRequest extends Payzen
{
    protected $em;
    protected $factory;
    protected $container;

    public function __construct(array $parameters, EntityManager $em, ContainerInterface $container, FormFactoryInterface $factory)
    {
    	$this->em = $em;
    	$this->factory = $factory;
        $this->container = $container;

    	$this->initParameters($parameters);
    }

    public function initParameters(array $parameters)
    {
    	parent::initParameters($parameters);

    	$this->setParameters(array(
    	    'vads_action_mode' => 'INTERACTIVE',
    	    'vads_ctx_mode' => 'PRODUCTION',
    	    'vads_currency' => '978',
    	    'vads_page_action' => 'PAYMENT',
    	    'vads_payment_config' => 'SINGLE',
    	    'vads_trans_date' => gmdate('YmdHis'),
    	    'vads_version' => 'V2'
    	));

        if($this->container->hasParameter('clab_payzen_env')) {
            $env = $this->container->getParameter('clab_payzen_env');
            if($env && $env == 'test') {
                $this->setParameter('vads_ctx_mode', 'TEST');
            }
        }


    	$this->setParameter('vads_trans_id', sprintf('%06d', $this->getTransactionId()));
    }

    public function getTransactionId($amount = 000)
    {
    	try {
    	    $lastTransaction = $this->em->getRepository('ClabPayzenBundle:PayzenRequest')->getLastTransaction();
    	    $lastId = $lastTransaction->getTransactionId();
    	} catch(\Exception $e) {
    	    $lastId = 0;
    	}

    	$transaction = new PayzenRequestEntity();
    	$transaction->setAmount($amount);
    	$transaction->setTransactionId($lastId + 1);
    	$this->em->persist($transaction);
    	$this->em->flush();

    	return $transaction->getTransactionId();
    }

    public function getForm($options = array())
    {
    	$options['csrf_protection'] = false;

    	$parameters = $this->getParameters();
    	$builder = $this->factory->createBuilder('form', $parameters, $options);

    	foreach ($parameters as $key => $value) {
    	    $builder->add($key, 'hidden');
    	}

    	return $builder->getForm();
    }

    public function formatPrice($price)
    {
        $price = round($price, 2);
        $price = str_replace('.', '', $price);
        $price = str_replace(',', '', $price);

        return $price;
    }
}