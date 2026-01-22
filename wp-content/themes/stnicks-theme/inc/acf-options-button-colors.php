<?php
/**
 * ACF Options Page: Button Colors
 *
 * @package air-light
 */

namespace Air_Light;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Register ACF Options Page for Button Colors
 */
add_action( 'acf/init', function() {
  if ( ! function_exists( 'acf_add_options_page' ) ) {
    return;
  }

  acf_add_options_page( [
    'page_title'  => 'Button Colors',
    'menu_title'  => 'Button Colors',
    'menu_slug'   => 'button-colors',
    'capability'  => 'edit_theme_options',
    'parent_slug' => 'themes.php',
    'position'    => 61,
    'icon_url'    => 'dashicons-admin-appearance',
  ] );
} );

/**
 * Register Button Colors Field Group
 */
add_action( 'acf/init', function() {
  if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
  }

  acf_add_local_field_group( [
    'key'                   => 'group_button_colors',
    'title'                 => 'Button Color Settings',
    'fields'                => [
      [
        'key'               => 'field_button_colors_info',
        'label'             => 'Color Management',
        'name'              => '',
        'type'              => 'message',
        'message'           => 'Define custom button colors that can be used throughout the site. Each color requires a label (for editors) and a hex/rgb color value.',
        'new_lines'         => 'wpautop',
        'esc_html'          => 0,
      ],
      [
        'key'               => 'field_button_colors',
        'label'             => 'Button Colors',
        'name'              => 'button_colors',
        'type'              => 'repeater',
        'instructions'      => 'Add custom colors for buttons. Each color will be available in the button color selector.',
        'required'          => 0,
        'min'               => 0,
        'max'               => 10,
        'layout'            => 'table',
        'button_label'      => 'Add Color',
        'sub_fields'        => [
          [
            'key'           => 'field_button_color_label',
            'label'         => 'Label',
            'name'          => 'label',
            'type'          => 'text',
            'instructions'  => 'Display name (e.g., "Primary Blue", "Accent Red")',
            'required'      => 1,
            'placeholder'   => 'Primary Blue',
            'wrapper'       => [
              'width'       => '40',
            ],
          ],
          [
            'key'           => 'field_button_color_value',
            'label'         => 'Color',
            'name'          => 'value',
            'type'          => 'color_picker',
            'instructions'  => 'Select the color',
            'required'      => 1,
            'default_value' => '#0066cc',
            'enable_opacity' => 0,
            'return_format' => 'string',
            'wrapper'       => [
              'width'       => '30',
            ],
          ],
          [
            'key'           => 'field_button_color_slug',
            'label'         => 'Slug',
            'name'          => 'slug',
            'type'          => 'text',
            'instructions'  => 'CSS-friendly identifier (lowercase, hyphens only)',
            'required'      => 1,
            'placeholder'   => 'primary-blue',
            'wrapper'       => [
              'width'       => '30',
            ],
          ],
        ],
      ],
    ],
    'location'              => [
      [
        [
          'param'           => 'options_page',
          'operator'        => '==',
          'value'           => 'button-colors',
        ],
      ],
    ],
    'menu_order'            => 0,
    'position'              => 'normal',
    'style'                 => 'default',
    'label_placement'       => 'top',
    'instruction_placement' => 'label',
    'active'                => true,
  ] );
} );

/**
 * Helper function to get button colors
 *
 * @return array Array of button colors with label, value, and slug
 */
function get_button_colors() {
  $colors = get_field( 'button_colors', 'option' );

  // Default colors if none are set
  if ( empty( $colors ) ) {
    return [
      [
        'label' => 'Primary',
        'value' => '#0066cc',
        'slug'  => 'primary',
      ],
      [
        'label' => 'Secondary',
        'value' => '#6c757d',
        'slug'  => 'secondary',
      ],
    ];
  }

  return $colors;
}

/**
 * Generate choices array for ACF select field
 *
 * @return array Associative array of slug => label for ACF choices
 */
function get_button_color_choices() {
  $colors = get_button_colors();
  $choices = [];

  foreach ( $colors as $color ) {
    if ( ! empty( $color['slug'] ) && ! empty( $color['label'] ) ) {
      $choices[ $color['slug'] ] = $color['label'];
    }
  }

  return $choices;
}
