<?php
namespace Cvy\WP\BBAstrCompat;
use Cvy\WP\BBAstrCompat\Util\BB;

if (!defined('ABSPATH')) exit;

class Main extends \Cvy\DesignPatterns\Singleton
{
  protected function __construct()
  {
    if ( empty( BB::get_global_settings() ) )
    {
      trigger_error(sprintf(
        '%s will be able to do its job only after you go to BB global settings and click "Save" button.',
        get_called_class(),
      ));

      return;
    }

    \Cvy\WP\BBAstrCompat\ConflictResolvers\BB\Buttons::get_instance();
    \Cvy\WP\BBAstrCompat\ConflictResolvers\BB\Typography::get_instance();

    \Cvy\WP\BBAstrCompat\ConflictResolvers\Astra\Breakpoints::get_instance();
    \Cvy\WP\BBAstrCompat\ConflictResolvers\Astra\Typography::get_instance();
  }
}
