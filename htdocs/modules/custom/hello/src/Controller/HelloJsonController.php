<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class HelloJsonController extends ControllerBase {

  public function content() {

  	// solution 1
    $response = new Response();
    $response->setContent(json_encode([1, 2, 3, 4]));
    $response->headers->set('Content-Type', 'application/json');
    return $response;


  	// solution 2
    return new JsonResponse(array('do', 'ré', 'mi'));
  }
}
