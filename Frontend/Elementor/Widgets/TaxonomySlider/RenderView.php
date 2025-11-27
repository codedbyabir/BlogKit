<?php

use BlogKit\Admin\Assets\SVG;
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


$settings = $this->get_settings_for_display();
$uncat = get_term_by( 'slug', 'uncategorized', 'category' );
$exclude_ids = $uncat ? [ (int) $uncat->term_id ] : [];
$terms = get_terms( [
    'taxonomy'   => 'category',
    'hide_empty' => false,
    'exclude'    => $exclude_ids,
] );

if (!$terms) {
    echo '<p>No categories found.</p>';
    return;
}

?>
<div class="blogkit-wrapper">
    <div class="swiper">
        <div class="slider-wrapper taxonomy-slider-wrapper">
            <div class="swiper-wrapper taxonomy-slider">
                <?php foreach ($terms as $term):
                    $img = get_term_meta($term->term_id, 'cat-image', true);
                    ?>
                    <div class="swiper-slide taxonomy-item">
                        <a href="<?php echo get_category_link($term->term_id); ?>">
                            <div class="image-box">
                            <?php if ($img): ?>
                                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($term->name); ?>">
                            <?php else: ?>
                                <div class="no-image">No Image</div>
                            <?php endif; ?>
                        </div>
                        </a>
                        <div class="taxonomy-name"><?php echo esc_html($term->name); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>

<div class="swiper-pagination"></div>

        </div>
    </div>

            

            <div class="taxonomy-slider-button-prev" role="button" aria-label="<?php echo esc_attr__('Previous slide','blogkit'); ?>">
                <?php echo SVG::arrow_left_alt(); ?>
</svg>

            </div>
            <div class="taxonomy-slider-button-next" role="button" aria-label="<?php echo esc_attr__('Next slide','blogkit'); ?>">
                <?php echo SVG::arrow_right_alt(); ?>
</svg>

            </div>
</div>
<script>
(function(){
    var script = document.currentScript;

    // Scope to the nearest widget wrapper (works even if pagination/nav are outside slider-wrapper)
    var widgetRoot = script.closest('.blogkit-wrapper') || script.closest('.swiper') || document.querySelector('.blogkit-wrapper') || document.querySelector('.swiper');
    if (!(widgetRoot instanceof Element)) return;

    function findContainer() {
        // Prefer explicit slider wrapper, fall back to .swiper containing .swiper-wrapper
        var c = widgetRoot.querySelector('.slider-wrapper') || widgetRoot.querySelector('.swiper') || widgetRoot;
        if (!(c instanceof Element)) return null;
        if (!c.querySelector('.swiper-wrapper')) {
            var alt = widgetRoot.querySelector('.swiper') || document.querySelector('.swiper');
            if (alt && alt.querySelector('.swiper-wrapper')) c = alt;
        }
        return c;
    }

    var container = findContainer();
    if (!(container instanceof Element)) return;

    function init(){
        if (typeof Swiper === 'undefined') {
            return setTimeout(init, 50);
        }

        // Find controls within the same widget wrapper (works even if controls are outside slider-wrapper)
        var paginationEl = widgetRoot.querySelector('.swiper-pagination');
        var nextEl = widgetRoot.querySelector('.taxonomy-slider-button-next') || widgetRoot.querySelector('.swiper-button-next');
        var prevEl = widgetRoot.querySelector('.taxonomy-slider-button-prev') || widgetRoot.querySelector('.swiper-button-prev');

        // ensure container is positioned so controls/pagination are visible
        var computed = window.getComputedStyle(container);
        if (computed.position === 'static') {
            container.style.position = 'relative';
        }

        new Swiper(container, {
            loop: <?php echo ($settings['infinite_loop'] ?? 'yes') === 'yes' ? 'true' : 'false'; ?>,
            grabCursor: true,
            //Autoplay
            autoplay: {
                delay: <?php echo (int) ($settings['autoplay_speed'] ?? 2500); ?>,
                pauseOnMouseEnter: <?php echo ($settings['pause_on_hover'] ?? 'yes') === 'yes' ? 'true' : 'false'; ?>, // This enables pausing on hover
                pauseOnInteraction: <?php echo ($settings['pause_on_interaction'] ?? 'yes') === 'yes' ? 'true' : 'false'; ?>, // This enables pausing on interaction
      },
            pagination: {
                el: paginationEl,
                clickable: true,
                dynamicBullets: true
            },
            navigation: {
                nextEl: nextEl,
                prevEl: prevEl,
            },
            breakpoints: {
                0:    { slidesPerView: <?php echo (int) ($settings['slides_per_mobile'] ?? 2); ?>,
                    <?php if (isset($settings['space_between_mobile'])): ?> spaceBetween: <?php echo (int) ($settings['space_between_mobile']); ?>, <?php endif; ?>
                    
                 },
                768:  { slidesPerView: <?php echo (int) ($settings['slides_per_tablet'] ?? 3); ?>,
                    <?php if (isset($settings['space_between_tablet'])): ?> spaceBetween: <?php echo (int) ($settings['space_between_tablet']); ?>, <?php endif; ?>
                    
                 },
                1024: { slidesPerView: <?php echo (int) ($settings['slides_per_desktop'] ?? 6); ?>,
                    <?php if (isset($settings['space_between_desktop'])): ?> spaceBetween: <?php echo (int) ($settings['space_between_desktop']); ?>, <?php endif; ?>
                    
                 }
            }
        });
        
    }
    

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }


})();
</script>