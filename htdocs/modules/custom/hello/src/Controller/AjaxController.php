<?php

namespace Drupal\hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\InvokeCommand;

class AjaxController extends ControllerBase {

  public function content() {
    $response = new AjaxResponse();
    $message  = $this->listing();
    // $response->AddCommand(new CssCommand("[name=$field]", $css));
    $response->AddCommand(new HtmlCommand('.field--name-title', $message));
    return $response;
  }

	  public function webhook() {
	  $queue_factory = \Drupal::service('queue');
	  $queue_manager = \Drupal::service('plugin.manager.queue_worker');

	  $queue = $queue_factory->get('natural_language_webhook_call');
	  $queue_worker = $queue_manager->createInstance('natural_language_webhook_call');

	  $item = new \stdClass();
	  $item->secret_code = rand(0, 100);
	  $queue->createItem($item);
	  /*
		while($item = $queue->claimItem()) {
			dump($item);
			try {
			  $output = $queue_worker->processItem($item->data);
			  $queue->deleteItem($item);
			}
			catch (SuspendQueueException $e) {
			  $queue->releaseItem($item);
			  break;
			}
			catch (\Exception $e) {
			  watchdog_exception('npq', $e);
			}
		}
		*/

    return ['#markup' => 'Output: '.$output];
  }

  public function messageWorker() {

  $queue_factory = \Drupal::service('queue');
  $queue_manager = \Drupal::service('plugin.manager.queue_worker');

  $queue = $queue_factory->get('natural_language_webhook_call');
  $queue_worker = $queue_manager->createInstance('natural_language_webhook_call');

	while($item = $queue->claimItem()) {
		try {
		  $output = $queue_worker->processItem($item->data);
		  $queue->deleteItem($item);
		}
		catch (SuspendQueueException $e) {
		  $queue->releaseItem($item);
		  break;
		}
		catch (\Exception $e) {
		  watchdog_exception('npq', $e);
		}
	}

    return ['#markup' => 'Output: '.$output];
  }


  public function listing() {
	$database = \Drupal::service('database');
	$query = $database->select('queue', 'q')
       ->fields('q', array('item_id', 'data', 'expire', 'created'))
       ->condition('q.name', 'natural_language_webhook_call')
       ->orderBy('q.item_id', 'DESC');
     // If there are affected rows, this update succeeded.
    $result = $query->execute();
    // kint($result);
    foreach($result as $item){
    	$rows[$i]['item_id'] = $item->item_id;
    	$rows[$i]['secret_code'] = unserialize($item->data)->secret_code;
    	$rows[$i]['expire'] = $item->expire;
    	$rows[$i]['created'] = $item->created;
    $i++;
	}

	$queue_factory = \Drupal::service('queue');
	$queue_manager = \Drupal::service('plugin.manager.queue_worker');

	$queue = $queue_factory->get('natural_language_webhook_call');
	$queue_worker = $queue_manager->createInstance('natural_language_webhook_call');
  	/*
	dump($queue);
	while($item = $queue->claimItem()) {
		$rows[] = $item->data;
		 // $queue->releaseItem($item);
	}
	dump($rows);
	*/
	$header = array('item_id', 'secret code', 'expire', 'created');

    return ['#theme' => 'table', '#header' => $header, '#rows' => $rows];
  }

}
