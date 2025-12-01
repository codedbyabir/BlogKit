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
    'posts_per_page' => $settings['posts_per_page_style3'],
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
    $featured_post = array_shift($posts); // first post
    ?>

    <section class="blogkit-card-grid grid-style3">
        <!-- Featured Post -->
        <?php if ($featured_post):
            ?>
            <div class="blogkit-featured-post">
                <div class="blogkit-featured-thumb">
                    <a href="<?php echo get_permalink($featured_post); ?>">
                        <?php echo get_the_post_thumbnail($featured_post, 'large'); ?>
                    </a>
                </div>

                <div class="blogkit-featured-content">

                    <?php
                    $cat = get_the_category($featured_post->ID);
                    if (!empty($cat)):
                        ?>
                        <span class="blogkit-featured-category">
                            <?php echo esc_html($cat[0]->name); ?>
                        </span>
                    <?php endif; ?>

                    <<?php echo $title_tag; ?> class="blogkit-featured-title">
                        <a href="<?php echo get_permalink($featured_post); ?>">
                            <?php echo esc_html($featured_post->post_title); ?>
                        </a>
                    </<?php echo $title_tag; ?>>

                    <div class="blogkit-featured-meta">
                        <span class="blogkit-meta-item"><?php echo get_avatar(get_the_author_meta('ID'));
                        echo get_the_author_meta('display_name', $featured_post->post_author); ?></span>

                        <span class="blogkit-meta-item">
                            <?php echo svg::Calender(); ?>
                            <?php echo get_the_date('F j, Y', $featured_post); ?>
                        </span>

                        <span class="blogkit-meta-item">
                            <?php echo svg::Comments(); ?>
                            <?php echo get_comments_number($featured_post); ?> Comments
                        </span>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Grid -->
        <div class="blogkit-bottom-grid">
            <?php
            foreach ($posts as $index => $post):
                setup_postdata($post);
                $thumb = get_the_post_thumbnail_url($post->ID, 'medium_large');
                ?>

                <div class="blogkit-card-grid-item">

                    <div class="blogkit-card-grid-thumb">
                        <a href="<?php the_permalink($post->ID); ?>">
                            <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                        </a>
                    </div>

                    <div class="blogkit-card-grid-content">
                        <span class="blogkit-time">
                            <?php echo svg::Clock(); ?>
                            <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> Ago
                        </span>



                        <<?php echo $title_tag; ?>
                            class="blogkit-card-grid-title"><a
                                href="<?php echo get_permalink($post->ID); ?>"><?php echo esc_html(get_the_title($post->ID)); ?></a></<?php echo $title_tag; ?>>

                    </div>

                </div>











                <?php
            endforeach;
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

        wp_reset_postdata();

    }
endif;

