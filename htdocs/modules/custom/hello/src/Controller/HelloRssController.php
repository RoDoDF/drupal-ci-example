<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

class HelloRssController extends ControllerBase {

  public function content() {
    // Afin de passer outre le thème et renvoyer des données brute, il faut retourner
    // un objet de type Symfony\Component\HttpFoundation\Response.
    $response = new Response();
    $response->headers->set('Content-Type', 'application/json');
    $response->setContent(json_encode(array('do', 'ré', 'mi')));
    return $response;
  }
}
