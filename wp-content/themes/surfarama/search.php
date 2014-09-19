<?php
/**
 * The template for displaying Search Results pages.
 */
get_header(); ?>

    <div id="content" class="clearfix">
        
        <div id="main" class="clearfix" role="main">

			<?php if ( have_posts() ) : ?>
				
				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'surfarama' ), '<span class="colortxt">' . get_search_query() . '</span>' ); ?></h1>
				</header>
                <div id="grid-wrap" class="clearfix">
                <?php $surfarama_counter = 1; ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
                	<?php
						$itm_class = '';
						if ( is_home() || is_archive() ) {
							if ( $surfarama_counter == 1 && !$wp_query->query_vars['paged'] ) {
								if ( is_sticky() ) {
									$itm_class = 'featured';
								} else {
									$itm_class = 'latest';
								}
							}
						}
						?>
					<div class="grid-box <?php echo $itm_class; ?>">
					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>
                    </div>
                    <?php $surfarama_counter++; ?>
				<?php endwhile; ?>
				</div>
				<?php if (function_exists("surfarama_pagination")) {
							surfarama_pagination(); 
				} elseif (function_exists("surfarama_content_nav")) { 
							surfarama_content_nav( 'nav-below' );
				}?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'surfarama' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content post_content">
						<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'surfarama' ); ?></p>
						<?php get_search_form(); ?>
                        
                        <p><?php _e('Or you can try these links below.', 'surfarama'); ?></p>
                        
                        <?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<div class="widget">
						<h2 class="widget-title"><?php _e( 'Most Used Categories', 'surfarama' ); ?></h2>
						<ul>
						<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
						</ul>
					</div>

					<?php
					/* translators: %1$s: smilie */
					$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'surfarama' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

        </div> <!-- end #main -->

        <?php get_sidebar('archive'); ?>

    </div> <!-- end #content -->
        
<?php get_footer(); ?>