<?php
/**
 * Template Name: Full-width, with Widgets
 * Description: A full-width template with widgets
 */
get_header(); ?>

    <div id="content" class="clearfix full-width-content">
        
        <div id="main" class="clearfix" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>

			</div>
            
         <?php get_sidebar('full');  ?>
         
		</div>

<?php get_footer(); ?>