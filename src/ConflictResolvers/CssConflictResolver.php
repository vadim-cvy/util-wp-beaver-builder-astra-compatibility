<?php
namespace Cvy\WP\BBAstrCompat\ConflictResolvers;

if (!defined('ABSPATH')) exit;

abstract class CssConflictResolver extends ConflictResolver
{
  protected function __construct()
  {
    add_filter( 'wp_print_styles',
      fn() => printf( '<style>' . $this->get_minified_css() . '</style>' )
    );
  }

  private function get_minified_css() : string
  {
    return preg_replace( '~\s+~', ' ', $this->get_css() );
  }

  abstract protected function get_css() : string;
}
