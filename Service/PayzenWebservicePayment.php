<?php

namespace Clab\PayzenBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

use Clab\PayzenBundle\Service\PayzenWebservice;
use Clab\PayzenBundle\Entity\PayzenRequest as PayzenRequestEntity;
use Clab\PayzenBundle\Entity\PayzenAccount;

class PayzenWebservicePayment extends PayzenWebservice
{
    protected $em;
    protected $container;
    protected $payzenAccount = null;

    protected $dateW3C;
    protected $dateUTC;

    public function __construct(array $parameters, ContainerInterface $container, EntityManager $em)
    {
        $this->em = $em;
        $this->container = $container;

        $this->dateW3C = gmdate('Y-m-d\TH:i:sP');
        $this->dateUTC = gmdate('Ymd');

        $this->initParameters($parameters);
    }

    public function initParameters(array $parameters)
    {
        parent::initParameters($parameters);

        $this->setParameters(array(
            'transmissionDate' => $this->dateW3C,
            'paymentMethod' => 'EC',
            'devise' => '978',
            'ctxMode' => 'TEST',
        ));

        $this->setParameter('transactionId', sprintf('%06d', $this->getTransactionId()));
    }

    public function setPayzenAccount(PayzenAccount $payzenAccount)
    {
        $this->payzenAccount = $payzenAccount;

        $this->setParameters(array(
            'cardIdent' => $payzenAccount->getIdentifier(),
            //'cvv' =>
        ));
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

    public function call()
    {
        $client = new \Soapclient('https://secure.payzen.eu/vads-ws/ident-v2.1?wsdl');


        $parameters = array(
            'createInfo' => $this->getParameters(),
            'wsSignature' => $this->computeSignature()
        );

        $parameters = array_merge($parameters, $this->getParameters());

        $result = $client->create($parameters);

        echo '<pre>';
        var_dump($result);
        die;
    }

    public function computeSignature()
    {
        $signature = '';
        $parameters = $this->getParameters();

        $signatureParameters = array('shopId', 'transmissionDate', 'transactionId', 'paymentMethod', 'orderId', 'orderInfo1', 'orderInfo2', 'orderInfo3', 'amount', 'devise', 'presentationDate', 'manualValidation', 'cardIdent', 'contractNumber', 'ctxMode', 'comment');

        foreach ($signatureParameters as $parameter) {
            if($parameter == 'transmissionDate') {
                $signature .= $this->dateUTC;
            } elseif(isset($parameters[$parameter])) {
                $signature .= $parameters[$parameter];
            }
            $signature .= '+';
        }

        $signature .= $this->certificate;

        $computedSignature = sha1($signature);

        return $computedSignature;
    }
}