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
    'posts_per_page' => $settings['posts_per_page_style2'],
    'orderby' => $settings['orderby'],
    'order' => $settings['order'],
    'paged' => $paged,
];

if (!empty($settings['category'])) {
    $args['category_name'] = implode(',', $settings['category']);
}

$query = new WP_Query($args);


if ( $query->have_posts() ) :
			$posts = $query->posts;
			$featured_post = array_shift( $posts ); // first post
			?>

			<section class="blogkit-card-grid grid-style2">
				<!-- Featured Post -->
				<?php if ( $featured_post ) :
					$thumb = get_the_post_thumbnail_url( $featured_post->ID, 'large' );
    $post_alt = get_post_meta(get_post_thumbnail_id($featured_post), '_wp_attachment_image_alt', true);
					?>
					<div class="blogkit-featured-post">
						<a href="<?php echo get_permalink( $featured_post->ID ); ?>">
							<?php if($thumb):
                                        echo '<img class="blogkit-featured-thumbnail" src="'. esc_url( $thumb ) .'" alt="'. esc_attr($post_alt) .'">';
                            else:
                                echo '<img class="blogkit-featured-thumbnail" src="' . esc_attr(BLOGKIT_ELEMENTOR_ASSETS . '/img/placeholder.png') . '" alt="' . esc_attr($post_alt) . '">';
                            endif;
    ?>
						</a>
						<div class="blogkit-featured-overlay">
							<span class="tag">
								<?php
								$cat = get_the_category( $featured_post->ID );
								if ( ! empty( $cat ) ) {
									echo esc_html( $cat[0]->name );
								} 
								?>
							</span>
							
							<<?php echo $title_tag; ?> class="blogkit-featured-title">
								<a href="<?php echo get_permalink( $featured_post->ID ); ?>">
									<?php echo esc_html( get_the_title( $featured_post->ID ) ); ?>
								</a>
							</<?php echo $title_tag; ?>>
							<div class="blogkit-featured-meta">
								<span class="author"><?php echo get_avatar(get_the_author_meta('ID')); echo get_the_author_meta( 'display_name', $featured_post->post_author ); ?></span>
								<span class="date"><?php echo svg::Calender(); echo get_the_date( 'F j, Y', $featured_post->ID ); ?></span>
								<span class="comments"><?php echo svg::Comments(); echo get_comments_number( $featured_post->ID ); ?> Comments</span>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<!-- Grid -->
				<div class="blogkit-card-grid">
					<?php
					foreach ( $posts as $index => $post ) :
						setup_postdata( $post );
						$thumb = get_the_post_thumbnail_url( $post->ID, 'medium_large' );
                    $post_alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
						?>
						<div class="blogkit-card-grid-item">
							<a href="<?php echo get_permalink( $post->ID ); ?>">
								<?php
                                    if($thumb):
                                        echo '<img src="'.esc_url( $thumb ).'" alt="'.esc_attr($post_alt).'">';
                                    else:
                                        echo '<img src="' . esc_attr(BLOGKIT_ELEMENTOR_ASSETS . '/img/placeholder.png') . '" alt="' . esc_attr($post_alt) . '">';
                                    endif;
                                ?>
								
									<div class="blogkit-overlay-content">
										<span class="date"><?php echo get_the_date( 'F j, Y', $post->ID ); ?></span>
										<<?php echo $title_tag; ?> class="blogkit-card-grid-title"><?php echo esc_html( get_the_title( $post->ID ) ); ?></<?php echo $title_tag; ?>>
									</div>
							</a>
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

