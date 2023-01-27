<!-- creating page.php file automatically gets selected for displaying new pages -->

<?php
get_header();

while (have_posts()) {
    the_post(); 
    //This function comes from the functions.php, this function outputs the page banner.
    pageBanner(array(
        // Can manipulate the default fields like this.
        'title' => get_the_title(),
        // 'photo' => 'https://images.unsplash.com/photo-1493246507139-91e8fad9978e?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80'
        // 'subtitle' => 'The subtitle goes here'
    ));
    ?>  
 

<div class="container container--narrow page-section">
    <?php 
    // Get the post/page ID 
    // echo get_the_ID() ;


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

   <!-- It is possible to search through WP API enpoints with the help of forms and inputs  -->
    <div class="generic-content">
        <!-- site_url(); Retrieves the URL for the current site where WordPress 
        application files (e.g. wp-blog-header.php or the wp-admin/ folder) are accessible. 
    
        passing '/' as parameter will echo the website url as the Action URL
        -->

        <!-- Quick Security Tip: 
        esc_url() Checks and cleans a URL.

        For manually outputting a URL from the we should the function in another function called esc_url()

        http://fictional-university.local/?s=math
        -->
        <form class="search-form" method="get" action="<?php echo esc_url(site_url('/'));?>">
        <label for="s" class="headline headline--medium">Perform a New Search</label>
        <div class="search-form-row">
        <input placeholder="What are you looking for" class="s" id="s" type="search" name="s"></input>
        <input class="search-submit" type="submit" value="Search"></input>
        </div>
        </form>
    </div> 
</div>
<?php
}

get_footer();
?>