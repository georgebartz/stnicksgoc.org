<?php
/**
 * Block: Hero Section
 *
 * @package air-light
 * @var array $block The block settings and attributes.
 */

namespace Air_Light;

// Get block fields
$heading = get_field( 'heading' );
$subheading = get_field( 'subheading' );
$description = get_field( 'description' );
$alignment = get_field( 'alignment' ) ?: 'left';
$show_breadcrumbs = get_field( 'show_breadcrumbs' );
$background_type = get_field( 'background_type' ) ?: 'image';
$background_image = get_field( 'background_image' );
$background_video = get_field( 'background_video' );
$video_poster = get_field( 'video_poster' );
$overlay_opacity = get_field( 'overlay_opacity' );
$buttons = get_field( 'buttons' );
$min_height = get_field( 'min_height' ) ?: 'large';

// Set overlay opacity (convert 0-100 to 0-1)
$overlay_value = $overlay_opacity ? ( $overlay_opacity / 100 ) : 0.5;

// Build block classes
$block_classes = [
  'block',
  'block-hero',
  'has-alignment-' . esc_attr( $alignment ),
  'has-height-' . esc_attr( $min_height ),
];

if ( $background_type === 'video' ) {
  $block_classes[] = 'has-video-background';
}

if ( $show_breadcrumbs ) {
  $block_classes[] = 'has-breadcrumbs';
}

// Add custom block classes if set
if ( ! empty( $block['className'] ) ) {
  $block_classes[] = $block['className'];
}

// Add anchor ID if set
$anchor_id = ! empty( $block['anchor'] ) ? 'id="' . esc_attr( $block['anchor'] ) . '"' : '';
?>

<section <?php echo esc_attr( $anchor_id ); ?> class="<?php echo esc_attr( implode( ' ', $block_classes ) ); ?>">
  <div class="block-hero__background">
    <?php if ( $background_type === 'video' && ! empty( $background_video ) ) : ?>
      <video
        class="block-hero__video"
        autoplay
        muted
        loop
        playsinline
        <?php if ( ! empty( $video_poster['url'] ) ) : ?>
          poster="<?php echo esc_url( $video_poster['url'] ); ?>"
        <?php endif; ?>
      >
        <source src="<?php echo esc_url( $background_video['url'] ); ?>" type="<?php echo esc_attr( $background_video['mime_type'] ); ?>">
        <?php if ( ! empty( $video_poster ) ) : ?>
          <img src="<?php echo esc_url( $video_poster['url'] ); ?>" alt="<?php echo esc_attr( $video_poster['alt'] ?: $heading ); ?>">
        <?php endif; ?>
      </video>
    <?php elseif ( $background_type === 'image' && ! empty( $background_image ) ) : ?>
      <?php
      echo wp_get_attachment_image(
        $background_image['ID'],
        'full',
        false,
        [
          'class' => 'block-hero__image',
          'alt'   => $background_image['alt'] ?: $heading,
        ]
      );
      ?>
    <?php endif; ?>

    <?php if ( $overlay_opacity > 0 ) : ?>
      <div class="block-hero__overlay" style="opacity: <?php echo esc_attr( $overlay_value ); ?>;"></div>
    <?php endif; ?>
  </div>

  <div class="block-hero__container">
    <div class="block-hero__content">
      <?php if ( $show_breadcrumbs ) : ?>
        <nav class="block-hero__breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumbs', 'air-light' ); ?>">
          <?php
          // You can customize the breadcrumbs output here
          // This is a simple example - you may want to use Yoast SEO breadcrumbs or another plugin
          if ( function_exists( 'yoast_breadcrumb' ) ) {
            yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
          } else {
            // Fallback breadcrumbs
            echo '<div class="breadcrumbs">';
            echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'air-light' ) . '</a>';
            echo ' <span class="separator">/</span> ';
            echo '<span class="current">' . esc_html( get_the_title() ) . '</span>';
            echo '</div>';
          }
          ?>
        </nav>
      <?php endif; ?>

      <?php if ( ! empty( $subheading ) ) : ?>
        <p class="block-hero__subheading"><?php echo esc_html( $subheading ); ?></p>
      <?php endif; ?>

      <?php if ( ! empty( $heading ) ) : ?>
        <h1 class="block-hero__heading"><?php echo esc_html( $heading ); ?></h1>
      <?php endif; ?>

      <?php if ( ! empty( $description ) ) : ?>
        <div class="block-hero__description">
          <p><?php echo wp_kses_post( nl2br( $description ) ); ?></p>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $buttons ) ) : ?>
        <div class="block-hero__buttons">
          <?php foreach ( $buttons as $button ) : ?>
            <?php
            $button_link = $button['link'];
            $button_text = $button['text'];
            $button_style = $button['style'] ?: 'primary';

            if ( empty( $button_link ) || empty( $button_text ) ) {
              continue;
            }

            $button_url = is_array( $button_link ) ? $button_link['url'] : $button_link;
            $button_target = ! empty( $button_link['target'] ) ? $button_link['target'] : '_self';
            ?>
            <a
              href="<?php echo esc_url( $button_url ); ?>"
              class="block-hero__button is-style-<?php echo esc_attr( $button_style ); ?>"
              <?php if ( $button_target === '_blank' ) : ?>
                target="_blank" rel="noopener noreferrer"
              <?php endif; ?>
            >
              <?php echo esc_html( $button_text ); ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
