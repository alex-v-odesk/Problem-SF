<?php
/**
 * Quick & Dirty function to create custom taxonomies
 * @param  string $plural    Plural version of this taxonomy
 * @param  string $singlular Singular version of this taxonomy
 * @param  string $slug      the slug for this taxonomy
 * @param  array  $types     post_types it should apply to
 * @return return            calls the register_taxonomy function
 */
function hair_make_tax($plural, $singlular, $slug = null, $url, $types = array('post'))
{
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x($plural, 'taxonomy general name'),
        'singular_name'     => _x($singlular, 'taxonomy singular name'),
        'search_items'      => __('Search ' . $singlular),
        'all_items'         => __('All ' . $plural),
        'parent_item'       => __('Parent ' . $singlular),
        'parent_item_colon' => __('Parent ' . $singlular . ':'),
        'edit_item'         => __('Edit ' . $singlular),
        'update_item'       => __('Update ' . $singlular),
        'add_new_item'      => __('Add New ' . $singlular),
        'new_item_name'     => __('New ' . $singlular . ' Name'),
        'menu_name'         => __($singlular),
    );
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => $url),
    );
    return register_taxonomy($slug, $types, $args);
}

/**
 * Quick & Dirty function to create custom post types
 * @param  string  $plural    the plural version of this post type
 * @param  string  $singlular the singular version of this post type
 * @param  string  $slug      the slug for this post type
 * @param  integer $order     admin menu order / default is 5 -- right below posts
 * @param  string  $icon      custom dash icon / default is post -- same as posts
 * @return register             return the post type register function
 */
function hair_make_cpt($plural, $singlular, $slug, $url, $order = 5, $icon = 'dashicons-admin-post')
{
    // creating (registering) the custom type
    $labels = array(
        'name'               => _x($plural, 'post type general name', 'hair'), //This is the title of the group
        'singular_name'      => _x($singlular, 'post type singular name', 'hair'), //This is the individual type
        'add_new'            => _x('Add New', 'custom post type item', 'hair'), //The add new menu item
        'add_new_item'       => __('Add New ' . $singlular, 'hair'), // Add new Display Title
        'all_items'          => __('All ' . $plural, 'hair'), // The All Items in the Menu
        'edit'               => __('Edit', 'hair'), //Edit Dialog
        'edit_item'          => __('Edit ' . $singlular, 'hair'), //Edit Display Title
        'new_item'           => __('New ' . $singlular, 'hair'), //New Display Title
        'view_item'          => __('View ' . $singlular, 'hair'), //View Display Title
        'search_items'       => __('Search ' . $singlular, 'hair'), //Search Custom Type Title
        'not_found'          => __('Nothing found in the Database.', 'hair'), //This displays if there are no entries yet
        'not_found_in_trash' => __('Nothing found in Trash', 'hair'), //This displays if there is nothing in the trash
        'parent_item_colon'  => '',
    );
    $args = array(
        'labels'              => $labels,
        'description'         => __('This is an example custom post type.', 'hair'), //Custom Type Description
        'public'              => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_ui'             => true,
        'has_archive'         => true,
        'query_var'           => true,
        'show_in_vav_menus'   => true,
        'menu_position'       => $order, //This is what order you want it to appear in on the left hand side menu
        'rewrite'             => array( 'slug' => $url, 'with_front'=>false),
        'capability_type'     => 'page',
        'hierachical'         => false,
        'menu_icon'           => $icon,
        // the next one is important, it tells what's enabled in the post editor
        'supports'            => array('title', 'editor', 'thumbnail'),
    );
    return register_post_type($slug, $args); // (http://codex.wordpress.org/Function_Reference/register_post_type)
}

// Run the post type functions
// Return the register post types action
function hair_create_cpt()
{
    //hair_make_cpt('Books', 'Book', 'book', 'books', 6, 'dashicons-book');
    //hair_make_cpt('Music', 'Music', 'music', 'music', 6, 'dashicons-format-audio');
    //hair_make_cpt('Objects', 'Object', 'object', 'objects', 6, 'dashicons-art');
    hair_make_cpt('Events', 'Event', 'event', 'events', 6, 'dashicons-calendar');
}
// Register the post types on init!
add_action( 'init', 'hair_create_cpt', 0 );

// Run the taxonomy function
// Return the register taxonomy action
function hair_create_taxonomies()
{
    //hair_make_tax('Category', 'Category', 'object_category', 'object_categories', array('book', 'object', 'music', 'product'));
    hair_make_tax('Authors', 'Author', 'author', 'authors', array('book', 'object', 'music', 'event', 'product'));
    hair_make_tax('Availability', 'Availability', 'object_availability', 'availability', array('book', 'object', 'music', 'product'));
    hair_make_tax('Category', 'Category', 'event_category', 'events', array('event'));
}

// Register the taxonomies on init!
add_action( 'init', 'hair_create_taxonomies', 0 );
