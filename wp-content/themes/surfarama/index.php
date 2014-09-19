<?php get_header(); ?>

    <div id="content" class="clearfix">
        
        <div id="main" class="clearfix" role="main">
              

			<?php if ( have_posts() ) : ?>
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
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'surfarama' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

        </div> <!-- end #main -->

        <?php get_sidebar('home'); ?>

    </div> <!-- end #content -->
        
<?php get_footer(); ?>