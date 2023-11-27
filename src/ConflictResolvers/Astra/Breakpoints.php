<?php
namespace Cvy\WP\BBAstrCompat\ConflictResolvers\Astra;

use \Cvy\WP\BBAstrCompat\Util\BB;

if (!defined('ABSPATH')) exit;

class Breakpoints extends \Cvy\WP\BBAstrCompat\ConflictResolvers\ConflictResolver
{
  protected function __construct()
  {
    add_filter( 'astra_tablet_breakpoint', fn() => $this->get_tablet_breakpoint() );
    add_filter( 'astra_mobile_breakpoint', fn() => $this->get_mobile_breakpoint() );
  }

  static public function get_tablet_breakpoint() : int
  {
    return BB::get_global_settings()->large_breakpoint;
  }

  static public function get_mobile_breakpoint() : int
  {
    return BB::get_global_settings()->responsive_breakpoint;
  }
}