<?php
namespace Cvy\WP\BBAstrCompat\ConflictResolvers;

use \Cvy\WP\BBAstrCompat\Util\BB;

if (!defined('ABSPATH')) exit;

class Responsiveness extends ConflictResolver
{
  protected function __construct()
  {
    add_filter( 'astra_tablet_breakpoint', fn() => $this->get_breakpoint_by_astra_screen_size( 'tablet' ) );
    add_filter( 'astra_mobile_breakpoint', fn() => $this->get_breakpoint_by_astra_screen_size( 'mobile' ) );
  }

  static public function get_breakpoint_by_bb_screen_size( string $screen_size ) : int
  {
    return (int) BB::get_global_settings()->{$screen_size . '_breakpoint'};
  }

  static public function get_breakpoint_by_astra_screen_size( string $screen_size ) : int
  {
    $bb_screen_size = [
      'extra_large' => 'desktop',
      'tablet' => 'medium',
      'mobile' => 'responsive',
    ][ $screen_size ];

    return static::get_breakpoint_by_bb_screen_size( $bb_screen_size );
  }
}