<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
use BlogKit\Admin\Assets\SVG;
use Elementor\Icons_Manager;
/**
 * Blog Grid Widget View for Elementor
 * Compatible with any theme, styled like abcblog theme
 */

$settings = $this->get_settings_for_display();
$title_tag = $settings['title_tag'];

// Pagination setup
$paged = 1;
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} elseif (get_query_var('page')) {
    $paged = get_query_var('page');
}

// Posts Query 
$args = [
    'post_type' => 'post',
    'posts_per_page' => $settings['posts_per_page'] ? $settings['posts_per_page'] : 6,
    'orderby' => $settings['orderby'],
    'order' => $settings['order'],
    'paged' => $paged,
];

if (!empty($settings['category'])) {
    $args['category_name'] = implode(',', $settings['category']);
}

$query = new WP_Query($args);
// end post query 

// check if there are posts to display
if ($query->have_posts()):
    echo '<section class="blogkit-post-card-wrapper card-style-3">';

    while ($query->have_posts()):
        $query->the_post();
        ?>
        <article class="blogkit-post-card-item">
            <div class="blogkit-post-thumb">
                <?php
                if (has_post_thumbnail()):
                    the_post_thumbnail('full');
                else:
                    echo '<img src="' . esc_url(BLOGKIT_ELEMENTOR_ASSETS . '/img/placeholder.png') . '">';
                endif;
                ?>
            </div>

            <div class="blogkit-post-content">
                <?php
                // Category Button
                if ('yes' === $settings['show_category']) {
                    $category = get_the_category();
                    if($category){
                        echo '<a href="' . get_category_link($category[0]->term_id) . '" class="blogkit-post-category">' . $category[0]->name . '</a>';
                    }
                }

                ?>
                <!-- Title  -->
                <<?php echo $title_tag ?> class="blogkit-post-title">
                    <a href="<?php esc_url(the_permalink()) ?>"><?php esc_html(the_title()) ?></a>
                </<?php echo $title_tag ?>>
            </div>
        </article>
        <?php
    endwhile;

    echo '</section>';



    // Pagination

    if ('yes' === $settings['show_pagination']) {

        $big = 999999999; // need an unlikely integer for base replacement
        $pagination_links = paginate_links([
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, $paged),
            'total' => $query->max_num_pages,
            'prev_text' => __('« Previous', 'blogkit'),
            'next_text' => __('Next »', 'blogkit'),
            'type' => 'list',
        ]);

        if ($pagination_links) {
            echo '<div class="blogkit-pagination">' . wp_kses_post($pagination_links) . '</div>';
        } else {
            echo '<p>' . esc_html__('No posts found.', 'blogkit') . '</p>';
        }
    }
    wp_reset_postdata();
endif;

