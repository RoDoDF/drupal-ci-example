<?php


namespace Drupal\hello\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a hello count block.
 *
 * @Block(
 *  id = "hello_count_block",
 *  admin_label = @Translation("Hello count")
 * )
 */
class HelloCountBlock extends BlockBase{

  /**
   * Implements Drupal\Block\BlockBase::build().
   */
  public function build() {


    /*
    $database = \Drupal::database();
    kint($database);
    $query = $database->select('sessions', 's');
    kint($query);
    $query = $query->countQuery();
    kint($query);
    $statement = $query->execute();
    kint($statement);
    $result = $statement->fetchField();
    kint($result);
    */
    
    $number = \Drupal::database()->select('sessions', 's')
      ->countQuery()
      ->execute()
      ->fetchField();

    return array(
      '#markup'  => $this->t('Session number: %number', array('%number' => $number)),
      '#cache' => array(
        'keys' => ['hello:sessions'],
        'tags' => ['sessions']
        ),
    );
  }


  protected function blockAccess($account) {
    # solution 1 (ok !)
    if($account->hasPermission('access hello')){
      return AccessResult::allowed();
    }else{
      return AccessResult::forbidden();
    }

    # solution 2 (meilleure !)
    return AccessResult::allowedIfHasPermission($account, 'access hello');
  }
}
