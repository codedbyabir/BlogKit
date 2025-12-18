<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
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
    'posts_per_page' => $settings['posts_per_page_style4'],
    'orderby' => $settings['orderby'],
    'order' => $settings['order'],
    'paged' => $paged,
];

if (!empty($settings['category'])) {
    $args['category_name'] = implode(',', $settings['category']);
}

$query = new WP_Query($args);


if ($query->have_posts()):
    $posts = $query->posts;
    ?>

    <section class="blogkit-card-grid grid-style4">
        <?php
        foreach ($posts as $post):
            setup_postdata($post);
            $post_id = $post->ID;
            $post_title = get_the_title($post_id);
            $post_permalink = get_permalink($post_id);
            $post_excerpt = get_the_excerpt($post_id);
            $category = get_the_category($post_id);
            $category_name = !empty($category) ? $category[0]->name : '';
            $category_link = !empty($category) ? get_category_link($category[0]->term_id) : '';
            $post_date = get_the_date('M j Y', $post_id);
            $post_author_id = $post->post_author;
            $post_author_name = get_the_author_meta('display_name', $post_author_id);

            ?>

            <!-- Card Item -->
            <article class="blogkit-card">
                <div class="blogkit-card-thumb">
                    <?php
                    if (has_post_thumbnail($post_id)):
                        echo get_the_post_thumbnail($post_id, 'full');


                    else:

                        echo '<img src="' . esc_attr(BLOGKIT_ELEMENTOR_ASSETS . '/img/placeholder.png') . '" >';

                    endif;
                    ?>
                </div>

                <div class="blogkit-card-content">
                    <?php
                    if ($category_name):
                        echo '<a class="blogkit-card-badge" href="' . esc_url($category_link) . '">' . esc_html($category_name) . '</a>';

                    endif;
                    ?>



                    <?php
                    echo '<h3 class="blogkit-card-title"><a href="' . $post_permalink . '">' . $post_title . '</a></h3>';
                    ?>


                    <div class="blogkit-card-meta">
                        <?php
                        echo '<span><i>BY</i> ' . $post_author_name . '</span>';
                        echo '<span>' . $post_date . '</span>';
                        ?>
                    </div>
                </div>
            </article>

            <?php
        endforeach;
        wp_reset_postdata();
        ?>

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

