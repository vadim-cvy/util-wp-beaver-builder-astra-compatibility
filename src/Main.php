<?php
namespace Cvy\WP\BBAstrCompat;

use \Cvy\WP\BBAstrCompat\ConflictResolvers\{
  Responsiveness,
  Buttons,
  ContentContainers,
  Typography,
};

if (!defined('ABSPATH')) exit;

class Main extends \Cvy\DesignPatterns\Singleton
{
  protected function __construct()
  {
    Responsiveness::get_instance();
    Buttons::get_instance();
    ContentContainers::get_instance();
    Typography::get_instance();
  }
}
