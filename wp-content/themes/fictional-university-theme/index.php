<!-- While loop with special WP function called have_posts / the_post -->
<!-- the_permalink
the_title
the_content -->

<?php
while (have_posts()) {
    the_post(); ?>
<h2>
    <a href="<?php the_permalink();?>">
        <?php the_title(); ?>
    </a>
    <?the_content();?>
    <hr>
</h2>
<?php
}
?>