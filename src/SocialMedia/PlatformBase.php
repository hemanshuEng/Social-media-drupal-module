<?php
declare(strict_types=1);

namespace Drupal\champions_social\SocialMedia;


use Drupal\Core\Plugin\PluginBase;

/**
 * Class PlatformBase
 *
 */
class PlatformBase extends PluginBase implements PlatformInterface
{

  public function __construct(array $configuration, $plugin_id, $plugin_definition)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   *@return string
   */
  public function getId()
    {
      return $this->pluginDefinition['id'];
    }

  /**
   * @return string
   */
  public function getName()
    {
      return $this->pluginDefinition['name'];
    }

  /**
   * @return string
   */
  public function getUrlSuffix()
    {
      return $this->pluginDefinition['urlSuffix'] ?? '';
    }

  /**
   * @return string
   */
  public function getUrlPrefix()
    {
        return $this->pluginDefinition['urlPrefix'] ?? '';
    }
}
