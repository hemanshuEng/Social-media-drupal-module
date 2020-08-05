<?php

declare(strict_types=1);

namespace Drupal\champions_social\Annotation;

/**
 * Class Platform
 * @package Drupal\champions_social\Annotation
 * @Annotation
 */
class Platform extends \Drupal\Component\Annotation\Plugin
{
  /**
   * id for Platform ( name of platform)
   * @var string
   */
    public $id;
  /**
   * Name of platform
   * It will display on block Form
   * @var string
   */
    public $name;
   /**
    * platform url prefix
    * @var string
    */
    public $urlPrefix;
   /**
    * platform url suffix
    * @var string
    */
    public $urlSuffix;
}
