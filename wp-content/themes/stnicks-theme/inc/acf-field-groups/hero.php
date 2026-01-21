<?php
/**
 * ACF Field Group: Hero Section
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
    'key'                   => 'group_hero_section',
    'title'                 => 'Hero Section Settings',
    'fields'                => [
      [
        'key'               => 'field_hero_heading',
        'label'             => 'Heading',
        'name'              => 'heading',
        'type'              => 'text',
        'instructions'      => 'Main hero heading (H1)',
        'required'          => 1,
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
      [
        'key'               => 'field_hero_subheading',
        'label'             => 'Subheading',
        'name'              => 'subheading',
        'type'              => 'text',
        'instructions'      => 'Optional subheading text',
        'required'          => 0,
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
      [
        'key'               => 'field_hero_description',
        'label'             => 'Description',
        'name'              => 'description',
        'type'              => 'textarea',
        'instructions'      => 'Optional description text',
        'required'          => 0,
        'rows'              => 4,
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
      [
        'key'               => 'field_hero_alignment',
        'label'             => 'Content Alignment',
        'name'              => 'alignment',
        'type'              => 'button_group',
        'instructions'      => 'Choose content alignment',
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
        'key'               => 'field_hero_show_breadcrumbs',
        'label'             => 'Show Breadcrumbs',
        'name'              => 'show_breadcrumbs',
        'type'              => 'true_false',
        'instructions'      => 'Display breadcrumbs navigation',
        'required'          => 0,
        'default_value'     => 0,
        'ui'                => 1,
        'wrapper'           => [
          'width'           => '50',
        ],
      ],
      [
        'key'               => 'field_hero_background_type',
        'label'             => 'Background Type',
        'name'              => 'background_type',
        'type'              => 'button_group',
        'instructions'      => 'Choose background type',
        'required'          => 1,
        'choices'           => [
          'image'           => 'Image',
          'video'           => 'Video',
        ],
        'default_value'     => 'image',
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
      [
        'key'               => 'field_hero_background_image',
        'label'             => 'Background Image',
        'name'              => 'background_image',
        'type'              => 'image',
        'instructions'      => 'Select a background image (recommended size: 1920x1080px or larger)',
        'required'          => 0,
        'return_format'     => 'array',
        'preview_size'      => 'medium',
        'library'           => 'all',
        'conditional_logic' => [
          [
            [
              'field'       => 'field_hero_background_type',
              'operator'    => '==',
              'value'       => 'image',
            ],
          ],
        ],
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
      [
        'key'               => 'field_hero_background_video',
        'label'             => 'Background Video',
        'name'              => 'background_video',
        'type'              => 'file',
        'instructions'      => 'Upload a background video (MP4 or WebM format recommended)',
        'required'          => 0,
        'return_format'     => 'array',
        'library'           => 'all',
        'mime_types'        => 'mp4,webm,ogg',
        'conditional_logic' => [
          [
            [
              'field'       => 'field_hero_background_type',
              'operator'    => '==',
              'value'       => 'video',
            ],
          ],
        ],
        'wrapper'           => [
          'width'           => '50',
        ],
      ],
      [
        'key'               => 'field_hero_video_poster',
        'label'             => 'Video Poster Image',
        'name'              => 'video_poster',
        'type'              => 'image',
        'instructions'      => 'Fallback image for video (shown while loading or if video fails)',
        'required'          => 0,
        'return_format'     => 'array',
        'preview_size'      => 'medium',
        'library'           => 'all',
        'conditional_logic' => [
          [
            [
              'field'       => 'field_hero_background_type',
              'operator'    => '==',
              'value'       => 'video',
            ],
          ],
        ],
        'wrapper'           => [
          'width'           => '50',
        ],
      ],
      [
        'key'               => 'field_hero_overlay_opacity',
        'label'             => 'Overlay Opacity',
        'name'              => 'overlay_opacity',
        'type'              => 'range',
        'instructions'      => 'Dark overlay opacity for better text readability (0 = no overlay, 100 = fully dark)',
        'required'          => 0,
        'default_value'     => 50,
        'min'               => 0,
        'max'               => 100,
        'step'              => 5,
        'append'            => '%',
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
      [
        'key'               => 'field_hero_buttons',
        'label'             => 'CTA Buttons',
        'name'              => 'buttons',
        'type'              => 'repeater',
        'instructions'      => 'Add up to 2 call-to-action buttons',
        'required'          => 0,
        'min'               => 0,
        'max'               => 2,
        'layout'            => 'block',
        'button_label'      => 'Add Button',
        'sub_fields'        => [
          [
            'key'           => 'field_hero_button_text',
            'label'         => 'Button Text',
            'name'          => 'text',
            'type'          => 'text',
            'required'      => 1,
            'wrapper'       => [
              'width'       => '50',
            ],
          ],
          [
            'key'           => 'field_hero_button_link',
            'label'         => 'Button Link',
            'name'          => 'link',
            'type'          => 'link',
            'required'      => 1,
            'return_format' => 'array',
            'wrapper'       => [
              'width'       => '50',
            ],
          ],
          [
            'key'           => 'field_hero_button_style',
            'label'         => 'Button Style',
            'name'          => 'style',
            'type'          => 'select',
            'required'      => 1,
            'choices'       => [
              'primary'     => 'Primary (Filled)',
              'secondary'   => 'Secondary (Outlined)',
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
      [
        'key'               => 'field_hero_min_height',
        'label'             => 'Minimum Height',
        'name'              => 'min_height',
        'type'              => 'button_group',
        'instructions'      => 'Choose the minimum height for the hero section',
        'required'          => 0,
        'choices'           => [
          'small'           => 'Small (400px)',
          'medium'          => 'Medium (600px)',
          'large'           => 'Large (800px)',
          'fullscreen'      => 'Full Screen',
        ],
        'default_value'     => 'large',
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
          'value'           => 'acf/hero',
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
