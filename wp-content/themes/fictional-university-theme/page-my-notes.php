<?php
 
 // This statement checks if a user is logged in or not, the page will load 
//  if the user is logged in otherwise the user will be redirected to any page 
// we will set the redirect to
if (!is_user_logged_in()){
    wp_redirect(esc_url(site_url()));
    exit;
}

get_header();

while (have_posts()) {
    the_post();
    //This function comes from the functions.php, this function outputs the page banner.
    pageBanner();
    ?>

    <div class="container container--narrow page-section">
        <ul class="min-list link-list" id="my-notes">
           <?php 
             $userNotes = new WP_Query(array(
                'post_type' => 'note',
                'posts_per_page' => -1,
                //This is the line that makes notes user specific
                'author' => get_current_user_id()
             ));

             while($userNotes->have_posts()){
                $userNotes->the_post(); ?>
                <li>
                    <!-- 
                        Escaping for HTML attributes. 
                        esc_attr()
                    -->
                    <input class="note-title-field" value="<?php echo esc_attr(get_the_title()); ?>">
                    <!-- 
                        Properly strips all HTML tags including script and style 
                        wp_strip_all_tags()
                    -->
                    <span class="edit-note"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                    <span class="delete-note"> <i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                    <textarea class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content()))?></textarea>
                </li>
            <?php
             }
           ?>
        </ul>
    </div>

<?php
}

get_footer();
?>