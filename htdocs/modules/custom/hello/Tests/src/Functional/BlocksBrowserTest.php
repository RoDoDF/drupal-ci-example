<?php

namespace Drupal\hello\Tests;

use Drupal\Tests\BrowserTestBase;
use Drupal\workflows\Entity\Workflow;
use \Drupal\Tests\book\Functional\BookTestTrait;

/**
 * Tests Book and Content Moderation integration.
 *
 * @group book
 */
class HelloBlocksBrowserTest extends BrowserTestBase {

  use BookTestTrait;

  /**
   * Modules to install.
   *
   * @var array
   */
  public static $modules = ['book', 'block', 'book_test', 'content_moderation'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
  }

  /**
   * Tests that book drafts can not modify the book outline.
   */
  public function testBookWithPendingRevisions() {

    $startUrl = 'http://www.lemonde.fr/immigration-et-diversite/article/2018/01/16/immigration-les-expulsions-des-etrangers-en-situation-irreguliere-ont-augmente-de-14-6-en-2017_5242278_1654200.html';

    $driver = new \Behat\Mink\Driver\GoutteDriver();

    $session = new \Behat\Mink\Session($driver);
    // start the session
    $session->start();
    $session->visit('http://drupal-open-groupe.dd:8083');

    // $this->htmlOutputEnabled = true;
    // $this->htmlOutputDirectory = '/Users/romain/Sites/drupal-open-groupe/browsertest_output/';
    $this->baseUrl = 'http://drupal-open-groupe.dd:8083';

    // $content = file_get_contents($this->baseUrl);
    // print $content;
    // $this->htmlOutputFile = 'boum.html';
    // $this->htmlOutputClassName = 'ooo';
    // print $this->minkDefaultDriverClass;
    // print $this->baseUrl;
    // print 'zzz';
    // parent::setUp();
    // print 'nnn';
    // $this->getSession()->visit($startUrl);
    $session->getStatusCode();
    $page = $session->getPage();
    $element = $page->find('css', '#block-hellocount');
    // print $element->getTagName();
    $text  = $element->getText();
     $this->assertRegExp('/Session/', $text);
    // print $element->getHtml();
    // print $element->getOuterHtml();
    // print $session->getPage()->getContent();
    $session->getCurrentUrl();
    // print $this->getSession()->getPage();
    /*
    $this->drupalPlaceBlock('system_breadcrumb_block');
    $this->drupalPlaceBlock('page_title_block');
    */
  }

}

