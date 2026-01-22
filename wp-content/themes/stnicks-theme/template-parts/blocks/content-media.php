<?php
/**
 * Block: Content + Media
 *
 * @package air-light
 * @var array $block The block settings and attributes.
 */

namespace Air_Light;

// Get block fields
$orientation = get_field( 'orientation' ) ?: 'left';
$heading = get_field( 'heading' );
$content = get_field( 'content' );
$media_type = get_field( 'media_type' ) ?: 'image';
$image = get_field( 'image' );
$video = get_field( 'video' );
$embed = get_field( 'embed' );
$aspect_ratio = get_field( 'aspect_ratio' ) ?: '4-3';
$ctas = get_field( 'ctas' );

// Get button colors from options
$button_colors = function_exists( __NAMESPACE__ . '\get_button_colors' )
  ? get_button_colors()
  : [];

// Build block classes
$block_classes = [
  'block',
  'block-content-media',
  'has-orientation-' . esc_attr( $orientation ),
  'has-media-' . esc_attr( $media_type ),
  'has-ratio-' . esc_attr( $aspect_ratio ),
];

// Add custom block classes if set
if ( ! empty( $block['className'] ) ) {
  $block_classes[] = $block['className'];
}

// Add anchor ID if set
$anchor_id = ! empty( $block['anchor'] ) ? 'id="' . esc_attr( $block['anchor'] ) . '"' : '';
?>

<section <?php echo $anchor_id; ?> class="<?php echo esc_attr( implode( ' ', $block_classes ) ); ?>">
  <div class="block-content-media__container">
    <div class="block-content-media__inner">

      <!-- Media Column -->
      <div class="block-content-media__media">
        <div class="block-content-media__media-wrapper">
          <?php if ( $media_type === 'image' && ! empty( $image ) ) : ?>
            <?php
            echo wp_get_attachment_image(
              $image['ID'],
              'large',
              false,
              [
                'class' => 'block-content-media__image',
                'alt'   => $image['alt'] ?: $heading,
              ]
            );
            ?>
          <?php elseif ( $media_type === 'video' && ! empty( $video ) ) : ?>
            <video
              class="block-content-media__video"
              controls
              <?php if ( ! empty( $image['url'] ) ) : ?>
                poster="<?php echo esc_url( $image['url'] ); ?>"
              <?php endif; ?>
            >
              <source src="<?php echo esc_url( $video['url'] ); ?>" type="<?php echo esc_attr( $video['mime_type'] ); ?>">
              <?php esc_html_e( 'Your browser does not support the video tag.', 'air-light' ); ?>
            </video>
          <?php elseif ( $media_type === 'embed' && ! empty( $embed ) ) : ?>
            <div class="block-content-media__embed">
              <?php echo wp_oembed_get( $embed ); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Content Column -->
      <div class="block-content-media__content">
        <?php if ( ! empty( $heading ) ) : ?>
          <h2 class="block-content-media__heading"><?php echo esc_html( $heading ); ?></h2>
        <?php endif; ?>

        <?php if ( ! empty( $content ) ) : ?>
          <div class="block-content-media__text">
            <?php echo wp_kses_post( $content ); ?>
          </div>
        <?php endif; ?>

        <?php if ( ! empty( $ctas ) ) : ?>
          <div class="block-content-media__ctas">
            <?php foreach ( $ctas as $cta ) : ?>
              <?php
              $link = $cta['link'];
              $color = $cta['color'] ?: 'primary';
              $size = $cta['size'] ?: 'm';

              if ( empty( $link ) || empty( $link['url'] ) ) {
                continue;
              }

              $url = $link['url'];
              $title = $link['title'] ?: $link['url'];
              $target = ! empty( $link['target'] ) ? $link['target'] : '_self';

              // Get the color value from button colors
              $color_value = '';
              foreach ( $button_colors as $button_color ) {
                if ( $button_color['slug'] === $color ) {
                  $color_value = $button_color['value'];
                  break;
                }
              }

              // Inline style for custom color
              $inline_style = ! empty( $color_value ) ? 'style="--button-color: ' . esc_attr( $color_value ) . ';"' : '';
              ?>
              <a
                href="<?php echo esc_url( $url ); ?>"
                class="block-content-media__cta is-color-<?php echo esc_attr( $color ); ?> is-size-<?php echo esc_attr( $size ); ?>"
                <?php echo $inline_style; ?>
                <?php if ( $target === '_blank' ) : ?>
                  target="_blank" rel="noopener noreferrer"
                <?php endif; ?>
              >
                <?php echo esc_html( $title ); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>
