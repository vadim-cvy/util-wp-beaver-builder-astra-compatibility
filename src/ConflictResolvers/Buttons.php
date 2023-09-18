<?php
namespace Cvy\WP\BBAstrCompat\ConflictResolvers;

if (!defined('ABSPATH')) exit;

class Buttons extends ConflictResolver
{
  protected function __construct()
  {
    add_filter( 'fl_builder_render_css', [ $this, '_remove_bb_buttons_default_css' ] );

    add_filter( 'fl_builder_render_module_content', [ $this, '_add_bb_buttons_astra_class' ], 10, 2 );

    add_action( 'wp_print_styles', [ $this, '_remove_bb_button_links_underline' ] );
  }

  public function _remove_bb_buttons_default_css( string $css ) : string
  {
    $rules_selectors = [
      [
        '.fl-builder-content a.fl-button',
        '.fl-builder-content a.fl-button:visited',
      ],
      [
        '.fl-builder-content .fl-button:active',
      ],
      [
        '.fl-builder-content a.fl-button *',
        '.fl-builder-content a.fl-button:visited *',
      ],
    ];

    $rules_patterns = [];

    foreach ( $rules_selectors as $rule_selectors )
    {
      $rule_selectors = array_map(
        fn( $selector ) => preg_quote( $selector ),
        $rule_selectors
      );

      $selectors_pattern = implode( ',\s+', $rule_selectors );

      $rules_patterns[] = "~([}/]\s*)$selectors_pattern\s*{[^}]+}~";
    }

    $css = preg_replace( $rules_patterns, '$1', $css );

    return $css;
  }

  public function _add_bb_buttons_astra_class( string $html, object $module ) : string
  {
    $html = preg_replace( '~(["\s]fl-button)(["\s])~', '$1 ast-button$2', $html );

    return $html;
  }

  public function _remove_bb_button_links_underline() : void
  {
    echo '<style>
      a.fl-button
      {
        text-decoration: unset !important;
      }
    </style>';
  }
}