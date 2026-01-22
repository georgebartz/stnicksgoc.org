<?php
/**
 * Block: Content Grid
 *
 * @package air-light
 * @var array $block The block settings and attributes.
 */

namespace Air_Light;

// Get block fields
$section_heading = get_field( 'section_heading' );
$section_description = get_field( 'section_description' );
$columns = get_field( 'columns' ) ?: '3';
$card_style = get_field( 'card_style' ) ?: 'card';
$grid_gap = get_field( 'grid_gap' ) ?: 'medium';
$content_alignment = get_field( 'content_alignment' ) ?: 'left';
$cards = get_field( 'cards' );

// Return early if no cards
if ( empty( $cards ) ) {
  return;
}

// Build block classes
$block_classes = [
  'block',
  'block-content-grid',
  'has-columns-' . esc_attr( $columns ),
  'has-style-' . esc_attr( $card_style ),
  'has-gap-' . esc_attr( $grid_gap ),
  'has-alignment-' . esc_attr( $content_alignment ),
];

// Add custom block classes if set
if ( ! empty( $block['className'] ) ) {
  $block_classes[] = $block['className'];
}

// Add anchor ID if set
$anchor_id = ! empty( $block['anchor'] ) ? 'id="' . esc_attr( $block['anchor'] ) . '"' : '';
?>

<section <?php echo esc_attr( $anchor_id ); ?> class="<?php echo esc_attr( implode( ' ', $block_classes ) ); ?>">
  <div class="block-content-grid__container">
    <?php if ( ! empty( $section_heading ) || ! empty( $section_description ) ) : ?>
      <div class="block-content-grid__header">
        <?php if ( ! empty( $section_heading ) ) : ?>
          <h2 class="block-content-grid__heading"><?php echo esc_html( $section_heading ); ?></h2>
        <?php endif; ?>

        <?php if ( ! empty( $section_description ) ) : ?>
          <div class="block-content-grid__description">
            <p><?php echo wp_kses_post( nl2br( $section_description ) ); ?></p>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="block-content-grid__grid">
      <?php foreach ( $cards as $card ) : ?>
        <?php
        $image = $card['image'];
        $image_position = $card['image_position'] ?: 'center';
        $overlay_opacity = isset( $card['overlay_opacity'] ) ? $card['overlay_opacity'] : 40;
        $subheading = $card['subheading'];
        $heading = $card['heading'];
        $description = $card['description'];
        $cta_text = $card['cta_text'];
        $cta_link = $card['cta_link'];
        $cta_style = $card['cta_style'] ?: 'primary';

        // Skip empty cards
        if ( empty( $image ) && empty( $heading ) && empty( $description ) ) {
          continue;
        }

        // Build card classes
        $card_classes = [ 'block-content-grid__card' ];

        if ( ! empty( $image ) ) {
          $card_classes[] = 'has-image';
        }

        // Convert overlay opacity to decimal
        $overlay_value = $overlay_opacity ? ( $overlay_opacity / 100 ) : 0.4;
        ?>

        <div class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">
          <?php if ( ! empty( $image ) ) : ?>
            <div class="block-content-grid__card-image" style="<?php echo $card_style === 'photo-background' ? 'background-position: ' . esc_attr( $image_position ) . ';' : ''; ?>">
              <?php if ( $card_style === 'photo-background' ) : ?>
                <?php
                // For photo background style, use background image
                $image_url = ! empty( $image['sizes']['large'] ) ? $image['sizes']['large'] : $image['url'];
                ?>
                <div
                  class="block-content-grid__card-image-bg"
                  style="background-image: url('<?php echo esc_url( $image_url ); ?>'); object-position: <?php echo esc_attr( $image_position ); ?>;"
                  role="img"
                  aria-label="<?php echo esc_attr( $image['alt'] ?: $heading ); ?>"
                ></div>
                <?php if ( $overlay_opacity > 0 ) : ?>
                  <div class="block-content-grid__card-overlay" style="opacity: <?php echo esc_attr( $overlay_value ); ?>;"></div>
                <?php endif; ?>
              <?php else : ?>
                <?php
                // For other styles, use img tag
                echo wp_get_attachment_image(
                  $image['ID'],
                  'large',
                  false,
                  [
                    'class' => 'block-content-grid__card-image-el',
                    'alt'   => $image['alt'] ?: $heading,
                  ]
                );
                ?>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <div class="block-content-grid__card-content">
            <?php if ( ! empty( $subheading ) ) : ?>
              <p class="block-content-grid__card-subheading"><?php echo esc_html( $subheading ); ?></p>
            <?php endif; ?>

            <?php if ( ! empty( $heading ) ) : ?>
              <h3 class="block-content-grid__card-heading"><?php echo esc_html( $heading ); ?></h3>
            <?php endif; ?>

            <?php if ( ! empty( $description ) ) : ?>
              <div class="block-content-grid__card-description">
                <p><?php echo wp_kses_post( nl2br( $description ) ); ?></p>
              </div>
            <?php endif; ?>

            <?php if ( ! empty( $cta_text ) && ! empty( $cta_link ) ) : ?>
              <?php
              $button_url = is_array( $cta_link ) ? $cta_link['url'] : $cta_link;
              $button_target = ! empty( $cta_link['target'] ) ? $cta_link['target'] : '_self';
              ?>
              <div class="block-content-grid__card-cta">
                <a
                  href="<?php echo esc_url( $button_url ); ?>"
                  class="block-content-grid__card-button is-style-<?php echo esc_attr( $cta_style ); ?>"
                  <?php if ( $button_target === '_blank' ) : ?>
                    target="_blank" rel="noopener noreferrer"
                  <?php endif; ?>
                >
                  <?php echo esc_html( $cta_text ); ?>
                  <?php if ( $cta_style === 'text' ) : ?>
                    <span class="block-content-grid__card-button-arrow" aria-hidden="true">→</span>
                  <?php endif; ?>
                </a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
