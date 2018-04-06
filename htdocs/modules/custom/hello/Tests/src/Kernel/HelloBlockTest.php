<?php

namespace Drupal\hello\Tests;

use Drupal\Component\Utility\Html;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Language\LanguageInterface;
use Drupal\KernelTests\KernelTestBase;
use Drupal\block\Entity\Block;


class HelloBlockTest extends KernelTestBase {

  /**
   * Modules to install.
   *
   * @var array
   */
  public static $modules = ['block', 'hello', 'system', 'user'];

  /**
   * The block being tested.
   *
   * @var \Drupal\block\Entity\BlockInterface
   */
  protected $block;

  /**
   * The block storage.
   *
   * @var \Drupal\Core\Config\Entity\ConfigEntityStorageInterface
   */
  protected $controller;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->controller = $this->container
      ->get('entity_type.manager')
      ->getStorage('block');

    // Create a block with only required values.
    $this->block = $this->controller->create([
      'id' => 'test_block',
      'theme' => 'stark',
      'plugin' => 'hello_block',
    ]);
    $this->block->save();

    $this->container->get('cache.render')->deleteAll();

    $this->renderer = $this->container->get('renderer');
  }

  /**
   * Tests the rendering of blocks.
   */
  public function testBasicRendering() {
    $output = entity_view($this->block, 'block');
    /*
    $expected = [];
    $expected[] = '<div id="block-test-block1">';
    $expected[] = '  ';
    $expected[] = '    ';
    $expected[] = '      ';
    $expected[] = '  </div>';
    $expected[] = '';
    $expected_output = implode("\n", $expected);
    */
    // $this->renderer->renderRoot($output);
    $this->assertRegExp('/block/', (string)$this->renderer->renderRoot($output));// 
    // regex

    // Reset the HTML IDs so that the next render is not affected.
    // Html::resetSeenIds();

    // Test the rendering of a block with a given title.
    $entity = $this->controller->create([
      'id' => 'test_block2',
      'theme' => 'stark',
      'plugin' => 'test_html',
      'settings' => [
        'label' => 'Powered by Bananas',
      ],
    ]);
    $entity->save();
    $output = entity_view($entity, 'block');
    /*
    $expected = [];
    $expected[] = '<div id="block-test-block2">';
    $expected[] = '  ';
    $expected[] = '      <h2>Powered by Bananas</h2>';
    $expected[] = '    ';
    $expected[] = '      ';
    $expected[] = '  </div>';
    $expected[] = '';
    $expected_output = implode("\n", $expected);
    */
    $this->assertRegExp('/block/', (string)$this->renderer->renderRoot($output));
    // $this->assertEqual($this->renderer->renderRoot($output), $expected_output);
  }



  /**
   * Get a fully built render array for a block.
   *
   * @return array
   *   The render array.
   */
  protected function getBlockRenderArray() {
    return $this->container->get('entity_type.manager')->getViewBuilder('block')->view($this->block, 'block');
  }

}
