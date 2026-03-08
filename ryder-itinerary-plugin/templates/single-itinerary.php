<?php
/**
 * Template for displaying single itineraries.
 */
get_header();
?>
<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();
        echo do_shortcode( '[ryder_itinerary]' );
    endwhile;
    ?>
</main>
<?php
get_footer();
