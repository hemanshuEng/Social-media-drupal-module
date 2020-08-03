<?php


namespace Drupal\champions_social\SocialMedia;


use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

class PlatformManager extends \Drupal\Core\Plugin\DefaultPluginManager
{
  /**
   * PlatformManager constructor.
   * @param \Traversable $namespaces
   * @param CacheBackendInterface $cache_backend
   * @param ModuleHandlerInterface $module_handler
   */
   public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler)
   {
     parent::__construct('SocialMedia/Platform', $namespaces, $module_handler, 'Drupal\champions_social\SocialMedia\PlatformInterface' , 'Drupal\champions_social\Annotation\Platform');
     $this->alterInfo('archiver_info_plugins');
     $this->setCacheBackend($cache_backend, 'archiver_info_plugins');
   }

  /**
   * Get all platform plugins.
   *
   * @return array
   *   The platform plugins.
   */
  public function getPlatforms() {
    $plugins = $this->getDefinitions();

    // Attach the instance object to the plugin definitions.
    foreach ($plugins as $plugin_id => $plugin) {
      $instance = $this->createInstance($plugin_id);

      if ($instance instanceof PlatformInterface) {
        $plugins[$plugin_id]['instance'] = $instance;
      }
    }

    return $plugins;
  }
}
