<?php
/**
 * The template for displaying Search Results pages.
 */
get_header(); ?>

    <div id="content" class="clearfix">
        
        <div id="main" class="clearfix" role="main">

			<?php if ( have_posts() ) : ?>
            
            <div id="post-boxes-wrap" class="clearfix">

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'magazino' ), '<span class="colortxt">' . get_search_query() . '</span>' ); ?></h1>
                    <div class="grnbar"></div>
				</header>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content-archive', 'search' ); ?>

				<?php endwhile; ?>

				<?php if (function_exists("magazino_pagination")) {
							magazino_pagination(); 
				} elseif (function_exists("magazino_content_nav")) { 
							magazino_content_nav( 'nav-below' );
				}?>
                
            </div>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'magazino' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content post_content">
						<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'magazino' ); ?></p>
						<?php get_search_form(); ?>
                        
                        <p><?php _e('Or you can try these links below.', 'magazino'); ?></p>
                        
                        <?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<div class="widget">
						<h2 class="widget-title"><?php _e( 'Most Used Categories', 'magazino' ); ?></h2>
						<ul>
						<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
						</ul>
					</div>

					<?php
					/* translators: %1$s: smilie */
					$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'magazino' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

        </div> <!-- end #main -->

        <?php get_sidebar(); ?>

    </div> <!-- end #content -->
        
<?php get_footer(); ?>