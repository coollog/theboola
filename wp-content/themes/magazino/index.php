<?php get_header(); ?>

    <div id="content" class="clearfix">
        
        <div id="main" class="clearfix" role="main">
        	
            <div id="slide-wrap">
            
			  <?php 
                $args = array(
                    'posts_per_page' => 10,
					'post_status' => 'publish',
                    'post__in' => get_option("sticky_posts")
                );
                $fPosts = new WP_Query( $args );
				$countPosts = $fPosts->found_posts;
              ?>
    
                <?php if ( $fPosts->have_posts() ) : ?>
                  
                  <?php if ($countPosts > 1) : ?>
                  <div id="load-cycle"></div>
                  <div class="cycle-slideshow" <?php 
				  	if ( get_theme_mod('magazino_slider_effect') ) {
						echo 'data-cycle-fx="' . wp_kses_post( get_theme_mod('magazino_slider_effect') ) . '" data-cycle-tile-count="10"';
					} else {
						echo 'data-cycle-fx="scrollHorz"';
					}
				  ?> data-cycle-slides="> div.slides" <?php
                  	if ( get_theme_mod('magazino_slider_timeout') ) {
						$slider_timeout = wp_kses_post( get_theme_mod('magazino_slider_timeout') );
						if ( $slider_timeout != 0 || $slider_timeout != '' ) {
							echo 'data-cycle-timeout="' . $slider_timeout . '000" data-cycle-pause-on-hover="true"';
						} else {
							echo 'data-cycle-timeout="0"';
						}
					} else {
						echo 'data-cycle-timeout="0"';
					}
				  ?> data-cycle-prev="#sliderprev" data-cycle-next="#slidernext">
                  	<?php if ( get_theme_mod('magazino_slider_pager') ) : ?>
                  	<div class="cycle-pager"></div>
                    <?php endif; ?>
                    <?php /* Start the Loop */ ?>
                    <?php while ( $fPosts->have_posts() ) : $fPosts->the_post(); ?>
                    
                    <div class="slides">
                      <div id="post-<?php the_ID(); ?>" <?php post_class('post-theme'); ?>>
                         <?php if ( has_post_thumbnail()) : ?>
                            <div class="slide-thumb"><?php the_post_thumbnail( array(1000, 640) ); ?></div>
                         <?php else : ?>
                         
							<?php $postimgs =& get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
                            if ( !empty($postimgs) ) :
                                $firstimg = array_shift( $postimgs );
                                $my_image = wp_get_attachment_image( $firstimg->ID, array( 1000, 640 ), false );
                            ?>
                            <div class="slide-thumb"><?php echo $my_image; ?></div>
                            
                            <?php else : ?>
                         	
                            <div class="slide-noimg"><?php _e('No featured image set for this post.', 'magazino') ?></div>
                            
                           <?php endif; ?>
                           
                         <?php endif; ?>
                         <div class="slide-content">
                            <h2 class="slide-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'magazino' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                         	<?php echo magazino_excerpt(25); ?>	
                         </div>						
                      </div>
                    </div>
                    
                    <?php endwhile; ?>

                    <?php wp_reset_query(); // reset the query ?>

                  </div>
                  
                  <div class="slidernav">
                        <a id="sliderprev" href="#" title="<?php _e('Previous', 'magazino'); ?>"><?php _e('&#9664;', 'magazino'); ?></a>
                        <a id="slidernext" href="#" title="<?php _e('Next', 'magazino'); ?>"><?php _e('&#9654;', 'magazino'); ?></a>
                    </div>
                    
                    <div class="clearfix"></div>
                  
                  <?php else : ?>
                  
                  <?php /* Start the Loop */ ?>
                   <?php while ( $fPosts->have_posts() ) : $fPosts->the_post(); ?>
                  	<div class="slides">
                      <div id="post-<?php the_ID(); ?>" <?php post_class('post-theme'); ?>>
                         <?php if ( has_post_thumbnail()) : ?>
                            <div class="slide-thumb"><?php the_post_thumbnail( array(1000, 640) ); ?></div>
                         <?php else : ?>
                            <div class="slide-noimg"><?php _e('No featured image set for this post.', 'magazino') ?></div>
                         <?php endif; ?>
                         <div class="slide-content">
                            <h2 class="slide-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'magazino' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                         	<?php echo magazino_excerpt(25); ?>	
                         </div>						
                      </div>
                    </div>
                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); // reset the query ?>
                  
                  <?php endif; ?>
                  
                <?php endif; ?>
                    
              </div>
              
              <div class="grnbar"></div>

			<?php 
				$sticky = get_option("sticky_posts");
				if ( get_query_var('paged') ) {
                        $paged = get_query_var('paged');
                } elseif ( get_query_var('page') ) {
                        $paged = get_query_var('page');
                } else {
                        $paged = 1;
                }
				$fargs = array(
					'ignore_sticky_posts' => 1,
					'post__not_in' => $sticky,
					'paged' => $paged
				);
				$rPosts = new WP_Query( $fargs );
			?>
			<?php if ( $rPosts->have_posts() ) : ?>
				<div id="post-boxes-wrap" class="clearfix">
				<?php /* Start the Loop */ ?>
				<?php while ( $rPosts->have_posts() ) : $rPosts->the_post(); ?>
					
					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content-home', get_post_format() );
					?>
                    
				<?php endwhile; ?>
                
				<?php if (function_exists("magazino_pagination")) {
							magazino_pagination(); 
				} elseif (function_exists("magazino_content_nav")) { 
							magazino_content_nav( 'nav-below' );
				}?>
                
                <?php 
				wp_reset_postdata(); // reset the query ?>
                
			</div>
            
			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'magazino' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content post_content">
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'magazino' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

        </div> <!-- end #main -->

        <?php get_sidebar(); ?>

    </div> <!-- end #content -->
        
<?php get_footer(); ?>