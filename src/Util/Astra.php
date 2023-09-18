<?php
namespace Cvy\WP\BBAstrCompat\Util;

if (!defined('ABSPATH')) exit;

class Astra
{
  static public function get_settings() : array
  {
    return get_option( 'astra-settings' );
  }

  static public function get_screen_sizes() : array
  {
    return [
      'desktop',
      'tablet',
      'mobile',
    ];
  }
}