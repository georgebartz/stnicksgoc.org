<?php
/**
 * ACF Field Group: Content + Media
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

  // Get button color choices dynamically
  $button_color_choices = function_exists( __NAMESPACE__ . '\get_button_color_choices' )
    ? get_button_color_choices()
    : [
      'primary'   => 'Primary',
      'secondary' => 'Secondary',
    ];

  acf_add_local_field_group( [
    'key'                   => 'group_content_media',
    'title'                 => 'Content + Media Settings',
    'fields'                => [
      // Layout Settings Tab
      [
        'key'               => 'field_content_media_tab_layout',
        'label'             => 'Layout',
        'name'              => '',
        'type'              => 'tab',
        'instructions'      => '',
        'required'          => 0,
        'placement'         => 'top',
      ],
      [
        'key'               => 'field_content_media_orientation',
        'label'             => 'Media Orientation',
        'name'              => 'orientation',
        'type'              => 'button_group',
        'instructions'      => 'Choose where the media appears',
        'required'          => 0,
        'choices'           => [
          'left'            => 'Media Left',
          'right'           => 'Media Right',
        ],
        'default_value'     => 'left',
        'wrapper'           => [
          'width'           => '100',
        ],
      ],

      // Content Tab
      [
        'key'               => 'field_content_media_tab_content',
        'label'             => 'Content',
        'name'              => '',
        'type'              => 'tab',
        'instructions'      => '',
        'required'          => 0,
        'placement'         => 'top',
      ],
      [
        'key'               => 'field_content_media_heading',
        'label'             => 'Heading',
        'name'              => 'heading',
        'type'              => 'text',
        'instructions'      => 'Main heading for this section',
        'required'          => 0,
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
      [
        'key'               => 'field_content_media_content',
        'label'             => 'Content',
        'name'              => 'content',
        'type'              => 'wysiwyg',
        'instructions'      => 'Rich text content for this section',
        'required'          => 0,
        'tabs'              => 'all',
        'toolbar'           => 'full',
        'media_upload'      => 0,
        'delay'             => 0,
        'wrapper'           => [
          'width'           => '100',
        ],
      ],

      // Media Tab
      [
        'key'               => 'field_content_media_tab_media',
        'label'             => 'Media',
        'name'              => '',
        'type'              => 'tab',
        'instructions'      => '',
        'required'          => 0,
        'placement'         => 'top',
      ],
      [
        'key'               => 'field_content_media_type',
        'label'             => 'Media Type',
        'name'              => 'media_type',
        'type'              => 'button_group',
        'instructions'      => 'Choose the type of media to display',
        'required'          => 1,
        'choices'           => [
          'image'           => 'Image',
          'video'           => 'Video',
          'embed'           => 'Embed',
        ],
        'default_value'     => 'image',
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
      [
        'key'               => 'field_content_media_image',
        'label'             => 'Image',
        'name'              => 'image',
        'type'              => 'image',
        'instructions'      => 'Upload or select an image',
        'required'          => 0,
        'return_format'     => 'array',
        'preview_size'      => 'medium',
        'library'           => 'all',
        'conditional_logic' => [
          [
            [
              'field'       => 'field_content_media_type',
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
        'key'               => 'field_content_media_video',
        'label'             => 'Video File',
        'name'              => 'video',
        'type'              => 'file',
        'instructions'      => 'Upload a video file (MP4, WebM, or OGG)',
        'required'          => 0,
        'return_format'     => 'array',
        'library'           => 'all',
        'mime_types'        => 'mp4,webm,ogg',
        'conditional_logic' => [
          [
            [
              'field'       => 'field_content_media_type',
              'operator'    => '==',
              'value'       => 'video',
            ],
          ],
        ],
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
      [
        'key'               => 'field_content_media_embed',
        'label'             => 'Embed URL',
        'name'              => 'embed',
        'type'              => 'oembed',
        'instructions'      => 'Paste a URL from YouTube, Vimeo, etc.',
        'required'          => 0,
        'conditional_logic' => [
          [
            [
              'field'       => 'field_content_media_type',
              'operator'    => '==',
              'value'       => 'embed',
            ],
          ],
        ],
        'wrapper'           => [
          'width'           => '100',
        ],
      ],
      [
        'key'               => 'field_content_media_aspect_ratio',
        'label'             => 'Aspect Ratio',
        'name'              => 'aspect_ratio',
        'type'              => 'select',
        'instructions'      => 'Choose the aspect ratio for the media',
        'required'          => 0,
        'choices'           => [
          '1-1'             => '1:1 (Square)',
          '4-3'             => '4:3 (Standard)',
          '16-9'            => '16:9 (Widescreen)',
          '3-2'             => '3:2 (Classic Photo)',
          'auto'            => 'Auto (Original)',
        ],
        'default_value'     => '4-3',
        'wrapper'           => [
          'width'           => '50',
        ],
      ],

      // CTAs Tab
      [
        'key'               => 'field_content_media_tab_ctas',
        'label'             => 'CTAs',
        'name'              => '',
        'type'              => 'tab',
        'instructions'      => '',
        'required'          => 0,
        'placement'         => 'top',
      ],
      [
        'key'               => 'field_content_media_ctas',
        'label'             => 'Call-to-Action Buttons',
        'name'              => 'ctas',
        'type'              => 'repeater',
        'instructions'      => 'Add up to 2 call-to-action buttons',
        'required'          => 0,
        'min'               => 0,
        'max'               => 2,
        'layout'            => 'block',
        'button_label'      => 'Add CTA',
        'sub_fields'        => [
          [
            'key'           => 'field_content_media_cta_link',
            'label'         => 'Link',
            'name'          => 'link',
            'type'          => 'link',
            'instructions'  => 'Set the button text, URL, and target',
            'required'      => 1,
            'return_format' => 'array',
            'wrapper'       => [
              'width'       => '100',
            ],
          ],
          [
            'key'           => 'field_content_media_cta_color',
            'label'         => 'Button Color',
            'name'          => 'color',
            'type'          => 'select',
            'instructions'  => 'Choose button color',
            'required'      => 1,
            'choices'       => $button_color_choices,
            'default_value' => array_key_first( $button_color_choices ),
            'wrapper'       => [
              'width'       => '50',
            ],
          ],
          [
            'key'           => 'field_content_media_cta_size',
            'label'         => 'Button Size',
            'name'          => 'size',
            'type'          => 'select',
            'instructions'  => 'Choose button size',
            'required'      => 1,
            'choices'       => [
              's'           => 'Small',
              'm'           => 'Medium',
              'l'           => 'Large',
            ],
            'default_value' => 'm',
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
          'value'           => 'acf/content-media',
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
