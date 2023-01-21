<!-- creating single.php file automatically gets selected for rendering single posts -->

<?php
get_header();

while (have_posts()) {
    the_post(); 
    pageBanner();  
    ?>
   
   <div class="container container--narrow page-section">
     
   <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <!-- Retrieves the permalink for a post type archive.  -->
            <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>">
                <i class="fa fa-home" aria-hidden="true"></i>
                All Programs
            </a>
            <span class="metabox__main">
              <?php the_title();?>
            </span>
        </p>
    </div>

     <div class="generic-content">
        <?php the_field('main_body_content');?>
     </div>

     <?php 


$relatedProfessors = new WP_Query(array(
  'posts_per_page' => -1,
  'post_type' => 'professor',
  'orderby' => 'title',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      //This filter is saying: if the array of related programs contains the ID number of the current program posts
        'key' => 'related_programs',
        // LIKE means Contains
        'compare' => 'LIKE',
        //When Wordpress saves the related_programs array into its database, it first has to serialize the array
        //Thats why we will need to run the get_the_ID() function inside quotations for converting the output into string.
        'value' => '"' . get_the_ID() . '"'
      )
  )
));

if ($relatedProfessors->have_posts()){

echo '<hr>';
echo '<h2 class="headline headline--medium"> ' . get_the_title() . ' Professors </h2>';

echo '<ul class="professor-cards">';
while($relatedProfessors->have_posts() ){ 
  $relatedProfessors->the_post(); ?>
   <li class="professor-card__list-item">
     <a class="professor-card" href="<?php the_permalink();?>">
     <!-- the_post_thumbnail_url(); This function loads the Thumbnail Images for posts and the links to the main post where the thumbnail exists-->
      <img src="<?php the_post_thumbnail_url('professorLandscape');?>" alt="" class="professor-card__image">
      <span class="professor-card__name"><?php the_title();?></span>
     </a>
   </li>
<?php
 }
 echo '</ul>';
}

// After looping through a separate query, this function restores the $post global to the current post in the main query.

wp_reset_postdata();

        $today = date('Ymd');
        $homepageEvents = new WP_Query(array(
          'posts_per_page' => 2,
          'post_type' => 'event',
          'meta_key' => 'event_date',
          'orderby' => 'meta_value_num',
          'order' => 'ASC',
          'meta_query' => array(
            array(
              'key' => 'event_date',
              'compare' => '>=',
              'value' => $today,
              'type' => 'numeric'
            ),
            
            array(
              //This filter is saying: if the array of related programs contains the ID number of the current program posts
                'key' => 'related_programs',
                // LIKE means Contains
                'compare' => 'LIKE',
                //When Wordpress saves the related_programs array into its database, it first has to serialize the array
                //Thats why we will need to run the get_the_ID() function inside quotations for converting the output into string.
                'value' => '"' . get_the_ID() . '"'
              )
          )
        ));
        
        if ($homepageEvents->have_posts()){
        
        echo '<hr>';
        echo '<h2 class="headline headline--medium"> Upcoming ' . get_the_title() . ' Events </h2>';
        while($homepageEvents->have_posts() ){ 
          $homepageEvents->the_post();     
          get_template_part('template-parts/content-event');   
         }
        }
      ?>

   </div>
<?php
}

get_footer();
?>