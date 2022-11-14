<!-- creating single.php file automatically gets selected for rendering single posts -->

<?php
get_header();

while (have_posts()) {
    the_post(); ?>
   
   <div class="page-banner">

   <!-- Create a variable called, run the get_field function inside it, 
        and pass the custom field name as an argument that you want to show on the front-end
        $pageBannerImage = get_field('page_banner_background_image');

        then echo the $pageBannerImage['url'](this is echoed out as array - url is one of the array values, the url will give us a path to the image)
        
        To echo a specific sized image: $pageBannerImage['sizes']['pageBanner']
    -->
    <div class="page-banner__bg-image"
        style="background-image: url(<?php $pageBannerImage = get_field('page_banner_background_image');
        echo $pageBannerImage['sizes']['pageBanner']
        ?>);">
    </div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">
            <?php the_title(); ?>
        </h1>
        <div class="page-banner__intro">
            <p><?php the_field('page_banner_subtitle')?></p>
        </div>
    </div>
   </div>
   <div class="container container--narrow page-section">
     
   

     <div class="generic-content">
        <div class="row group">

          <div class="one-third">
            <!-- the_post_thumbnail(); function creates and HTML Image Tag and pulls in the featured image -->
            <!-- Pass in the custom image size Name as an argument for loading puposes -->
            <?php the_post_thumbnail('professorLandscape');?>
          </div>

          <div class="two-thirds">
            <?php the_content();?>
          </div>

        </div>
     </div>

     <!-- Showing related fields on the frontend from ACF  -->
     <?php 
       $relatedPrograms = get_field('related_programs');
       // The print_r() function prints the information about a variable in a more human-readable way. Need to pass variable name as argument for output
       
      if ($relatedPrograms) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
        echo '<ul class="link-list min-list">';
        foreach($relatedPrograms as $program){ ?>
         <!-- the_title() function will not work in this case, it only works inside the main WordPress loop.
         
         Pass a specific post ID that you want to render or do the best pratise of passing POST Object as an argument.
         echo get_the_title($program); -->
          <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
         <?php
        }
        echo '</ul>';
      }
      
     ?>
   </div>
<?php
}

get_footer();
?>