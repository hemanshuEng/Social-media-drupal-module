<?php
declare(strict_types=1);

namespace Drupal\champions_social\SocialMedia;
use Drupal\Component\Plugin\PluginInspectionInterface;

interface PlatformInterface extends PluginInspectionInterface
{
   public function  getId();
   public function  getName();
   public function  getUrlSuffix();
   public function  getUrlPrefix();
}
