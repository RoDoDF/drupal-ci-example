<?php

namespace Drupal\hello\Tests;

use Drupal\hello\HelloMathFunctions;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hello\Plugin\Block\HelloBlock;

use PHPUnit\Framework\TestCase;
use Drupal\Tests\UnitTestCase;


// class MathFunctionsTest extends UnitTestCase {
class MathFunctionsTest extends UnitTestCase {

  protected function setUp() {
  }

  /**
   * Tests for a the hover of sub menus.
   */
  public function testHelloMathFunctionsAddition() {
      $math = new HelloMathFunctions();
      $resultat = $math->operation(1, 2, 'addition');
      $this->assertEquals(3, $resultat);
      $resultat = $math->operation(2, 2, 'addition');
      $this->assertEquals(4, $resultat);
      $resultat = $math->operation(10, 2, 'addition');
      $this->assertEquals(12, $resultat);

  }

  /**
   * Tests for a the hover of sub menus.
   */
  public function testHelloMathFunctionsMultiplication() {
      $math = new HelloMathFunctions();
      $resultat = $math->operation(4, 2, 'multiplication');
      $this->assertEquals(8, $resultat);
      $resultat = $math->operation(1, 2, 'multiplication');
      $this->assertEquals(2, $resultat);
      $resultat = $math->operation(5, 2, 'multiplication');
      $this->assertEquals(10, $resultat);
  }

  /**
   * Tests for a the hover of sub menus.
   */
  public function testHelloMathFunctionsDivision() {
      $math = new HelloMathFunctions();
      $resultat = $math->operation(1, 2, 'division');
      $this->assertEquals(0.5, $resultat);
      $resultat = $math->operation(6, 3, 'division');
      $this->assertEquals(2, $resultat);
      $resultat = $math->operation(8, 4, 'division');
      $this->assertEquals(2, $resultat);
  }

}
