<?php

use BlogKit\Admin\Assets\SVG;
// Exit if accessed directly.
if (!defined('ABSPATH'))
    exit;

$settings = $this->get_settings_for_display();
$blogkit_unique_id = $this->get_id();


// Taxonomy terms
$uncat = get_term_by('slug', 'uncategorized', 'category');
$exclude_ids = $uncat ? [(int) $uncat->term_id] : [];
$terms = get_terms(['taxonomy' => 'category', 'hide_empty' => false, 'exclude' => $exclude_ids,]);


// Prepare Swiper settings for JS
$swiper_settings = wp_json_encode([
    'loop' => ($settings['infinite_loop'] ?? 'yes') === 'yes',

    'autoplay' => (($settings['autoplay'] ?? 'yes') === 'yes') ? [
        'delay' => max(0, min(60000, (int) ($settings['autoplay_speed'] ?? 2500))),
        'pauseOnMouseEnter' => ($settings['pause_on_hover'] ?? 'yes') === 'yes',
        'disableOnInteraction' => false,
    ] : false,

    // BREAKPOINTS — MATCH EXACT JS KEYS
    'slides_per_view_desktop' => (int) ($settings['slides_per_desktop'] ?? 6),
    'space_between_desktop' => (int) ($settings['space_between_desktop'] !== '' ? $settings['space_between_desktop'] : 30),
    'slides_per_view_tablet' => (int) ($settings['slides_per_tablet'] ?? 4),
    'space_between_tablet' => (int) ($settings['space_between_tablet'] !== '' ? $settings['space_between_tablet'] : 20),
    'slides_per_view_mobile' => (int) ($settings['slides_per_mobile'] ?? 2),
    'space_between_mobile' => (int) ($settings['space_between_mobile'] !== '' ? $settings['space_between_mobile'] : 20),
]);

// var_dump($swiper_settings);



?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        BlogKitTaxonomySliderInit('<?php echo esc_js($blogkit_unique_id); ?>');
    });
</script>




<div class="blogkit-taxonomy-slider-wrapper">
    <!-- Slider Container -->
    <div id="blogkit-taxonomy-slider-<?php echo esc_attr($blogkit_unique_id); ?>"
        class="blogkit-taxonomy-slider swiper swiper-container"
        data-swiper-settings='<?php echo esc_attr($swiper_settings); ?>'
        data-prev-el="#blogkit-slider-arrow-prev-<?php echo esc_attr($blogkit_unique_id); ?>"
        data-next-el="#blogkit-slider-arrow-next-<?php echo esc_attr($blogkit_unique_id); ?>">

        <div class="swiper-wrapper blogkit-taxonomy-slider">
            <?php foreach ($terms as $term):
                $img = get_term_meta($term->term_id, 'cat-image', true);
                ?>
                <div class="swiper-slide blogkit-taxonomy-item">
                    <a href="<?php echo get_category_link($term->term_id); ?>">
                        <div class="image-box">
                            <?php if ($img): ?>
                                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($term->name); ?>">
                            <?php else: ?>
                                <div class="no-image">No Image</div>
                            <?php endif; ?>
                        </div>
                    </a>
                    <div class="blogkit-taxonomy-name"><?php echo esc_html($term->name); ?></div>
                </div>
            <?php endforeach; ?>


        </div>

        <!-- If we need pagination -->
        <?php if (($settings['pagination_dots'] ?? 'yes') === 'yes'): ?>
            <div class="swiper-pagination blogkit-taxonomy-slider-pagination"></div>
        <?php endif; ?>





    </div>
    <?php if (($settings['navigation_arrows'] ?? 'yes') === 'yes'): ?>
        <div id="blogkit-slider-arrow-prev-<?php echo esc_attr($blogkit_unique_id); ?>"
            class="blogkit-taxonomy-slider-button-prev" role="button"
            aria-label="<?php echo esc_attr__('Previous slide', 'blogkit'); ?>">
            <?php echo SVG::arrow_left_alt(); ?>

        </div>
        <div id="blogkit-slider-arrow-next-<?php echo esc_attr($blogkit_unique_id); ?>"
            class="blogkit-taxonomy-slider-button-next" role="button"
            aria-label="<?php echo esc_attr__('Next slide', 'blogkit'); ?>">
            <?php echo SVG::arrow_right_alt(); ?>

        </div>
    <?php endif; ?>
</div>