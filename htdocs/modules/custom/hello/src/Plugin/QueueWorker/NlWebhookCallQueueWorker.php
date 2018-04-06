<?php

namespace Drupal\hello\Plugin\QueueWorker;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Psr\Log\LoggerInterface;


/**
 * A Node Publisher that publishes nodes on CRON run.
 *
 * @QueueWorker(
 *   id = "natural_language_webhook_call",
 *   title = @Translation("Nl webhook call"),
 *   cron = {"time" = 10}
 * )
 */
class NlWebhookCallQueueWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * The node storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $nodeStorage;

  /**
   * Creates a new NodePublishBase object.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $node_storage
   *   The node storage.
   */
  public function __construct(EntityStorageInterface $node_storage, LoggerInterface $logger) {
    $this->nodeStorage = $node_storage;
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('entity.manager')->getStorage('node'),
      $container->get('logger.factory')->get('natural_language')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $message = time();
    dump($data);
    $this->logger->info('secret_code = '.$data->secret_code);
    return $data->secret_code;
    /** @var NodeInterface $node */
  }
}