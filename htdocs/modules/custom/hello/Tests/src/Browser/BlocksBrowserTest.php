<?php

namespace Drupal\hello\Tests;

use Drupal\Tests\BrowserTestBase;

class HelloBlocksBrowserTest extends BrowserTestBase {

  protected function setUp() {
  }

  public function testBookWithPendingRevisions() {
    $driver = new \Behat\Mink\Driver\GoutteDriver();
    $session = new \Behat\Mink\Session($driver);
    $session->start();
    $session->visit('http://web/hello');
    $session->getStatusCode();
    $page = $session->getPage();
    $element = $page->find('css', '#block-bartik-content');
    $text  = $element->getText();
    $this->assertRegExp('/You are on the Hello page/', $text);
    $session->getCurrentUrl();
  }

}

