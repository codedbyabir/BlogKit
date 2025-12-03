<?php
/**
 * Assets.php
 *
 * This file contains the Assets class, which handles the initialization and configuration of the BlogKit Elementor Assets.
 * It ensures the proper loading of required assets such as CSS and JavaScript files for the BlogKit Elementor plugin.
 *
 * @package BlogKit\Frontend\Elementor\Assets
 * @since 1.0.0
 */

namespace BlogKit\Frontend\Elementor\Assets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Handles the initialization and configuration of the BlogKit Elementor Assets.
 * This class ensures the proper loading of required assets such as CSS and JavaScript files.
 *
 * @package BlogKit\Frontend\Elementor\Assets
 * @since 1.0.0
 */
class Assets
{
    /**
     * Constructor for the Assets class.
     *
     * Initializes the assets for the BlogKit Elementor plugin by calling the init() method.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Initializes the assets for the BlogKit Elementor plugin.
     *
     * Hooks into WordPress to enqueue necessary scripts and styles.
     *
     * @return void
     */
    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
          // enqueue registered widget assets in Elementor editor preview
         add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_editor_assets']);
    }

    /**
     * Registers JavaScript files for the BlogKit Elementor plugin.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        // General scripts
        wp_register_script('swiper-bundle-js', BLOGKIT_ELEMENTOR_ASSETS . "/js/swiper-bundle.min.js", ['jquery'], BLOGKIT_VERSION, true);
        wp_register_script('blogkit-main', BLOGKIT_ELEMENTOR_ASSETS . "/js/main.js", ['jquery'], BLOGKIT_VERSION, true);
        wp_register_script('blogkit-taxonomy-slider', BLOGKIT_ELEMENTOR_ASSETS . "/js/taxonomy-slider.js", ['jquery' , 'swiper-bundle-js'], BLOGKIT_VERSION, true);
    }

    /**
     * Enqueues and registers CSS styles for the BlogKit Elementor plugin.
     *
     * @since 1.0.0
     */
    public function enqueue_styles()
    {
        wp_register_style('swiper-bundle-css', BLOGKIT_ELEMENTOR_ASSETS . "/css/swiper-bundle.min.css", [], BLOGKIT_VERSION);
        wp_register_style('blogkit-elementor-style', BLOGKIT_ELEMENTOR_ASSETS . "/css/style.css", [], BLOGKIT_VERSION);
        wp_register_style('blogkit-style-2', BLOGKIT_ELEMENTOR_ASSETS . "/css/style2.css", [], BLOGKIT_VERSION);
        wp_register_style('blogkit-responsive', BLOGKIT_ELEMENTOR_ASSETS . "/css/responsive.css", [], BLOGKIT_VERSION);
        
    }

    /**
     * Enqueues registered widget assets in Elementor editor preview.
     *
     * @since 1.0.0
     */
    public function enqueue_editor_assets()
    {
        // Enqueue registered widget assets in Elementor editor preview
        wp_enqueue_script('swiper-bundle-js');
        wp_enqueue_script('blogkit-taxonomy-slider');
        wp_enqueue_style('swiper-bundle-css');
        wp_enqueue_style('blogkit-elementor-style');
        wp_enqueue_style('blogkit-style-2');
        wp_enqueue_style('blogkit-responsive');
    }    
}