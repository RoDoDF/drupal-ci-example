<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {

  public function content($param) {
    $message = $this->t('You are on the Hello page. Your name is %username! URL parameter is %param.', array(
      '%username' => $this->currentUser()->getAccountName(),
      '%param' => $param,
    ));
    $build = array(
      '#markup' => $message,
      //'#cache' => ['max-age' => '0'],
    );

    return $build;
  }

}
