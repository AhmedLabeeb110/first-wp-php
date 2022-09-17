<!-- While loop with special WP function called have_posts / the_post -->
<!-- the_permalink
the_title
the_content -->

<!-- <?php
while (have_posts()) {
    the_post(); ?>
<h2>
    <a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
    </a>
    <?the_content();?>
    <hr>
</h2>
<?php
}
?> -->

<!--Code renders from here-->

<!-- with special WP function called get_header/get_footer it is possible to display header/footer in every pages/posts of Wordpress -->
<!--Same as above, just a bit of change in the syntax-->

<?php get_header();

while (have_posts()) {
    the_post(); ?>
<h2>
    <a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
    </a>
    <?the_content();?>
    <hr>
</h2>
<?php
}
get_footer();
?>
