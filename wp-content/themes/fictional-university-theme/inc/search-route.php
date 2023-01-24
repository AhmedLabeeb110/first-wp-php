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
            array_push(
                $results['generalInfo'],
                array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'postType' => get_post_type(),
                    'authorName' => get_the_author()
                )
            );
        }

        if (get_post_type() == 'professor') {
            array_push(
                $results['professors'],
                array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    // Returns the post thumbnail URL.
                    // First Argument: The post you want to show, passing 0 will get the image of the current post
                    // Second Argument: The size of image you want to show
                    'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
                )
            );
        }

        if (get_post_type() == 'program') {
            array_push(
                $results['programs'],
                array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'id' => get_the_id()
                )
            );
        }

        if (get_post_type() == 'campus') {
            array_push(
                $results['campuses'],
                array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
                )
            );
        }

        if (get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            $description = null;
            if (has_excerpt()) {
                $description = get_the_excerpt();
            } else {
                $description = wp_trim_words(get_the_content(), 18);
            }
            ;
            array_push(
                $results['events'],
                array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'month' => $eventDate->format('M'),
                    'day' => $eventDate->format('d'),
                    'description' => $description
                )
            );
        }
    }

    if ($results['programs']) {
        // This makes sure that the code below does not require all the conditions to meet and checks if any of the conditions are met  
        // 'relation' => 'OR',
        $programsMetaQuery = array('relation' => 'OR');

        foreach ($results['programs'] as $item) {
            array_push($programsMetaQuery, array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . $item['id'] . '"'
            )
            );
        }

        $programRelationshipQuery = new WP_Query(
            array(
                'post_type' => array('professor', 'event'),
                'meta_query' => $programsMetaQuery
            )
        );

        while ($programRelationshipQuery->have_posts()) {
            $programRelationshipQuery->the_post();

            if (get_post_type() == 'event') {
                $eventDate = new DateTime(get_field('event_date'));
                $description = null;
                if (has_excerpt()) {
                    $description = get_the_excerpt();
                } else {
                    $description = wp_trim_words(get_the_content(), 18);
                }
                ;
                array_push(
                    $results['events'],
                    array(
                        'title' => get_the_title(),
                        'permalink' => get_the_permalink(),
                        'month' => $eventDate->format('M'),
                        'day' => $eventDate->format('d'),
                        'description' => $description
                    )
                );
            }
                if (get_post_type() == 'professor') {
                    array_push(
                        $results['professors'],
                        array(
                            'title' => get_the_title(),
                            'permalink' => get_the_permalink(),
                            // Returns the post thumbnail URL.
                            // First Argument: The post you want to show, passing 0 will get the image of the current post
                            // Second Argument: The size of image you want to show
                            'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
                        )
                    );
                }
            }

            //array_unique() is a default PHP function
            //This function takes in two arguments
            //For the first argument pass the array you want to work with.
            //For the second argument pass a filter argument like the code below
            $results['professors'] = array_unique($results['professors'], SORT_REGULAR);
            // The array_values() is an inbuilt PHP function is used to get an array of values from another array that may contain key-value pairs or just values.
            // The function creates another array where it stores all the values and by default assigns numerical keys to the values.Nov 30, 2021
        $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));

        }

        return $results;
    }
