<?php

namespace Drupal\kadabrait_content\Plugin\Block;

use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\kadabrait_content\Service\KadabraitContentInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'LastContentBlock' block.
 *
 * @Block(
 *  id = "last_content_block",
 *  admin_label = @Translation("Last content block"),
 * )
 */
class LastContentBlock extends BlockBase implements ContainerFactoryPluginInterface
{

  protected KadabraitContentInterface $kadabraitContent;

  /**
   * Constructor.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, KadabraitContentInterface $kadabrait_content) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->kadabraitContent = $kadabrait_content;
  }

  /**
   * Dependency Injection.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): LastContentBlock {
    return new static(
      $configuration, $plugin_id, $plugin_definition,
      $container->get('kadabrait_content.default')
    );
  }


  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'quantity' => [
        'value' => 3,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state): array {
    $form['quantity'] = [
      '#type' => 'details',
      '#title' => $this->t("Cantidad"),
      '#open' => TRUE,
    ];
    $form['quantity']['label'] = [
      '#plain_text' => t("Etiqueta de Cantidad"),
    ];
    $form['quantity']['input'] = [
      '#type' => 'number',
      '#min' => 0,
      '#size' => 3,
      '#default_value' => $this->configuration['quantity']['value'] ?? 0,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['quantity'] = $form_state->getValues()['quantity'];
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {

    $nodes = $this->kadabraitContent->getContentByUser($this->configuration['quantity']['value']);

    $content = [];
    foreach ($nodes as $item)
    {
      $content[] = [
        'url' => $item->Url(),
        'title' => $item->getTitle(),
      ];

    }

    return [
      '#theme'=> 'last_content_block',
      '#content' => $content,
    ];
  }
}
