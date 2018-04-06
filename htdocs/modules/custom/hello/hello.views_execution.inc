<?php

use Drupal\views\Plugin\views\query\QueryPluginBase;
use Drupal\views\ViewExecutable;

/**
 * Implements hook_views_query_alter
 * @param type $view
 * @param type $query
 */

function hello_views_query_alter(ViewExecutable $view, QueryPluginBase $query) {

  //drupal_set_message('test view');

}