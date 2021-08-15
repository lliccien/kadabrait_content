<?php

namespace Drupal\kadabrait_content\Service;

/**
 * Kadabra It content interface.
 */
interface KadabraitContentInterface {

  /**
   * Get content by user.
   */
  public function getContentByUser(int $quantity);

}
