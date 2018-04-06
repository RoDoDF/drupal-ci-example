<?php

namespace Drupal\hello;


class HelloMathFunctions {

  public function operation($value_1, $value_2, $operation) {
    $resultat = '';
    switch ($operation) {
      case 'addition':
        $resultat = $value_1 + $value_2;
        break;
      case 'soustraction':
        $resultat = $value_1 - $value_2;
        break;
      case 'multiplication':
        $resultat = $value_1 * $value_2;
        break;
      case 'division':
        $resultat = $value_1 / $value_2;
        break;
    }
    return $resultat;
  }

  public function carre($value) {
    $resultat = $value*$value;
    return $resultat;
  }

  public function racineCarre($value) {
    $resultat = $value*$value;
    return $resultat;
  }
}