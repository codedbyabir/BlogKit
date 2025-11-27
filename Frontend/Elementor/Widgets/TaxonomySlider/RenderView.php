<?php
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
<div>
    <div class="swiper">
    <div class="slider-wrapper taxonomy-slider-wrapper">
    <div class="swiper-wrapper taxonomy-slider">
        <?php foreach ($terms as $term):
            $img = get_term_meta($term->term_id, 'cat-image', true);
            ?>
            <div class="swiper-slide taxonomy-item">
                <div class="image-box">
                    <?php if ($img): ?>
                        <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($term->name); ?>">
                    <?php else: ?>
                        <div class="no-image">No Image</div>
                    <?php endif; ?>
                </div>
                <div class="taxonomy-name"><?php echo esc_html($term->name); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-pagination"></div>
</div>
</div>
<div>
    <div class="swiper-slide-button taxonomy-slider-button-prev">
        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#ff0000"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg>
    </div>
    <div class="swiper-slide-button taxonomy-slider-button-next">
        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#ff0000"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg>
    </div>
</div>
</div>
<script>
(function(){
    var script = document.currentScript;

    function findClosestSwiper(el){
        while (el && el !== document.documentElement) {
            if (el.classList && el.classList.contains('swiper')) return el;
            el = el.parentElement;
        }
        return document.querySelector('.swiper');
    }

    var root = findClosestSwiper(script);

    // abort if we couldn't find a valid root element
    if (!(root instanceof Element)) return;

    function init(){
        if (typeof Swiper === 'undefined') {
            return setTimeout(init, 50);
        }

        // prefer the inner slider-wrapper as the Swiper container if present
        var container = root.querySelector('.slider-wrapper') || root;
        if (!(container instanceof Element)) return;

        // require a wrapper with slides
        var wrapper = container.querySelector('.swiper-wrapper');
        if (!wrapper) return;

        // find pagination & nav elements scoped to this widget instance
        var paginationEl = container.querySelector('.swiper-pagination') || root.querySelector('.swiper-pagination');
        var nextEl = container.querySelector('.taxonomy-slider-button-next') || root.querySelector('.taxonomy-slider-button-next');
        var prevEl = container.querySelector('.taxonomy-slider-button-prev') || root.querySelector('.taxonomy-slider-button-prev');

        // Ensure container is positioned so absolutely-positioned pagination is visible
        var computed = window.getComputedStyle(container);
        if (computed.position === 'static') {
            container.style.position = 'relative';
        }

        new Swiper(container, {
            loop: true,
            grabCursor: true,
            spaceBetween: <?php echo (int) ($settings['space_between'] ?? 30); ?>,
            // pass Elements (not selector strings) to ensure proper scoping

            //Autoplay
            autoplay: <?php echo ($settings['autoplay'] ?? 'yes') === 'yes' ? '{ delay: 2500, disableOnInteraction: false }' : 'false'; ?>,

            //Pagination
            pagination: {
                el: paginationEl,
                clickable: true,
                dynamicBullets: true
            },
            //Navigation
            navigation: {
                nextEl: nextEl,
                prevEl: prevEl,
            },
            breakpoints: {
                0:    { slidesPerView: <?php echo (int) ($settings['slides_per_mobile'] ?? 2); ?> },
                768:  { slidesPerView: <?php echo (int) ($settings['slides_per_tablet'] ?? 3); ?> },
                1024: { slidesPerView: <?php echo (int) ($settings['slides_per_desktop'] ?? 6); ?> }
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