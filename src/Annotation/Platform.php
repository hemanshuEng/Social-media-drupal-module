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
   * @var string
   */
   public $id;
  /**
   * @var string
   */
   public $name;
   /**
    * @var string
    */
   public $urlPrefix;
   /**
    * @var string
    */
   public $urlSuffix;
}
