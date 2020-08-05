<?php

declare(strict_types=1);

namespace Drupal\champions_social\SocialMedia;

use Drupal\Component\Plugin\PluginInspectionInterface;

interface PlatformInterface extends PluginInspectionInterface
{
  /**
   * @return string
   */
    public function getId();

  /**
   * @return string
   */
    public function getName();

  /**
   * @return string
   */
    public function getUrlSuffix();

  /**
   * @return string
   */
    public function getUrlPrefix();
}
