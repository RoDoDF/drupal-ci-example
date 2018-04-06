<?php

namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a hello block.
 *
 * @Block(
 *  id = "hello_block",
 *  admin_label = @Translation("Hello!")
 * )
 */
class HelloBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $dateFormatter;
  protected $currentUser;

  public function __construct(array $configuration,
                              $plugin_id,
                              $plugin_definition,
                              DateFormatterInterface $dateFormatter,
                              AccountProxyInterface $currentUser) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dateFormatter = $dateFormatter;
    $this->currentUser = $currentUser;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('date.formatter'),
      $container->get('current_user')
    );
  }

  /**
   * Implements Drupal\Core\Block\BlockBase::build().
   */
  public function build() {

    $this->dateFormatter = \Drupal::service('date.formatter');
    $this->currentUser = \Drupal::service('current_user');

    $build = array(
      '#markup' => $this->t('Welcome %name. It is %time.', array(
        '%name' => $this->currentUser->getAccountName(),
        '%time' => $this->dateFormatter->format(time(), 'custom', 'H:i s\s'),
      )),
      '#cache' => array(
        'keys' => ['hello_block'],
        'max-age' => '20',
      ),
    );

    return $build;
  }

}
