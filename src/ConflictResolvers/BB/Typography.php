<?php
namespace Cvy\WP\BBAstrCompat\ConflictResolvers\BB;

if (!defined('ABSPATH')) exit;

class Typography extends \Cvy\WP\BBAstrCompat\ConflictResolvers\CssConflictResolver
{
  protected function get_css() : string
  {
    return '.fl-rich-text *{font-size:1em!important;}';
  }
}