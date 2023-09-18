<?php
namespace Cvy\WP\BBAstrCompat\Util;

if (!defined('ABSPATH')) exit;

class BB
{
  static public function get_global_settings() : \stdClass
  {
    return get_option( '_fl_builder_settings' );
  }

  static public function get_screen_sizes() : array
  {
    return [
      'extra_large',
      'large',
      'medium',
      'responsive',
    ];
  }
}