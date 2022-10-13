<!--Using the add_action function WP allow's us to pass instruction; 
    the first argument tells WP what type of function we are giving it,
    the second argument takes in the type of function we want to run
    we will need to create the custom function.
     
    wp_enqueue_scripts instructs WP to load CSS and JS files
    university_files is the function we have created.

    wp_enqueue_style - first argument takes in the CSS file name , second argument takes in the file location.

    get_stylesheet_uri function automatically loads the style.css file

    get_theme_file_uri function allows loading custom CSS files
-->

<?php
function university_files()
{
    // wp_enqueue_style('university_main_styles', get_stylesheet_uri());
    // loading JS file using wp_enqueue_script function
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    // this is the process of loading google fonts
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    // this is the process of loading font awesome
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
}

add_action('wp_enqueue_scripts', 'university_files');

//Must be called in the theme’s functions.php file to work.
//If attached to a hook, it must be ‘after_setup_theme’.
//The ‘init’ hook may be too late for some features.

function university_features()
{
    // Shows page name on tabs
    add_theme_support('title-tag');
}

// after_setup_theme, This hook is called during each page load, after the theme is initialized. It is generally used to perform basic setup, registration, and init actions for a theme.

add_action('after_setup_theme', 'university_features');


function university_post_types()
{
    // register_post_type(); is a built-in Wordpress function
    // Registers a post type.
    // First argument - pass the preferred name for the custom post type, Second argument - asociative array describing the post type.
    register_post_type('event', array(
        'public' => true,
        'labels' => array(
            'name' => 'Events'
        ),
        'menu_icon' => 'dashicons-calendar'
    ));
}

// Run the init hook
// Fires after WordPress has finished loading but before any headers are sent.
add_action('init', 'university_post_types');