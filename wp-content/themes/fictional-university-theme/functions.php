<!--Using the add_action function WP allow's us to pass instruction; 
    the first argument tells WP what type of function we are giving it,
    the second argument takes in the type of function we want to run
    we will need to create the custom function.
     
    wp_enqueue_scripts instructs WP to load CSS and JS files
    university_files is the function we have created.

    wp_enqueue_style - first argument takes in the CSS file name , second argument takes in the file location.

    get_stylesheet_uri function automatically loads the style.css file
-->

<?php
function university_files()
{
    wp_enqueue_style('university_main_styles', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'university_files');
