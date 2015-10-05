<?php

namespace Clab\PayzenBundle\Service;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

class ParameterResolver
{
    private $knownParameters;
    private $requiredParameters;

    private $resolver;

    public function __construct()
    {
	   $this->resolver = new OptionsResolver();

    	$this->knownParameters = array(
    	    // global
    	    'vads_ctx_mode',
    	    'vads_site_id',
    	    'vads_version',
    	    'vads_language',
    	    'vads_trans_date',
    	    'vads_trans_id',
    	    'vads_currency',
    	    'vads_page_action',
    	    'vads_action_mode',
    	    'vads_payment_config',
    	    // return
    	    'vads_url_return',
    	    'vads_url_success',
    	    'vads_url_refused',
    	    'vads_url_cancel',
    	    'vads_url_error',
    	    'vads_return_mode',
    	    'vads_redirect_success_timeout',
    	    'vads_redirect_success_message',
    	    'vads_redirect_error_timeout',
    	    'vads_redirect_error_message',
    	    'vads_validation_mode',
    	    // order
    	    'vads_amount',
    	    'vads_order_id',
    	    'vads_cust_id',
    	    'vads_cust_email',
    	    'signature'
    	);
    }

    public function resolve(array $parameters)
    {
	   $this->initParameters();

	   return $this->resolver->resolve($parameters);
    }

    protected function initParameters()
    {
    	$this->requiredParameters = array(
    	    /*
    	    // global
    	    'vads_ctx_mode',
    	    'vads_site_id',
    	    'vads_version',
    	    'vads_trans_date',
    	    'vads_trans_id',
    	    'vads_currency',
    	    'vads_page_action',
    	    'vads_action_mode',
    	    'vads_payment_config',
    	    // order
    	    'vads_amount',
    	    'signature',
    	    */
    	);

    	$this->initResolver();
    }

    protected function initResolver()
    {
	   $this->resolver->setRequired($this->requiredParameters);

	   $this->resolver->setOptional(array_diff($this->knownParameters, $this->requiredParameters));

	   $this->initAllowed();
    }

    protected function initAllowed()
    {
    	$this->resolver->setAllowedValues(array(
    	    'vads_currency' => array('978', '840'),
    	    'vads_version' => array('V2'),
    	    'vads_payment_config' => array('SINGLE', 'MULTI', 'MULTI_EXT'),
    	    'vads_page_action' => array('PAYMENT'),
    	    'vads_action_mode' => array('INTERACTIVE', 'SILENT'),
    	    'vads_ctx_mode' => array('TEST', 'PRODUCTION'),
    	    'vads_return_mode' => array('NONE', 'GET', 'POST'),
    	    'vads_validation_mode' => array(0, 1),
    	));
    }
}
