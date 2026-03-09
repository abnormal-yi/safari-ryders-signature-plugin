<?php
/**
 * Template for displaying single kilimanjaro routes.
 */
get_header();
?>
<main id="primary" class="site-main">
    <div class="ryder-kili-container" style="width: 100%; max-width: 100%; margin: 0; padding: 0;">
        <?php
        while ( have_posts() ) :
            the_post();
            echo do_shortcode( '[ryder_kilimanjaro]' );
        endwhile;
        ?>
    </div>
</main>
<?php
get_footer();
