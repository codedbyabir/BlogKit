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
    'posts_per_page' => $settings['posts_per_page'],
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
    echo '<div class="blogkit-post-card-grid-wrapper blogkit-grid-columns">';

    while ($query->have_posts()):
        $query->the_post();
        ?>
        <!-- single blog -->
        <div class="blogkit-post-card">
            <!-- Thumbnail -->
            <?php if (has_post_thumbnail()): ?>
                <a class="blogkit-post-card-thumbnail" href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('large'); ?>
                </a>
            <?php else: ?>
                <img src="<?php echo esc_url(BLOGKIT_ELEMENTOR_ASSETS . '/img/placeholder.png'); ?>"
                    alt="<?php the_title_attribute(); ?>">
            <?php endif; ?>

            <!-- Content   -->
            <div class="blogkit-post-card-content">
                <!-- Category Button -->
                <?php
                if ('yes' === $settings['show_category']) {
                    $categories = get_the_category();
                    if ($categories && !is_wp_error($categories)) {
                        $first_category = $categories[0];
                        // Getting the first category name 
                        $category_link = get_category_link($first_category->term_id);
                        echo '<a href="' . esc_url($category_link) . '" class="blogkit-post-card-category">' . esc_html($first_category->name) . '</a>';
                    }
                }


                // Rendering post title
        
                $title_tag = $settings['title_tag'];
                echo '<a href="' . get_the_permalink() . '"><' . $title_tag . ' class="blogkit-post-card-title">' . get_the_title() . '</' . $title_tag . '></a>';

                ?>

                <div class="blogkit-post-card-meta">
                    <span><strong>By</strong> <?php the_author(); ?></span>

                    <?php

                    // Displaying Human Different Time
                    if ('yes' === $settings['show_humanize_date']) {
                        echo '<span>' . human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago </span>';
                    } else {
                        echo '<span>' . get_the_date('M j, Y') . '<span>';
                    }
                    ?>

                </div>
                <div class="blogkit-post-card-comments">
                    <?php echo SVG::Comments();
                    comments_number('No Comments', '1', '%'); ?>
                </div>
            </div>
        </div>
        <?php
    endwhile;

    echo '</div>'; // .blogkit-card-grid-wrapper

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

        wp_reset_postdata();

    }
endif;


?>