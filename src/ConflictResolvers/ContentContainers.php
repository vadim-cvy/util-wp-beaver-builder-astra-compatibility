<?php
namespace Cvy\WP\BBAstrCompat\ConflictResolvers;

use \Cvy\WP\BBAstrCompat\Util\BB;

if (!defined('ABSPATH')) exit;

class ContentContainers extends CssConflictResolver
{
  protected function print_all() : void
  {
    $this->print_max_width();

    $this->print_spacing();
  }

  protected function print_max_width() : void
  {
    $max_width =
      BB::get_global_settings()->row_width .
      BB::get_global_settings()->row_width_unit;

    $this->echo(
      ".ast-container,
      .ast-builder-footer-grid-columns
      {
        max-width: $max_width !important;
      }

      .ast-page-builder-template .site-content > .ast-container
      {
        max-width: 100% !important;
      }"
    );
  }

  protected function print_spacing() : void
  {
    foreach ( BB::get_screen_sizes() as $i => $screen_size )
    {
      $spacing = $this->get_bb_spacing_totals()[ $screen_size ];

      $space_top = $spacing['top'] . 'px';
      $space_right = $spacing['right'] . 'px';
      $space_bottom = $spacing['bottom'] . 'px';
      $space_left = $spacing['left'] . 'px';

      $breakpoint =
        $i !== 0 ?
        Responsiveness::get_breakpoint_by_bb_screen_size( $screen_size ) :
        0;

      $this->echo(
        ".ast-container,
        .ast-builder-footer-grid-columns
        {
          padding-left: $space_left !important;
          padding-right: $space_right !important;
        }

        .entry-content
        {
          padding-top: $space_top;
          padding-bottom: $space_bottom;
        }

        .fl-builder-content
        {
          margin: -$space_top -$space_right -$space_bottom -$space_left;
        }",
        $breakpoint
      );
    }
  }

  protected function get_bb_spacing_totals() : array
  {
    $spacing = [];

    foreach ( BB::get_screen_sizes() as $screen_size )
    {
      $spacing[ $screen_size ] = [];

      foreach ( [ 'top', 'right', 'bottom', 'left' ] as $side )
      {
        $spacing[ $screen_size ][ $side ] = $this->get_bb_spacing_totals_raw( $side, $screen_size );
      }
    }

    return $spacing;
  }

  protected function get_bb_spacing_totals_raw( string $side, string $screen_size ) : int
  {
    $value = 0;

    foreach ( [ 'row', 'column', 'module' ] as $node_type )
    {
      $spacing_types = [ 'margin' ];

      if ( $node_type !== 'module' )
      {
        $spacing_types[] = 'padding';
      }

      foreach ( $spacing_types as $spacing_type )
      {
        $value += $this->get_bb_node_spacing_raw( $node_type, $spacing_type, $side, $screen_size );
      }
    }

    return $value;
  }

  protected function get_bb_node_spacing_raw(
    string $node_type,
    string $spacing_type,
    string $side,
    string $screen_size
  ) : int
  {
    $bb_spacing_type = $spacing_type === 'margin' ? 'margins' : $spacing_type;

    $bb_screen_size = $screen_size !== 'extra_large' ? $screen_size : '';

    $unit_setting_key =
      $this->get_bb_spacing_setting_key__unit( $node_type, $bb_spacing_type, $bb_screen_size );

    $value_setting_key =
      $this->get_bb_spacing_setting_key__value( $node_type, $bb_spacing_type, $side, $bb_screen_size );

    if ( BB::get_global_settings()->$unit_setting_key !== 'px' )
    {
      // todo: if "em" passed - use root font size to convert em to px
      throw new \Exception( 'Unexpected unit!' );
    }

    $value = (int) BB::get_global_settings()->$value_setting_key;

    if ( $value )
    {
      return $value;
    }

    // BB does not inherit rows side paddings for small screen
    $should_inherit_prev_screen = ! (
      $screen_size === 'responsive' &&
      $node_type === 'row' &&
      $spacing_type === 'padding' &&
      in_array( $side, [ 'left', 'right' ] )
    );

    if ( ! $should_inherit_prev_screen )
    {
      return $value;
    }

    $screen_size_index = array_search( $screen_size, BB::get_screen_sizes() );

    if ( $screen_size_index === 0 )
    {
      return $value;
    }

    $prev_screen_size = BB::get_screen_sizes()[ $screen_size_index - 1 ];

    return $this->get_bb_node_spacing_raw( $node_type, $spacing_type, $side, $prev_screen_size );
  }

  protected function get_bb_spacing_setting_key__unit(
    string $node_type,
    string $bb_spacing_type,
    string $bb_screen_size
  ) : string
  {
    $setting_key = $node_type . '_' . $bb_spacing_type;

    if ( $bb_screen_size )
    {
      $setting_key .= '_' . $bb_screen_size;
    }

    $setting_key .= '_unit';

    return $setting_key;
  }

  protected function get_bb_spacing_setting_key__value(
    string $node_type,
    string $bb_spacing_type,
    string $side,
    string $bb_screen_size
  ) : string
  {
    $setting_key = $node_type . '_' . $bb_spacing_type . '_' . $side;

    if ( $bb_screen_size )
    {
      $setting_key .= '_' . $bb_screen_size;
    }

    return $setting_key;
  }
}