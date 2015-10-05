<?php

namespace Clab\PayzenBundle\Service;

abstract class PayzenWebservice
{
    protected $certificate;
    protected $parameters = array();

    public function initParameters(array $parameters)
    {
        $this->parameters = array(
            'shopId' => $parameters['site'],
        );

        $this->certificate = $parameters['certificate'];
        unset($parameters['certificate']);
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
        //$this->setParameter('signature', $this->computeSignature($this->parameters));

        return $this->parameters;
    }

    public function setEnv($env)
    {
        $this->parameters['ctxMode'] = $env;

        return $this;
    }

    public function getEnv()
    {
       return (isset($this->parameters['ctxMode'])) ? $this->parameters['ctxMode'] : null;
    }
}