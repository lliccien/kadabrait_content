<?php

namespace Drupal\kadabrait_content\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the kadabrait_content module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "kadabrait_content DefaultController's controller functionality",
      'description' => 'Test Unit for module kadabrait_content and controller DefaultController.',
      'group' => 'Other',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests kadabrait_content functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module kadabrait_content.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
