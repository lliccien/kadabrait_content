<?php

namespace Drupal\kadabrait_content\Service;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;

/**
 * Class KadabreitContentService.
 */
class KadabreitContentService implements KadabraitContentInterface
{

  /**
   * Constructs a new KadabreitContentService object.
   */
    public function __construct()
    {
    }

  /**
   * Get content by user.
   *
   * @param int $quantity
   *   Quantity maximum of register.
   *
   *   Get query result.
   */
    public function getContentByUser(int $quantity): array
    {
        $user = \Drupal::currentUser();
        $query = \Drupal::entityQuery('node');
        $nodes_ids = $query->Condition('uid', $user->id())
        ->sort('created', 'DESC')
        ->range(0, ($quantity))
        ->execute();

        try {
            $nodes = \Drupal::entityTypeManager()->getStorage('node');
            $content = $nodes->loadMultiple($nodes_ids);
        } catch (InvalidPluginDefinitionException | PluginNotFoundException $e) {
          \Drupal::logger('kadabrait_content')->error($e->getMessage());
          return [];
        }

        return $content ?? [];
    }
}
