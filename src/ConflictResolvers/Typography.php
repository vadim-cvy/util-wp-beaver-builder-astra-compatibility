<?php
namespace Cvy\WP\BBAstrCompat\ConflictResolvers;

use \Cvy\WP\BBAstrCompat\Util\Astra;

if (!defined('ABSPATH')) exit;

class Typography extends CssConflictResolver
{
  protected function print_all() : void
  {
    $h1_settings = Astra::get_settings()['font-size-h1'];

    foreach ( Astra::get_screen_sizes() as $i => $screen_size )
    {
      $breakpoint = $i === 0 ? 0 : Responsiveness::get_breakpoint_by_astra_screen_size( $screen_size );

      $h1_size = $h1_settings[ $screen_size ];

      if ( $h1_size )
      {
        $h1_size .= $h1_settings[ $screen_size . '-unit' ];
      }
      else
      {
        $h1_size = $prev_screen_h1_size;
      }

      $this->echo(
        ".search .ast-archive-description .ast-archive-title
        {
          font-size: $h1_size;
        }",
        $breakpoint
      );

      $prev_screen_h1_size = $h1_size;
    }
  }
}