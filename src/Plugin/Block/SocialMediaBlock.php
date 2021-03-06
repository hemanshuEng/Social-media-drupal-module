<?php

declare(strict_types=1);

namespace Drupal\champions_social\Plugin\Block;

use Drupal\champions_social\SocialMedia\PlatformManager;
use Drupal\Component\Render\FormattableMarkup;
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
class SocialMediaBlock extends BlockBase implements ContainerFactoryPluginInterface
{

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
    public function defaultConfiguration()
    {
        return [
        ] + parent::defaultConfiguration();
    }

  /**
   * {@inheritdoc}
   */
    public function blockForm($form, FormStateInterface $form_state)
    {

        $form = parent::blockForm($form, $form_state);
        $config = $this->getConfiguration();
      //Platform Form
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
            '#title' => $platform['instance']->getName(),
            '#title_display' => 'invisible',
            '#default_value' => $config['platforms'][$id]['channel_name'] ?? '' ,
            '#field_prefix' => $platform['instance']->getUrlPrefix(),
            '#field_suffix' => $platform['instance']->getUrlSuffix(),
            ];
        }

      //Icon styles
        $iconsetStyles = ['Iconmoon' => 'Iconmoon','Flaticon' => 'Flaticon', 'Orion' => 'Orion'];

        $form['icon'] = [
        '#type' => 'details',
        '#title' => $this->t('Icon Select'),
        '#open' => true,
        ];
        $form['icon']['style'] = [
        '#type' => 'select',
        '#title' => $this->t('Choose Icon Style'),
        '#default_value' => isset($config['icon']['style']) ? $config['icon']['style'] : 'Iconmoon',
        '#options' => $iconsetStyles
        ];
        $form['icon']['table'] = [
        '#type' => 'table',
        '#header' => [
        $this->t('Icon'),
        $this->t('Icon Example')
        ]
        ];
        foreach ($iconsetStyles as $icon) {
            $form['icon']['table'][$icon]['label'] = [
            '#markup' => '<strong>' . $icon . '</strong>'
            ];
            foreach ($platforms as $id => $platform) {
                $form['icon']['table'][$icon]['example'][$id]['label']  = [
                '#markup' => new FormattableMarkup(
                    '<img class="socialmedia" src="@image" width="32" height="32" style="padding: 15px;"/>',
                    [
                    '@image' =>  file_create_url(
                        drupal_get_path('module', 'champions_social') . '/images/' . $icon . '/' . $id . '.svg'
                    )
                    ]
                )
                ];
            }
        }

      //Layout selection
        $form['layout'] = [
        '#type' => 'select',
        '#title' => $this->t('Choose Layout Style'),
        '#default_value' => isset($config['layout']) ? $config['layout'] : 'horizontal',
        '#options' => [
        'vertical' => 'vertical',
        'horizontal' => 'horizontal'
        ]
        ];
        return $form;
    }

  /**
   * {@inheritdoc}
   */
    public function blockSubmit($form, FormStateInterface $form_state)
    {
        $this->configuration['platforms'] = $form_state->getValue('platforms');
        $this->configuration['icon'] = $form_state->getValue('icon');
        $this->configuration['layout'] = $form_state->getValue('layout');
    }

  /**
   * {@inheritdoc}
   */
    public function build()
    {
        $config = $this->getConfiguration();
        $platforms = $this->platform_manager->getPlatforms();
        $platforms_data = [];
        foreach ($platforms as $id => $platform) {
            $platforms_data[$id]['url'] =  $platform['instance']->getUrlPrefix()
              . $config['platforms'][$id]['channel_name']
              . $platform['instance']->getUrlSuffix();
            $platforms_data[$id]['name'] = $platform['instance']->getId();
            $platforms_data[$id]['channel_name'] =  $config['platforms'][$id]['channel_name'];
        }
        $build['#theme'] = "champions_social";
        $build['#platforms'] = $platforms_data;
        $build['#icon'] = $config['icon']['style'] ?? 'Iconmoon';
        $build['#layout'] = $config['layout'] ?? 'horizontal';

        return $build;
    }
}
