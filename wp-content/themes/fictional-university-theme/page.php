<!-- creating page.php file automatically gets selected for displaying new pages -->

<?php
get_header();

while (have_posts()) {
    the_post(); ?>
<div class="page-banner">
    <div class="page-banner__bg-image"
        style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">
            <?php the_title(); ?>
        </h1>
        <div class="page-banner__intro">
            <p>DON'T FORGET TO REPLACE ME LATER.</p>
        </div>
    </div>
</div>

<div class="container container--narrow page-section">
    <?php
    // Get the post/page ID 
    // echo get_the_ID();


    // This code basically runs two functions. wp_get_post_parent_id(get_the_ID())checks the ID of the parent page.
    // echo wp_get_post_parent_id(get_the_ID());

    $theParent = wp_get_post_parent_id(get_the_ID());
    if ($theParent) {
    ?>
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
            <!-- Gets permalink using ID -->
            <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>">
                <i class="fa fa-home" aria-hidden="true"></i>
                Back to
                <!-- Gets the title based on the ID -->
                <?php echo get_the_title($theParent); ?>
            </a>
            <span class="metabox__main">
                <!-- Dynamic Page Title Function -->
                <?php the_title(); ?>
            </span>
        </p>
    </div>
    <?php
    }
    ?>

   <?php 
   //get_pages() function returns all the pages in memory
    $testArray = get_pages(array(
        'child_of' => get_the_ID()
    ));

    if ($theParent or $testArray) { ?>
    <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent);?>"><?php echo get_the_title($theParent);?></a></h2>
        <ul class="min-list">
            
            <!-- What is an Associative Array? 
              Answer: 

              Normal Array: 

              $animals = array('cat', 'dog', 'bird');

              echo $animals[0]

              Associative Array:

              $animalSounds = array(
                'cat' => 'meow',
                'dog' => 'bark',
                'bird' => 'chew'
              );

              echo $animalSounds[dog]
            -->

            <!-- This function lists every page on the website -->
            <?php 
            //  wp_list_pages();
            ?>
            <!-- This condition checks if the child page has any parent page / also checks if the parent page has any children -->
            <?php
              if($theParent){
                $findChildrenOf = $theParent;
              } else {
                $findChildrenOf = get_the_ID();
              }
              // Show Menu of Child Page Links using wp_list_pages(); function and Associative Arrays 
              wp_list_pages(array(
                'title_li' => NULL,
                'child_of' => $findChildrenOf,
                // Enables the option for chaging the order of page listings
                'sort_column' => 'menu_order'
              )); 
            ?>
        </ul>
    </div>
   <?php } ?>

    <div class="generic-content">
        <?php the_content(); ?>
    </div>
</div>
<?php
}

get_footer();
?>