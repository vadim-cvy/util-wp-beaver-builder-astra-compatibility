<?php
namespace Cvy\WP\BBAstrCompat\ConflictResolvers\BB;

if (!defined('ABSPATH')) exit;

class Buttons extends \Cvy\WP\BBAstrCompat\ConflictResolvers\ConflictResolver
{
  protected function __construct()
  {
    $this->prevent_bb_buttons_default_css();

    $this->add_bb_buttons_astra_class();

    $this->remove_bb_button_links_underline();
  }

  private function prevent_bb_buttons_default_css() : void
  {
    add_filter( 'fl_builder_render_css', function( string $css ) : string
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
    });
  }

  private function add_bb_buttons_astra_class() : void
  {
    add_filter(
      'fl_builder_render_module_content',
      fn( $html ) => preg_replace( '~(["\s]fl-button)(["\s])~', '$1 ast-button$2', $html )
    );
  }

  private function remove_bb_button_links_underline() : void
  {
    add_action( 'wp_print_styles', fn() => printf(
      '<style>
        a.fl-button
        {
          text-decoration: unset !important;
        }
      </style>'
    ));
  }
}