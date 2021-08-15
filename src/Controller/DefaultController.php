<?php

namespace Drupal\kadabrait_content\Controller;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Controller\ControllerBase;
use Drupal\kadabrait_content\Service\KadabraitContentInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase
{

    protected KadabraitContentInterface $kadabraitContent;

  /**
   * Constructor.
   */
    public function __construct(KadabraitContentInterface $kadabrait_content)
    {
        $this->kadabraitContent = $kadabrait_content;
    }

  /**
   * Dependency Injection.
   */
    public static function create(ContainerInterface $container): DefaultController
    {
        return new static(
            $container->get('kadabrait_content.default')
        );
    }

  /**8 get
   * ShowLast10contents.
   *
   * @return array
   *   Return Hello string.
   */
    public function showLast10Contents(): array
    {
        $content = $this->kadabraitContent->getContentByUser(10);

        $header = [
          'Title',
          'Type',
          'Created',
        ];

        $rows = [];
        foreach ($content as $item) {
            $rows[] = [
                new FormattableMarkup('<a href="@url">@title</a>',['@url' => $item->Url(),'@title' => $item->getTitle()]),
                $item->getType(),
                \Drupal::service('date.formatter')->format($item->getCreatedTime(), 'date_text')
            ];
        }

        return [
          '#type' => 'table',
          '#header' => $header,
          '#rows' => $rows
        ];
    }
}
