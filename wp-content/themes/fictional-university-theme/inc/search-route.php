<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
    // This is a built-in Wordpress function.
    // First Argument - namespace
    // Second Argument - route
    // Third Argument - Array that describes what should happen when someone visits the URL
    register_rest_route(
        'university/v1',
        'search',
        array(
            // This almost works all the time 
            // 'methods' => 'GET'
            // But, this is the best practise
            // This is basically a WP constant that substitues for GET request, but depending on the web host being used, it might use a slightly different value instead
            'methods' => WP_REST_SERVER::READABLE,
            'callback' => 'universitySearchResults'
        )
    );
}

//Create custom JSON data with the help of WP_Query Object (Custom Queries)
// This will output an array of objects

// function universitySearchResults()
// {
//     $professors = new WP_Query(
//         array(
//             'post_type' => 'professor'
//         )
//     );

//     return $professors->posts;
// }

// This is how we can manipulate the type of data we would like to show

// Pass a parameter called data, but you can call it whatever you want . 
// $data is an array WordPress puts together, and within this array we can access any parameters passed to the API URL
function universitySearchResults($data)
{
    $mainQuery = new WP_Query(
        array(
            // This is how you query multiple post types 
            //set the post_type to equal an array, list out an array of post types you want to return 
            'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
            // lowercase s stands for search, enables the search functionality
            // 'term' is basically this part of the search query URL, you can name it anything: 
            // http://fictional-university.local/wp-json/university/v1/search?term=searchterm
            // sanitize_text_field is built-in Wordpress function, Sanitizes a string from user input or from the database. It helps prevent harmful user inputs.
            's' => sanitize_text_field($data['term'])
        )
    );

    //This is the array that we will populate by looping. Inside this associative array we will separately store each post type retuns 
    $results = array(
       'generalInfo' => array(),
       'professors' => array(),
       'programs' => array(),
       'events' => array(),
       'campuses' => array()
    );

    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();
        // This is built-in PHP function
        // It takes in two arguments
        // 1st - the array you want to add on to, in this case $professorResults
        // 2nd - The data you want to show
        // The array_push() function inserts one or more elements to the end of an array. In this case, we are pushing the array inside $results' sub arrays 
        if (get_post_type() == 'post' or get_post_type() == 'page') {
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'postType' => get_post_type(),
                'authorName' => get_the_author()
            )
            );
        }

        if (get_post_type() == 'professor') {
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            )
            );
        }

        if (get_post_type() == 'program') {
            array_push($results['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            )
            );
        }

        if (get_post_type() == 'campus') {
            array_push($results['campuses'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            )
            );
        }

        if (get_post_type() == 'event') {
            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            )
            );
        }
    }

    return $results;
}