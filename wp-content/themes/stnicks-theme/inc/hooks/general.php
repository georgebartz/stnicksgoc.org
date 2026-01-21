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

/**
 * Convert image to WebP format
 *
 * @param string $file_path Path to the image file.
 * @param int    $quality WebP quality (0-100).
 * @return string|false Path to WebP file or false on failure.
 */
function convert_image_to_webp( $file_path, $quality = 90 ) {
  if ( ! file_exists( $file_path ) ) {
    return false;
  }

  // Check if GD library supports WebP
  if ( ! function_exists( 'imagewebp' ) ) {
    return false;
  }

  $file_info = pathinfo( $file_path );
  $extension = strtolower( $file_info['extension'] );

  // Only convert jpg, jpeg, png, and gif
  if ( ! in_array( $extension, array( 'jpg', 'jpeg', 'png', 'gif' ), true ) ) {
    return false;
  }

  // Create image resource from source file
  $image = false;
  switch ( $extension ) {
    case 'jpg':
    case 'jpeg':
      $image = @imagecreatefromjpeg( $file_path );
      break;
    case 'png':
      $image = @imagecreatefrompng( $file_path );
      // Preserve PNG transparency
      if ( $image ) {
        imagepalettetotruecolor( $image );
        imagealphablending( $image, true );
        imagesavealpha( $image, true );
      }
      break;
    case 'gif':
      $image = @imagecreatefromgif( $file_path );
      break;
  }

  if ( ! $image ) {
    return false;
  }

  // Generate WebP filename
  $webp_path = $file_info['dirname'] . '/' . $file_info['filename'] . '.webp';

  // Convert to WebP
  $result = imagewebp( $image, $webp_path, $quality );
  imagedestroy( $image );

  return $result ? $webp_path : false;
} // end convert_image_to_webp

/**
 * Generate WebP versions of uploaded images
 *
 * @param array $metadata Image metadata.
 * @param int   $attachment_id Attachment ID.
 * @return array Modified metadata.
 */
function generate_webp_on_upload( $metadata, $attachment_id ) {
  if ( ! isset( $metadata['file'] ) ) {
    return $metadata;
  }

  $upload_dir = wp_upload_dir();
  $file_path = $upload_dir['basedir'] . '/' . $metadata['file'];

  // Check if this is an image we want to convert
  $mime_type = get_post_mime_type( $attachment_id );
  $convertible_types = array( 'image/jpeg', 'image/png', 'image/gif' );

  if ( ! in_array( $mime_type, $convertible_types, true ) ) {
    return $metadata;
  }

  // Convert main image to WebP
  convert_image_to_webp( $file_path );

  // Convert all image sizes to WebP
  if ( isset( $metadata['sizes'] ) && is_array( $metadata['sizes'] ) ) {
    foreach ( $metadata['sizes'] as $size => $size_data ) {
      $size_file_path = $upload_dir['basedir'] . '/' . dirname( $metadata['file'] ) . '/' . $size_data['file'];
      convert_image_to_webp( $size_file_path );
    }
  }

  return $metadata;
} // end generate_webp_on_upload

/**
 * Serve WebP images on the front-end if available
 *
 * @param array|false  $image Image data or false.
 * @param int          $attachment_id Attachment ID.
 * @param string|array $size Image size.
 * @param bool         $icon Whether to get an icon.
 * @return array|false Modified image data or false.
 */
function serve_webp_images( $image, $attachment_id, $size, $icon ) {
  if ( ! $image ) {
    return $image;
  }

  // Check if browser supports WebP
  $accepts_webp = false;
  if ( isset( $_SERVER['HTTP_ACCEPT'] ) && strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {
    $accepts_webp = true;
  }

  if ( ! $accepts_webp ) {
    return $image;
  }

  // Get the original image path
  $image_url = $image[0];
  $image_path = str_replace( wp_upload_dir()['baseurl'], wp_upload_dir()['basedir'], $image_url );

  // Generate WebP path
  $webp_path = preg_replace( '/\.(jpe?g|png|gif)$/i', '.webp', $image_path );
  $webp_url = preg_replace( '/\.(jpe?g|png|gif)$/i', '.webp', $image_url );

  // Check if WebP version exists
  if ( file_exists( $webp_path ) ) {
    $image[0] = $webp_url;
  }

  return $image;
} // end serve_webp_images
