<?php

namespace Clab\PayzenBundle\Service;

use Clab\PayzenBundle\Service\ParameterResolver;

use Clab\PayzenBundle\Entity\PayzenRequest;

abstract class Payzen
{
    protected $url = 'https://secure.payzen.eu/vads-payment/';
    protected $certificate;
    protected $testcertificate;

    protected $parameters = array();

    public function initParameters(array $parameters)
    {
    	$this->parameters = array(
    	    'vads_site_id' => $parameters['site'],
    	);

    	$this->certificate = $parameters['certificate'];
        $this->testcertificate = $parameters['testcertificate'];
    	unset($parameters['certificate']);
        unset($parameters['testcertificate']);
    }

    public function setParameter($name, $value)
    {
    	$this->parameters[$name] = $value;

    	return $this;
    }

    public function setParameters(array $parameters)
    {
    	foreach ($parameters as $name => $value) {
    	    $this->setParameter($name, $value);
    	}

    	return $this;
    }

    public function getParameter($name)
    {
	   return (isset($this->parameters[$name])) ? $this->parameters[$name] : null;
    }

    public function getParameters()
    {
    	//$resolver = new ParameterResolver();

    	$this->setParameter('signature', $this->computeSignature($this->parameters));

    	//return $resolver->resolve($this->parameters);
    	return $this->parameters;
    }

    public function setEnv($env)
    {
    	$this->parameters['vads_ctx_mode'] = $env;

    	return $this;
    }

    public function getEnv()
    {
	   return (isset($this->parameters['vads_ctx_mode'])) ? $this->parameters['vads_ctx_mode'] : null;
    }

    public function getUrl()
    {
	   return $this->url;
    }

    public function computeSignature($parameters)
    {
    	if(isset($parameters['signature'])) {
    	    unset($parameters['signature']);
    	}

    	ksort($parameters);
    	$signature = "";
    	foreach ($parameters as $name => $value)
    	{
    	    if(substr($name,0,5) == 'vads_') {
    		$signature .= $value . "+";
    	    }
    	}

        if($this->getEnv() == 'TEST') {
            $signature .= $this->testcertificate;
        } else {
            $signature .= $this->certificate;
        }

    	$computedSignature = sha1($signature);

    	return $computedSignature;
    }
}