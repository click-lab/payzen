<?php

namespace Clab\PayzenBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ResponseController extends Controller
{
    public function paymentAction()
    {
    	$response = $this->get('clab_payzen.payzen_response');
    	$valid = $response->compute();

        return new Response($valid ? 'OK' : 'KO',200);
    }
}
