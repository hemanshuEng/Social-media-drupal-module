<?php
declare(strict_types=1);

namespace Drupal\champions_social\Plugin\Block;

use Drupal\champions_social\SocialMedia\PlatformManager;
use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'SocialMediaBlock' block.
 *
 * @Block(
 *  id = "social_media_block",
 *  admin_label = @Translation("Social Media Block"),
 * )
 */
class SocialMediaBlock extends BlockBase implements ContainerFactoryPluginInterface{

  /**
   * @var PlatformManager
   */
  private $platform_manager;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, PlatformManager $platform_manager)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->platform_manager = $platform_manager;
  }
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('champions_social.platform')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $platforms = $this->platform_manager->getPlatforms();
    $form['platforms'] = [
      '#type' => 'table',
      '#header' => [
        $this->t('Platform'),
        $this->t('URL')
      ]
    ];
    foreach ($platforms as $id => $platform) {
      $form['platforms'][$id]['label'] = [
        '#markup' => $platform['instance']->getName()
      ];
      $form['platforms'][$id]['channel_name'] = [
        '#type' => 'textfield',
        '#default_value' => $config['platforms'][$id]['channel_name'] ?? '' ,
        '#field_prefix' => $platform['instance']->getUrlPrefix(),
        '#field_suffix' => $platform['instance']->getUrlSuffix(),
      ];
    }
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['platforms'] = $form_state->getValue('platforms');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $build = [];
    $build['#theme'] = 'champions_social';
    $build['#conten'] = !empty($config['drupal_boilerplate_title']) ? $config['drupal_boilerplate_title'] : '';

    return $build;
  }


}
