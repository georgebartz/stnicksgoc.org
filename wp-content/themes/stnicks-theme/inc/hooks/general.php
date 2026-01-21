<?php
/**
 * General hooks.
 *
 * @package air-light
 */

namespace Air_Light;

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function widgets_init() {
  register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'air-light' ),
    'id'            => 'sidebar-1',
    'description'   => esc_html__( 'Add widgets here.', 'air-light' ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );
} // end widgets_init

/**
 * Enable WebP and SVG upload support
 *
 * @param array $mimes Existing MIME types.
 * @return array Modified MIME types.
 */
function enable_webp_svg_upload( $mimes ) {
  // Add WebP support
  $mimes['webp'] = 'image/webp';

  // Add SVG support
  $mimes['svg'] = 'image/svg+xml';
  $mimes['svgz'] = 'image/svg+xml';

  return $mimes;
} // end enable_webp_svg_upload

/**
 * Fix SVG file validation for upload
 *
 * @param array  $data File data.
 * @param string $file File path.
 * @param string $filename File name.
 * @param array  $mimes Allowed MIME types.
 * @return array Modified file data.
 */
function fix_svg_mime_type( $data, $file, $filename, $mimes ) {
  $filetype = wp_check_filetype( $filename, $mimes );

  if ( 'svg' === $filetype['ext'] ) {
    $data['ext']  = 'svg';
    $data['type'] = 'image/svg+xml';
  }

  return $data;
} // end fix_svg_mime_type

/**
 * Enable SVG display in media library
 *
 * @param array $response Image data.
 * @return array Modified image data.
 */
function enable_svg_media_library_display( $response ) {
  if ( $response['mime'] === 'image/svg+xml' && empty( $response['sizes'] ) ) {
    $svg_path = get_attached_file( $response['id'] );

    if ( file_exists( $svg_path ) ) {
      $dimensions = @getimagesize( $svg_path );
      if ( $dimensions ) {
        $response['sizes'] = array(
          'full' => array(
            'url'         => $response['url'],
            'width'       => $dimensions[0],
            'height'      => $dimensions[1],
            'orientation' => $dimensions[0] > $dimensions[1] ? 'landscape' : 'portrait',
          ),
        );
      }
    }
  }

  return $response;
} // end enable_svg_media_library_display
