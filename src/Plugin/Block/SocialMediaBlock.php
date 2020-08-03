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

    $form['drupal_boilerplate_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => isset($config['drupal_boilerplate_title']) ? $config['drupal_boilerplate_title'] : '',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['drupal_boilerplate_title'] = $form_state->getValue('drupal_boilerplate_title');
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
