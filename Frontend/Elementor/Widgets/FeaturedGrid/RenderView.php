<?php


$settings = $this->get_settings_for_display();


// Posts Query 
$args = [
    'post_type' => 'post',
    'posts_per_page' => $settings['posts_per_page'],
    'orderby' => $settings['orderby'],
    'order' => $settings['order'],
];

if (!empty($settings['category'])) {
    $args['category_name'] = implode(',', $settings['category']);
}

$query = new WP_Query($args);

if (!$query->have_posts()) {
    echo '<p>No posts found.</p>';
    return;
}

$posts = [];
while ($query->have_posts()) {
    $query->the_post();
    $category_obj = get_the_category();
    $category_name = !empty($category_obj[0]) ? $category_obj[0]->name : '';
    $category_url = !empty($category_obj[0]) ? get_category_link($category_obj[0]->term_id) : '';

    $posts[] = [
        'title' => get_the_title(),
        'link' => get_permalink(),
        'image' => get_the_post_thumbnail_url(null, 'large') ?: '/wp-content/plugins/Blogkit/frontend/Elementor/Assets/img/placeholder.png',
        'author' => get_the_author(),
        'date' => get_the_date(),
        'category' => $category_name,
        'category_url' => $category_url,
    ];
}
wp_reset_postdata();
?>

<div class="blogkit-fg-custom-post">
    <!-- Left Large Post -->
    <?php if (!empty($posts[0])):
        $p = $posts[0]; ?>
        <div class="blogkit-fg-post-card blogkit-fg-post-card--large blogkit-fg-post__left"
            style="background-image: url('<?php echo esc_url($p['image']); ?>')">

            <div class="blogkit-fg-post-card__overlay">

                <!-- Category -->
                <?php if ('yes' === $settings['show_category'] && !empty($p['category'])): ?>
                    <a href="<?php echo esc_html($p['category_url']); ?>"
                        class="blogkit-fg-post-card__cat"><?php echo esc_html($p['category']); ?></a>
                <?php endif; ?>

                <!-- Title -->
                <?php if ('yes' === $settings['show_title']): ?>
                    <a href="<?php echo esc_html($p['link']); ?>">
                        <h2 class="blogkit-fg-post-card__title"><?php echo esc_html($p['title']); ?></h2>
                    </a>
                <?php endif; ?>


                <div class="blogkit-fg-post-card__meta">
                    <span class="blogkit-fg-post-card__author">By <?php echo esc_html($p['author']); ?></span>
                    <span class="blogkit-fg-post-card__date"><?php echo esc_html($p['date']); ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Right Grid -->
    <div class="blogkit-fg-post__right">
        <!-- Top Right Wide Post -->
        <?php if (!empty($posts[1])):
            $p = $posts[1]; ?>
            <div class="blogkit-fg-post-card blogkit-fg-post-card--wide"
                style="background-image: url('<?php echo esc_url($p['image']); ?>')">
                <div class="blogkit-fg-post-card__overlay">

                    <!-- Category -->
                    <?php if ('yes' === $settings['show_category'] && !empty($p['category'])): ?>
                        <a href="<?php echo esc_html($p['category_url']); ?>"
                            class="blogkit-fg-post-card__cat"><?php echo esc_html($p['category']); ?></a>
                    <?php endif; ?>

                    <!-- Title -->
                    <?php if ('yes' === $settings['show_title']): ?>
                        <a href="<?php echo esc_html($p['link']); ?>">
                            <h3 class="blogkit-fg-post-card__title"><?php echo esc_html($p['title']); ?></h3>
                        </a>
                    <?php endif; ?>


                    <div class="blogkit-fg-post-card__meta">
                        <span class="blogkit-fg-post-card__author">By <?php echo esc_html($p['author']); ?></span>
                        <span class="blogkit-fg-post-card__date"><?php echo esc_html($p['date']); ?></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Bottom 2 Posts -->
        <div class="blogkit-fg-post__bottom">
            <?php for ($i = 2; $i <= 3; $i++):
                if (!empty($posts[$i])):
                    $p = $posts[$i]; ?>
                    <div class="blogkit-fg-post-card blogkit-fg-post-card--small"
                        style="background-image: url('<?php echo esc_url($p['image']); ?>')">
                        <div href="<?php echo esc_url($p['link']); ?>" class="blogkit-fg-post-card__overlay">

                            <!-- Category -->
                            <?php if ('yes' === $settings['show_category'] && !empty($p['category'])): ?>
                                <a href="<?php echo esc_html($p['category_url']); ?>"
                                    class="blogkit-fg-post-card__cat"><?php echo esc_html($p['category']); ?></a>
                            <?php endif; ?>

                            <!-- Title -->
                            <?php if ('yes' === $settings['show_title']): ?>
                                <a href="<?php echo esc_html($p['link']); ?>">
                                    <h4 class="blogkit-fg-post-card__title"><?php echo esc_html($p['title']); ?></h4>
                                </a>
                            <?php endif; ?>


                            <div class="blogkit-fg-post-card__meta">
                                <span class="blogkit-fg-post-card__author">By <?php echo esc_html($p['author']); ?></span>
                                <span class="blogkit-fg-post-card__date"><?php echo esc_html($p['date']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endif; endfor; ?>
        </div>
    </div>
</div>
<?php
