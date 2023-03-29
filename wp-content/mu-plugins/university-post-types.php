<?php function university_post_types()
{
    // Event Post Type

    // register_post_type(); is a built-in Wordpress function
    // Registers a post type
    // First argument - pass the preferred name for the custom post type, Second argument - asociative array describing the post type.
    register_post_type('event', array(
        // By default the capability type is set to 'post'

        // We basically just wanna tell the event post type that it should not behave like a blog post for user permissions and capabilities.(by default WordPress treats custom post types as a generic posts)
        // Set the capability_type to something unique such as event, then explicitly grant these custom capability permissions to each roles as we see fit.  
        'capability_type' =>'event',
        //Without this line of code we would need to create custom logic for when the above capabilities should be required
        'map_meta_cap' => true,
        // this creates an endpoint for the custom post type
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ),
        'menu_icon' => 'dashicons-calendar'
    ));

        // Program Post Type
        register_post_type('program', array(
            // Removing 'editor' parameter will disable the default body content editor.
            'supports' => array('title'),
            'rewrite' => array('slug' => 'programs'),
            'has_archive' => true,
            'public' => true,
            'show_in_rest' => true,
            'labels' => array(
                'name' => 'Programs',
                'add_new_item' => 'Add New Program',
                'edit_item' => 'Edit Program',
                'all_items' => 'All Programs',
                'singular_name' => 'Program'
            ),
            'menu_icon' => 'dashicons-awards'
        ));
        
        // Professor Post Type
        register_post_type('professor', array(
            'supports' => array('title', 'editor', 'thumbnail'),
            'public' => true,
            'show_in_rest' => true,
            'labels' => array(
                'name' => 'Professors',
                'add_new_item' => 'Add New Professor',
                'edit_item' => 'Edit Professor',
                'all_items' => 'All Professors',
                'singular_name' => 'Professor'
            ),
            'menu_icon' => 'dashicons-welcome-learn-more'
        ));

        //Helpful Note: By default Custom Post types inherit their permissions from blog post type 

        // Note Post Type
        register_post_type('note', array(
            // Set the capability_type to something unique such as event, then explicitly grant these custom capability permissions to each roles as we see fit.  
            'capability_type' => 'note',
            //Without this line of code we would need to create custom logic for when the above capabilities should be required
            'map_meta_cap' => true,
            'supports' => array('title', 'editor'),
            // setting public to false will make the notes private and specific to each user accounts(fyi we do not want notes to show up in public queries or search results)
            //However setting public to false will also hide the posts in the admin dashboard    
            'public' => false,
            //Setting show_ui to true will show the 'note' post type in the admin dashboard(need to stay signed in as Admin)
            'show_ui' => true,
            'show_in_rest' => true,
            'labels' => array(
                'name' => 'Notes',
                'add_new_item' => 'Add New Note',
                'edit_item' => 'Edit Note',
                'all_items' => 'All Notes',
                'singular_name' => 'Note'
            ),
            'menu_icon' => 'dashicons-welcome-write-blog'
        ));
}

// Run the init hook
// Fires after WordPress has finished loading but before any headers are sent.
add_action('init', 'university_post_types');