<?php function university_post_types()
{
    // register_post_type(); is a built-in Wordpress function
    // Registers a post type
    // First argument - pass the preferred name for the custom post type, Second argument - asociative array describing the post type.
    register_post_type('event', array(
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ),
        'menu_icon' => 'dashicons-calendar'
    ));
}

// Run the init hook
// Fires after WordPress has finished loading but before any headers are sent.
add_action('init', 'university_post_types');