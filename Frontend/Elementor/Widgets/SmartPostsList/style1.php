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
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

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
    echo '<div class="blogkit-smart-posts-list-wrapper">';

    while ($query->have_posts()):
        $query->the_post();
        ?>
        <!-- single blog -->
        <div class="blogkit-smart-posts-list-item">
            <!-- Thumbnail -->
            
                <div class="blogkit-smart-posts-thumb">
                    <?php if (has_post_thumbnail()):
                        echo get_the_post_thumbnail(get_the_ID(), 'full');
                    else:
                        echo '<img src="' . esc_attr(BLOGKIT_ELEMENTOR_ASSETS . '/img/placeholder.png') . '" >';
                    endif; ?>
                        
                </div>

            

            <!-- Content   -->
            <div class="blogkit-smart-posts-content">

                <!-- Rendering post title -->
                <?php


                echo '<a href="' . get_the_permalink() . '"><' . $title_tag . ' class="blogkit-smart-posts-title">' . get_the_title() . '</' . $title_tag . '></a>';

                // Displaying Human Different Time
                if ('yes' === $settings['show_humanize_date']) {
                    echo '<span class="blogkit-smart-posts-date">' . ($settings['layout_style'] === 'style_3' ? SVG::Calender() : '') . human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago </span>';
                } else {
                    echo '<span class="blogkit-smart-posts-date">' . ($settings['layout_style'] === 'style_3' ? SVG::Calender() : '') . get_the_date('M j, Y') . '<span>';
                }
                ?>


            </div>
        </div>
        <?php
    endwhile;

    echo '</div>'; // End smart-posts-list-wrapper
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

