<?php
/**
 * Plugin Name: BlogKit - Advanced Blog Elements for Elementor
 * Description: A powerful toolkit for enhancing your WordPress blog with custom features and performance improvements.
 * Version: 1.2.0
 * Author: Nexiby LLC
 * Author URI: https://nexiby.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: blogkit
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 8.0
 * namespace: blogkit

 * 
 * @package BlogKit
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

final class BlogKit
{
    /**
     * Singleton instance
     */
    private static $instance = null;

    /**
     * BlogKit constructor.
     * Defines constants, loads files, and initializes hooks.
     */
    private function __construct()
    {
        $this->define_constants();
        $this->include_files();
        $this->init_hooks();
    }

    /**
     * Get singleton instance
     *
     * @return BlogKit
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Define plugin constants.
     */
    private function define_constants()
    {
        define('BLOGKIT_VERSION', '1.2.0');
        define('BLOGKIT_PATH', plugin_dir_path(__FILE__));
        define('BLOGKIT_URL', plugin_dir_url(__FILE__));
        define('BLOGKIT_BASENAME', plugin_basename(__FILE__));
        define('BLOGKIT_FILE', __FILE__);
        define('BLOGKIT_NAME', 'BlogKit');
    }

    /**
     * Include necessary files.
     */
    private function include_files()
    {
        if (file_exists(BLOGKIT_PATH . 'vendor/autoload.php')) {
            require_once BLOGKIT_PATH . 'vendor/autoload.php';
        }
    }

    /**
     * Initialize hooks.
     */
    private function init_hooks()
    {
        add_action('plugins_loaded', [$this, 'plugin_loaded']);
        register_activation_hook(BLOGKIT_FILE, [$this, 'activate']);
        register_deactivation_hook(BLOGKIT_FILE, [$this, 'deactivate']);
    }

    /**
     * Called when the plugin is loaded.
     */
    public function plugin_loaded()
    {
        // Check if Elementor is active and loaded
        if (did_action('elementor/loaded') && class_exists('\Elementor\Plugin')) {
            if (class_exists('BlogKit\Manager')) {
                new \BlogKit\Manager();
            }
        } else {
            // Show admin notice if Elementor is not installed or activated
            add_action('admin_notices', function () {
                $elementor_url = admin_url('plugin-install.php?s=elementor&tab=search&type=term');
                echo '<div class="notice notice-error is-dismissible">';
                echo '<p><strong>' . BLOGKIT_NAME . '</strong> requires <a href="' . esc_url($elementor_url) . '" target="_blank">Elementor</a> to be installed and activated.</p>';
                echo '</div>';
            });
        }
    }

    /**
     * Plugin activation hook.
     */
    public function activate()
    {
        if (class_exists('BlogKit\Activate')) {
            \BlogKit\Activate::activate();
        }
    }

    /**
     * Plugin deactivation hook.
     */
    public function deactivate()
    {
        if (class_exists('BlogKit\Deactivate')) {
            \BlogKit\Deactivate::deactivate();
        }
    }
}

/**
 * Initialize the BlogKit plugin.
 */
if (!function_exists('blogkit_initialize')) {
    function blogkit_initialize()
    {
        return BlogKit::get_instance();
    }

    blogkit_initialize();
}



// Enable media uploader on Category add/edit pages
function blogkit_enqueue_category_media($hook) {
    if ($hook === 'edit-tags.php' || $hook === 'term.php') {
        if (isset($_GET['taxonomy']) && $_GET['taxonomy'] === 'category') {
            wp_enqueue_media();
            wp_enqueue_script('jquery');
        }
    }
}
add_action('admin_enqueue_scripts', 'blogkit_enqueue_category_media');

// Add Image Field to "Add New Category"
function blogkit_add_category_image_field() { ?>
    <div class="form-field">
        <label for="cat-image">Category Image</label>
        <input type="text" name="cat-image" id="cat-image" value="" />
        <button style="margin-top: 10px;" class="button upload-cat-image">Upload Image</button>
    </div>

    <script>
    jQuery(function($){
        var mediaFrame;
        $(document).on('click', '.upload-cat-image', function(e){
            e.preventDefault();
            var $input = $(this).prev('input');

            if (mediaFrame) { mediaFrame.open(); return; }

            mediaFrame = wp.media({
                title: 'Select Category Image',
                button: { text: 'Use Image' },
                multiple: false
            });

            mediaFrame.on('select', function(){
                var attachment = mediaFrame.state().get('selection').first().toJSON();
                $input.val(attachment.url);
            });

            mediaFrame.open();
        });
    });
    </script>
<?php }
add_action('category_add_form_fields', 'blogkit_add_category_image_field');

// Add Image Field to "Edit Category"
function blogkit_edit_category_image_field($term) {
    $value = get_term_meta($term->term_id, 'cat-image', true); ?>
    <tr class="form-field">
        <th scope="row"><label for="cat-image">Category Image</label></th>
        <td>
            <input type="text" name="cat-image" id="cat-image" value="<?php echo esc_attr($value); ?>" />
            <button style="margin-top: 10px;" class="button upload-cat-image">Upload Image</button>
            <?php if ($value): ?>
                <br><img src="<?php echo esc_url($value); ?>" style="max-width:120px;margin-top:10px;" />
            <?php endif; ?>
        </td>
    </tr>

    <script>
    jQuery(function($){
        var mediaFrame;
        $(document).on('click', '.upload-cat-image', function(e){
            e.preventDefault();
            var $input = $(this).prev('input');

            if (mediaFrame) { mediaFrame.open(); return; }

            mediaFrame = wp.media({
                title: 'Select Category Image',
                button: { text: 'Use Image' },
                multiple: false
            });

            mediaFrame.on('select', function(){
                var attachment = mediaFrame.state().get('selection').first().toJSON();
                $input.val(attachment.url);

                // show preview
                var $img = $(this).siblings('img');
                if ($img.length) {
                    $img.attr('src', attachment.url);
                } else {
                    $('<br><img style="max-width:120px;margin-top:10px;">').insertAfter($input).attr('src', attachment.url);
                }
            }.bind(this));

            mediaFrame.open();
        });
    });
    </script>
<?php }
add_action('category_edit_form_fields', 'blogkit_edit_category_image_field');

// Save Image URL
function blogkit_save_category_image($term_id) {
    if (isset($_POST['cat-image'])) {
        update_term_meta($term_id, 'cat-image', sanitize_text_field($_POST['cat-image']));
    }
}
add_action('created_category', 'blogkit_save_category_image');
add_action('edited_category', 'blogkit_save_category_image');

