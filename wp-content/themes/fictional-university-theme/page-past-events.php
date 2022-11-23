<?php

get_header(); 
pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'Recap of our past events.'
  ))
?>

<div class="container container--narrow page-section">
    <?php
$today = date('Ymd');
  $pastEvents = new WP_Query(array(
    //get_query_var() function can be used to get all sorts of information from the URL(in this current page URL).
    //First Argument - echo posts based on the page ID(paged in this case).
    //Second Argument - pass a number as argument, the number will be used if WordPress can not find the data dynamically  
    'paged' => get_query_var('paged', 1),
    'post_type' => 'event',
    'meta_key' => 'event_date',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => array(
            array(
            'key' => 'event_date',
            'compare' => '<',
            'value' => $today,
        'type' => 'numeric'
    )
      )
    ));

    while ($pastEvents->have_posts()) {
    $pastEvents->the_post(); 
    get_template_part('template-parts/content-event');
   }
// This function creates pagination feature
// Need to pass array values inside the parameter if the pagination function is being invoked for custom posts.
echo paginate_links(array(
  'total' => $pastEvents->max_num_pages
));
?>
</div>

<?php get_footer();

?>