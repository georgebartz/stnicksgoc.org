<?php
/**
 * ACF Field Group: Content Grid
 *
 * @package air-light
 */

namespace Air_Light;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

add_action( 'acf/init', function() {
  if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
  }

  acf_add_local_field_group( [
    'key'                   => 'group_content_grid',
    'title'                 => 'Content Grid Settings',
    'fields'                => [
      [
        'key'               => 'field_content_grid_heading',
        'label'             => 'Section Heading',
        'name'              => 'section_heading',
        'type'              => 'text',
        'instructions'      => 'Optional heading for the content grid section',
        'required'          => 0,
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
      [
        'key'               => 'field_content_grid_description',
        'label'             => 'Section Description',
        'name'              => 'section_description',
        'type'              => 'textarea',
        'instructions'      => 'Optional description for the content grid section',
        'required'          => 0,
        'rows'              => 3,
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
      [
        'key'               => 'field_content_grid_columns',
        'label'             => 'Number of Columns',
        'name'              => 'columns',
        'type'              => 'button_group',
        'instructions'      => 'Choose how many columns to display (responsive on smaller screens)',
        'required'          => 0,
        'choices'           => [
          '1'               => '1 Column',
          '2'               => '2 Columns',
          '3'               => '3 Columns',
          '4'               => '4 Columns',
        ],
        'default_value'     => '3',
        'wrapper'           => [
          'width'           => '50',
        ],
      ],
      [
        'key'               => 'field_content_grid_style',
        'label'             => 'Card Style',
        'name'              => 'card_style',
        'type'              => 'select',
        'instructions'      => 'Choose the visual style for the cards',
        'required'          => 0,
        'choices'           => [
          'basic'           => 'Basic / Plain',
          'card'            => 'Card (with border/shadow)',
          'photo-background' => 'Photo Background',
          'minimal'         => 'Minimal (image + text)',
        ],
        'default_value'     => 'card',
        'wrapper'           => [
          'width'           => '50',
        ],
      ],
      [
        'key'               => 'field_content_grid_gap',
        'label'             => 'Grid Gap',
        'name'              => 'grid_gap',
        'type'              => 'button_group',
        'instructions'      => 'Space between cards',
        'required'          => 0,
        'choices'           => [
          'small'           => 'Small',
          'medium'          => 'Medium',
          'large'           => 'Large',
        ],
        'default_value'     => 'medium',
        'wrapper'           => [
          'width'           => '50',
        ],
      ],
      [
        'key'               => 'field_content_grid_alignment',
        'label'             => 'Content Alignment',
        'name'              => 'content_alignment',
        'type'              => 'button_group',
        'instructions'      => 'Text alignment within cards',
        'required'          => 0,
        'choices'           => [
          'left'            => 'Left',
          'center'          => 'Center',
        ],
        'default_value'     => 'left',
        'wrapper'           => [
          'width'           => '50',
        ],
      ],
      [
        'key'               => 'field_content_grid_cards',
        'label'             => 'Cards',
        'name'              => 'cards',
        'type'              => 'repeater',
        'instructions'      => 'Add cards to the content grid',
        'required'          => 0,
        'min'               => 0,
        'max'               => 0,
        'layout'            => 'block',
        'button_label'      => 'Add Card',
        'sub_fields'        => [
          [
            'key'           => 'field_content_grid_card_image',
            'label'         => 'Image',
            'name'          => 'image',
            'type'          => 'image',
            'instructions'  => 'Card image (recommended size: 800x600px)',
            'required'      => 0,
            'return_format' => 'array',
            'preview_size'  => 'medium',
            'library'       => 'all',
            'wrapper'       => [
              'width'       => '100',
            ],
          ],
          [
            'key'           => 'field_content_grid_card_image_position',
            'label'         => 'Image Position',
            'name'          => 'image_position',
            'type'          => 'select',
            'instructions'  => 'For photo background style',
            'required'      => 0,
            'choices'       => [
              'center'      => 'Center',
              'top'         => 'Top',
              'bottom'      => 'Bottom',
            ],
            'default_value' => 'center',
            'wrapper'       => [
              'width'       => '50',
            ],
          ],
          [
            'key'           => 'field_content_grid_card_overlay_opacity',
            'label'         => 'Image Overlay',
            'name'          => 'overlay_opacity',
            'type'          => 'range',
            'instructions'  => 'Dark overlay for photo background style (0 = no overlay)',
            'required'      => 0,
            'default_value' => 40,
            'min'           => 0,
            'max'           => 100,
            'step'          => 5,
            'append'        => '%',
            'wrapper'       => [
              'width'       => '50',
            ],
          ],
          [
            'key'           => 'field_content_grid_card_subheading',
            'label'         => 'Subheading / Label',
            'name'          => 'subheading',
            'type'          => 'text',
            'instructions'  => 'Small text above the heading (e.g., category, date)',
            'required'      => 0,
            'wrapper'       => [
              'width'       => '100',
            ],
          ],
          [
            'key'           => 'field_content_grid_card_heading',
            'label'         => 'Heading',
            'name'          => 'heading',
            'type'          => 'text',
            'instructions'  => 'Main card heading',
            'required'      => 0,
            'wrapper'       => [
              'width'       => '100',
            ],
          ],
          [
            'key'           => 'field_content_grid_card_description',
            'label'         => 'Description',
            'name'          => 'description',
            'type'          => 'textarea',
            'instructions'  => 'Card description text',
            'required'      => 0,
            'rows'          => 4,
            'wrapper'       => [
              'width'       => '100',
            ],
          ],
          [
            'key'           => 'field_content_grid_card_cta_text',
            'label'         => 'CTA Button Text',
            'name'          => 'cta_text',
            'type'          => 'text',
            'instructions'  => 'Call-to-action button text (leave empty to hide button)',
            'required'      => 0,
            'wrapper'       => [
              'width'       => '50',
            ],
          ],
          [
            'key'           => 'field_content_grid_card_cta_link',
            'label'         => 'CTA Button Link',
            'name'          => 'cta_link',
            'type'          => 'link',
            'instructions'  => 'Button destination URL',
            'required'      => 0,
            'return_format' => 'array',
            'wrapper'       => [
              'width'       => '50',
            ],
          ],
          [
            'key'           => 'field_content_grid_card_cta_style',
            'label'         => 'CTA Button Style',
            'name'          => 'cta_style',
            'type'          => 'select',
            'instructions'  => 'Button appearance',
            'required'      => 0,
            'choices'       => [
              'primary'     => 'Primary (Filled)',
              'secondary'   => 'Secondary (Outlined)',
              'text'        => 'Text Link',
            ],
            'default_value' => 'primary',
            'wrapper'       => [
              'width'       => '50',
            ],
          ],
        ],
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
    ],
    'location'              => [
      [
        [
          'param'           => 'block',
          'operator'        => '==',
          'value'           => 'acf/content-grid',
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
