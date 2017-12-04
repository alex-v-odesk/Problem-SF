<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup()
{
    // Enable features from Soil when plugin is activated
    // https://roots.io/plugins/soil/
    add_theme_support('soil-clean-up');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-relative-urls');

    // Make theme available for translation
    // Community translations can be found at https://github.com/roots/sage-translations
    load_theme_textdomain('sage', get_template_directory() . '/lang');

    // Enable plugins to manage the document title
    // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
    add_theme_support('title-tag');

    // Register wp_nav_menu() menus
    // http://codex.wordpress.org/Function_Reference/register_nav_menus
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
    ]);

    // Enable post thumbnails
    // http://codex.wordpress.org/Post_Thumbnails
    // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
    // http://codex.wordpress.org/Function_Reference/add_image_size
    add_theme_support('post-thumbnails');

    // Enable post formats
    // http://codex.wordpress.org/Post_Formats
    add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

    // Enable HTML5 markup support
    // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    // Use main stylesheet for visual editor
    // To add custom styles edit /assets/styles/layouts/_tinymce.scss
    add_editor_style(Assets\asset_path('styles/main.css'));

    /*********************
    WP_HEAD CLEANLINESS
     *********************/

    // category feeds
    // remove_action( 'wp_head', 'feed_links_extra', 3 );
    // post and comment feeds
    // remove_action( 'wp_head', 'feed_links', 2 );
    // EditURI link
    remove_action('wp_head', 'rsd_link');
    // windows live writer
    remove_action('wp_head', 'wlwmanifest_link');
    // index link
    remove_action('wp_head', 'index_rel_link');
    // previous link
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    // start link
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    // links for adjacent posts
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    // WP version
    remove_action('wp_head', 'wp_generator');
    // remove WP version from css
    //add_filter( 'style_loader_src', 'hair_remove_wp_ver_css_js', 9999 );
    // remove Wp version from scripts
    //add_filter( 'script_loader_src', 'hair_remove_wp_ver_css_js', 9999 );
    // Disable the admin bar
    add_filter('show_admin_bar', '__return_false');
    // Display the links to the extra feeds such as category feeds
    remove_action('wp_head', 'feed_links_extra', 3);
    // Display the links to the general feeds: Post and Comment Feed
    remove_action('wp_head', 'feed_links', 2);

    //ACF Options Page
    //acf_add_options_page();

}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init()
{
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar()
{
    static $display;

    isset($display) || $display = !in_array(true, [
        // The sidebar will NOT be displayed if ANY of the following return true.
        // @link https://codex.wordpress.org/Conditional_Tags
        is_404(),
        is_front_page(),
        is_page_template('template-custom.php'),
    ]);

    //return apply_filters('sage/display_sidebar', $display);
}

/**
 * Theme assets
 */
function assets()
{
    wp_enqueue_style('sage/css', Assets\asset_path('styles/main.css'), false, null);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_register_script('sage/js', Assets\asset_path('scripts/main.js'), ['jquery'], '', true);

    //For AJAX shit
    $cartpage = get_post(get_option('woocommerce_cart_page_id'));

    wp_localize_script('sage/js', 'ajax_objects', array(
        'ajaxurl'            => admin_url('admin-ajax.php'),
        'cart_url'           => $cartpage->guid,
        'themeurl'           => get_template_directory_uri(),
        'redirecturl'        => $_SERVER['REQUEST_URI'],
    ));

    wp_enqueue_script('sage/js');

}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);
