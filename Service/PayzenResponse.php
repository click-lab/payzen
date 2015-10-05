<?php

namespace Clab\PayzenBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Clab\PayzenBundle\Service\ParameterResolver;

use Clab\PayzenBundle\Service\Payzen;
use Clab\PayzenBundle\Entity\PayzenResponse as PayzenResponseEntity;
use Clab\PayzenBundle\Event\PayzenResponseEvent;
use Clab\PayzenBundle\Entity\PayzenAccount;
use Clab\PayzenBundle\Event\PayzenAccountEvent;

class PayzenResponse extends Payzen
{
    protected $container;
    protected $em;
    protected $request;

    protected $signature;

    public function __construct(array $parameters, ContainerInterface $container, EntityManager $em)
    {
    	$this->em = $em;
    	$this->container = $container;
    	$this->request = $this->container->get('request');
    	$this->signature = $this->request->get('signature');

    	$this->initParameters($parameters);
    }

    public function initParameters(array $parameters)
    {
    	parent::initParameters($parameters);

    	foreach($this->request->request->all() as $name => $value) {
    	    if(substr($name,0,5) == 'vads_') {
    		$this->setParameter($name, $value);
    	    }
    	}
    }

    /*
     *  Should compute the request/signature and launch events (success/failure)
     *  return true/false depending on validity
     */
    public function compute()
    {
        $response = new PayzenResponseEntity();
        $response->setTransactionId($this->getParameter('vads_trans_id'));
        $response->setVadsAuthResult($this->getParameter('vads_auth_result'));
        $response->setVadsTransStatus($this->getParameter('vads_trans_status'));
        $response->setVadsOrderId($this->getParameter('vads_order_id'));
        $response->setVadsOrderInfo($this->getParameter('vads_order_info'));
        $response->setClabType($this->getParameter('vads_ext_info_clab_type'));
        $response->setClabIdentifier($this->getParameter('vads_ext_info_clab_identifier'));
        $response->setParameters(serialize($this->getParameters()));
        $this->em->persist($response);

    	if($this->signature == $this->computeSignature($this->parameters)) {
            $response->setIsVerified(true);
            $this->em->flush();

            $event = new PayzenResponseEvent($response, true);
            $this->container->get('event_dispatcher')->dispatch('clab_payzen.response_done', $event);

            if($this->getParameter('vads_identifier'))
            {
                $account = $this->em->getRepository('ClabPayzenBundle:PayzenAccount')->findOneBy(array('identifier' => $this->getParameter('vads_identifier')));

                if(!$account) {
                    $account = new PayzenAccount();
                    $account->setIdentifier($this->getParameter('vads_identifier'));
                    $account->setVadsIdentifierStatus($this->getParameter('vads_identifier_status'));
                    $account->setVadsCustEmail($this->getParameter('vads_cust_email'));
                    $account->setVadsCardNumber($this->getParameter('vads_card_number'));
                    $account->setVadsCardBrand($this->getParameter('vads_card_brand'));
                    $account->setVadsCardCountry($this->getParameter('vads_card_country'));
                    $account->setVadsExpiryMonth($this->getParameter('vads_expiry_month'));
                    $account->setVadsExpiryYear($this->getParameter('vads_expiry_year'));
                    $account->setVadsCustId($this->getParameter('vads_cust_id'));
                    $account->setClabType($this->getParameter('vads_ext_info_clab_type'));
                    $account->setClabIdentifier($this->getParameter('vads_ext_info_clab_identifier'));
                    $this->em->persist($account);
                    $this->em->flush();

                    $accountEvent = new PayzenAccountEvent($account);
                    $this->container->get('event_dispatcher')->dispatch('clab_payzen.account', $accountEvent);
                }
            }

    	    return true;
    	}

        $this->em->flush();
    	return false;
    }
}