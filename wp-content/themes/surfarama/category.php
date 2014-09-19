<?php get_header(); ?>

    <div id="content" class="clearfix">
        
        <div id="main" class="clearfix" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php
						//first get the current category ID
						$categories = get_the_category($post->ID);
						if ( $categories ) {
							$cat_id = $categories[0]->cat_ID;
							//then i get the data from the database
							$cat_data = get_option("taxonomy_$cat_id");
							//and then i just display my category image if it exists
							if (isset($cat_data['cat_color'])){
								$newcatcolor = ' style="color: '. $cat_data['cat_color'] .'"';
							}
						}
						printf( __( 'Category Archives: %s', 'surfarama' ), '<span class="colortxt"' . $newcatcolor . '>' . single_cat_title( '', false ) . '</span>' );
					?></h1>

					<?php
						$category_description = category_description();
						if ( ! empty( $category_description ) )
							echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
					?>
				</header>
                
                <div id="grid-wrap" class="clearfix">

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<div class="grid-box">
					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>
					</div>
                    
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

        <?php get_sidebar('archive'); ?>

    </div> <!-- end #content -->
        
<?php get_footer(); ?>