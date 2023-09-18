<?php
namespace Cvy\WP\BBAstrCompat\ConflictResolvers;

if (!defined('ABSPATH')) exit;

abstract class CssConflictResolver extends ConflictResolver
{
  protected function __construct()
  {
    add_filter( 'wp_print_styles', [ $this, '_print_styles' ] );
  }

  public function _print_styles() : void
  {
    echo '<style>';

    $this->print_all();

    echo '</style>';
  }

  abstract protected function print_all() : void;

  protected function echo( string $css, int $screen_max_width = 0 ) : void
  {
    if ( $screen_max_width )
    {
      $this->echo( "@media screen and (max-width:{$screen_max_width}px) {" );
    }

    echo preg_replace( '~\s+~', ' ', $css );

    if ( $screen_max_width )
    {
      $this->echo( "}" );
    }
  }
}