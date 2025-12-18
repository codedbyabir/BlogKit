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
    // split posts into featured (first 2) and rest
    $all_posts = $query->posts;
    $featured_posts = array_slice($all_posts, 0, 2);
    $other_posts = array_slice($all_posts, 2);

    ?>
    <section class="blogkit-post-card card-style-2">

        <div class="blogkit-featured-posts">
            <?php
            foreach ($featured_posts as $post) {
                setup_postdata($post);
                ?>
                <article class="blogkit-featured-post">
                    <div class="blogkit-featured-thumb">
                        <a href="<?php echo esc_url(get_permalink($post)); ?>">
                            <?php
                            if (has_post_thumbnail($post->ID)) {
                                echo get_the_post_thumbnail($post->ID, 'full');
                            } else {
                                echo '<img src="' . esc_url(BLOGKIT_ELEMENTOR_ASSETS . '/img/placeholder.png') . '" />';
                            }
                            ?>
                            <?php
                            $categories = get_the_category($post->ID);
                            if (!empty($categories)) {
                                // echo '<span class="blogkit-featured-badge">' . esc_html($categories[0]->name) . '</span>';
                                echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '" class="blogkit-featured-badge">' . esc_html($categories[0]->name) . '</a>';
                            }
                            ?>
                        </a>
                    </div>

                    <div class="blogkit-featured-content">
                        <div class="blogkit-featured-meta">
                            <!-- Author Archive -->
                            <a
                                href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID', $post->post_author))); ?>">
                                <span><?php echo get_avatar(get_the_author_meta('ID', $post->post_author));
                                echo esc_html(get_the_author_meta('display_name', $post->post_author)); ?></span>
                            </a>
                            <!-- Date Archive -->
                            <a
                                href="<?php echo esc_url(get_day_link(get_the_time('Y', $post), get_the_time('m', $post), get_the_time('d', $post))); ?>">
                                <span><?php echo SVG::Calender();
                                echo esc_html(get_the_date('M d, Y', $post)); ?></span>
                            </a>
                            <!-- Comments -->
                            <span><?php echo SVG::Comments();
                            echo '(' . (int) get_comments_number($post) . ')'; ?></span>
                        </div>


                        <h3 class="blogkit-featured-title">

                            <a href="<?php echo esc_url(get_permalink($post)); ?>">
                                <?php echo esc_html(get_the_title($post)); ?>
                            </a>
                        </h3>


                    </div>
                </article>
                <?php
            }
            wp_reset_postdata();
            ?>
        </div>

        <div class="blogkit-post-card-bottom-grid">
            <?php
            foreach ($other_posts as $post) {
                setup_postdata($post);
                ?>
                <article class="blogkit-post-card">
                    <a href="<?php echo esc_url(get_permalink($post)); ?>">
                        <?php
                        if (has_post_thumbnail($post->ID)):
                            echo get_the_post_thumbnail($post->ID, 'full');
                        else:
                            echo '<img src="' . esc_url(BLOGKIT_ELEMENTOR_ASSETS . '/img/placeholder.png') . '" />';

                        endif;
                        ?>
                    </a>

                    <div class="blogkit-post-card-content">
                        <h4 class="blogkit-post-card-title">
                            <a
                                href="<?php echo esc_url(get_permalink($post)); ?>"><?php echo esc_html(get_the_title($post)); ?></a>
                        </h4>

                        <p class="blogkit-post-card-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt($post), $settings['excerpt_length'] ? $settings['excerpt_length'] : 15)); ?>
                        </p>
                    </div>
                </article>
                <?php
            }
            wp_reset_postdata();
            ?>
        </div>

    </section>
    <?php


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

