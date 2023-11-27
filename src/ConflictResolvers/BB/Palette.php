<?php
namespace Cvy\WP\BBAstrCompat\ConflictResolvers\BB;

if (!defined('ABSPATH')) exit;

class Palette extends \Cvy\WP\BBAstrCompat\ConflictResolvers\ConflictResolver
{
  protected function __construct()
  {
    $this->pull_astra_colors();
  }

  private function pull_astra_colors() : void
  {
    add_filter( 'fl_builder_color_presets', function( array $colors ) : array
    {
      $astra_palettes_data = astra_get_palette_colors();

      $astra_cur_pallette_key = $astra_palettes_data['currentPalette'];

      foreach ( $astra_palettes_data['palettes'][ $astra_cur_pallette_key ] as $color )
      {
        if ( ! in_array( $color, $colors ) )
        {
          $colors[] = $color;
        }
      }

      return $colors;
    });
  }
}