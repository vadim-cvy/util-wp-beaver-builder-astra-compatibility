<?php
namespace Cvy\WP\BBAstrCompat\Util;

if (!defined('ABSPATH')) exit;

class BB
{
  static public function get_global_settings() : \stdClass
  {
    return (object) get_option( '_fl_builder_settings', [] );
  }
}