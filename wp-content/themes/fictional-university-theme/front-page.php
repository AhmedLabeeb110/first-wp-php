<?php get_header(); ?>
<div class="page-banner">
  <!-- How to import images in WordPress -->
  <div class="page-banner__bg-image"
    style="background-image: url(<?php echo get_theme_file_uri('images/library-hero.jpg')?>)"></div>
  <div class="page-banner__content container t-center c-white">
    <h1 class="headline headline--large">Welcome!</h1>
    <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
    <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re
      interested in?</h3>
    <a href="#" class="btn btn--large btn--blue">Find Your Major</a>
  </div>
</div>

<div class="full-width-split group">
  <div class="full-width-split__one">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
      <!-- Setting -1 as a value tells Wordpress to echo or return all the posts that meet the conditions -->
      <!-- mata_value is all the extra or custom data associated with a post  
           meta_key is used to access the custom value of a targeted custom field, in this case we need to access the number
           so we will use meta_key_num
      -->
      <?php 
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
            )
          )
        ));

        while($homepageEvents->have_posts() ){ 
          $homepageEvents->the_post(); ?>
      <div class="event-summary">
        <a class="event-summary__date t-center" href="#">
          <!-- This function comes from the ACF(Advanced Custom Fields) plugin 
                     the_field('event_date');
                     get_field() as well.
                -->
          <span class="event-summary__month">
            <?php 
                  $eventDate = new DateTime(get_field('event_date'));
                  echo $eventDate->format('M')
                ?>
          </span>
          <span class="event-summary__day">
            <?php echo $eventDate->format('d') ?>
          </span>
        </a>
        <div class="event-summary__content">
          <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink();?>">
              <?php the_title();?>
            </a></h5>
          <p>
            <?php if(has_excerpt()){
                    echo get_the_excerpt();
                     } else {
                       echo wp_trim_words(get_the_content(), 18);
                     }
                  ?>
            <a href="<?php the_permalink();?>" class="nu gray">Learn more</a>
          </p>
        </div>
      </div>
      <?php
         }
      ?>

      <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event');?>"
          class="btn btn--blue">View All Events</a></p>
    </div>
  </div>
  <div class="full-width-split__two">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
      <?php
// To create a custom Wordpress query first create a variable, create a new instance of WP_Query(); function
// Pass an array(associative arguments) of arguments inside the WP_Query() for sending queries

$homepagePosts = new WP_Query(array(
  'posts_per_page' => 2
));

/*For completing the custom queries look inside the custom object($homepagePosts), then access have_posts() 
 from the custom object and pass it inside the parentheses;
 
 Then access the_post(); from the custom object
 */

while ($homepagePosts->have_posts()) {
  $homepagePosts->the_post(); ?>
      <div class="event-summary">
        <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
          <span class="event-summary__month">
            <?php the_time('M')?>
          </span>
          <span class="event-summary__day">
            <?php the_time('d')?>
          </span>
        </a>
        <div class="event-summary__content">
          <h5 class="event-summary__title headline headline--tiny">
            <!-- This function is used to trip content for preview purposes. -->
            <a href="<?php the_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </h5>
          <p>
            <!-- First way -->
            <?php 
            // if(has_excerpt()){
            //  the_excerpt();
            // } else {
            //   echo wp_trim_words(get_the_content(), 18);
            // }
            ?>
            <!-- Second way -->
            <?php 
            if(has_excerpt()){
             echo get_the_excerpt();
            } else {
              echo wp_trim_words(get_the_content(), 18);
            }
            ?>

            <a href="<?php the_permalink(); ?>" class="nu gray"></a>
          </p>
        </div>
      </div>
      <?php
       }
      // Always run this function after custom queries are made. It cleans up custom queries and resets all the queries back to their default states. Running this function helps avoid conflicts.
      wp_reset_postdata();
      ?>
      <!-- site_url(); fucntion gets the main website URL, but we can passdown a URL path of our choice . -->
      <p class="t-center no-margin"><a href="<?php echo site_url('/blog');?>" class="btn btn--yellow">View All Blog
          Posts</a></p>
    </div>
  </div>
</div>

<div class="hero-slider">
  <div data-glide-el="track" class="glide__track">
    <div class="glide__slides">
      <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('images/bus.jpg')?>)">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Transportation</h2>
            <p class="t-center">All students have free unlimited bus fare.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="hero-slider__slide"
        style="background-image: url(<?php echo get_theme_file_uri('images/apples.jpg')?>)">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">An Apple a Day</h2>
            <p class="t-center">Our dentistry program recommends eating apples.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="hero-slider__slide"
        style="background-image: url(<?php echo get_theme_file_uri('images/bread.jpg')?>)">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Food</h2>
            <p class="t-center">Fictional University offers lunch plans for those in need.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
  </div>
</div>

<?php get_footer(); ?>