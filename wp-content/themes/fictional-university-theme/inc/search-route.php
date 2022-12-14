<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
    // This is a built-in Wordpress function
    // First Argument - namespace
    // Second Argument - route
    // Third Argument - Array that describes what should happen when someone visits the URL
    register_rest_route('university/v1', 'search', array(
       // This almost works all the time 
       // 'methods' => 'GET'
       // But, this is the best practise
       // This is basically a WP constant that substitues for GET request, but depending on the web host being used, it might use a slightly different value instead
       'methods' => WP_REST_SERVER::READABLE,
       'callback' => 'universitySearchResults'
    ));
}

function universitySearchResults(){
    return 'Congratulations, you created a route';
}