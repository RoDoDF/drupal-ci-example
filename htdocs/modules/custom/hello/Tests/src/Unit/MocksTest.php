<?php

namespace Drupal\hello\Tests;

use Drupal\hello\HelloMathFunctions;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\hello\Plugin\Block\HelloBlock;

use PHPUnit\Framework\TestCase;
use Drupal\Tests\UnitTestCase;


// class MathFunctionsTest extends UnitTestCase {
class MocksTest extends UnitTestCase {

  protected function setUp() {
  }

  /**
   * Tests for a the hover of sub menus.
   */
  public function testHelloMathFunctionsAddition() {
    
    $this->statement = $this->getMockBuilder('Drupal\Core\Database\Driver\sqlite\Statement')
    ->disableOriginalConstructor()
    ->getMock();

    $this->statement->expects($this->any())
      ->method('fetchField')
      ->willReturn(1342);

    $this->select = $this->getMockBuilder('Drupal\Core\Database\Query\Select')
      ->disableOriginalConstructor()
      ->getMock();
    
    $this->select
      ->method('fields')
      ->will($this->returnSelf());

    $this->select
      ->method('condition')
      ->will($this->returnSelf());

    $this->select
    ->method('execute')
    ->will($this->returnValue($this->statement));

    $database = $this->getMockBuilder('Drupal\Core\Database\Connection')
    ->disableOriginalConstructor()
    ->getMock();

    $database
    ->method('select')
    ->will($this->returnValue($this->select));


    

    // $result = $database->select('sessions', 's')->execute()->fetchField();

    

    $user_mock = $this->getMockBuilder('Drupal\Core\Session\AccountProxyInterface')
    ->disableOriginalConstructor()
    ->getMock();

    $user_mock
    ->method('getAccountName')
    ->willReturn('admin');
    
    $dateformatter_mock = $this->getMockBuilder('Drupal\Core\Datetime\DateFormatter')
    ->disableOriginalConstructor()
    ->getMock();

    $time = time();

    $dateformatter_mock
    ->method('format')
    ->willReturn($time);

    $container = new ContainerBuilder();
    // $container->set('database', $database);
    $container->set('current_user', $user_mock);
    $container->set('date.formatter', $dateformatter_mock);
    $container->set('string_translation', $this->getStringTranslationStub());
    \Drupal::setContainer($container);
    $controller = \Drupal\hello\Controller\HelloController::create($container);
    // You are on the Hello page. Your name is 1342! URL parameter is hey.' matches expected 0.5.
    $output = strip_tags($controller->content('hey')['#markup']->render());
    // $this->assertEquals(0.5, $output);
    $this->assertRegExp('/You are on the Hello page/', $output);

    $block_id = 'hello_block';
    $config = array();
    $definition = array();
    $definition['provider'] = ' ';

    $plugin = \Drupal\hello\Plugin\Block\HelloBlock::create($container, $config, $block_id, $definition);
    $output = strip_tags($plugin->build()['#markup']->render());
    $this->assertRegExp('/It is/', $output);


  }

}
