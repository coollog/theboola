
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta clearfix">
			<?php 
			//first get the current category ID
			$categories = get_the_category($post->ID);
			$cat_id = $categories[0]->cat_ID;
			//then i get the data from the database
			$cat_data = get_option("taxonomy_$cat_id");
			//and then i just display my category image if it exists
			if (isset($cat_data['cat_color'])){
				$cat_color_write = ' style="background-color: '. $cat_data['cat_color'] .'"';
			} else {
				$cat_color_write = '';
			}
			printf( __( '<span class="sep meta-by"%8$s>Author </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span><span class="byline"> <span class="sep meta-on"%8$s> Date </span> <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>', 'surfarama' ),
				esc_url( get_permalink() ),
				esc_attr( get_the_time() ),
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'surfarama' ), get_the_author() ) ),
				esc_html( get_the_author() ),
				$cat_color_write
			);
			 ?>
            <?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
            <div class="comment-top"><span class="meta-com"<?php echo $cat_color_write; ?>><?php _e('Comments:', 'surfarama'); ?></span> <?php comments_popup_link( __( 'Leave a comment', 'surfarama' ), __( '1 Comment', 'surfarama' ), __( '% Comments', 'surfarama' ) ); ?></div>
            <?php endif; ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content post_content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'surfarama' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'surfarama' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', ', ' );

			if ( ! surfarama_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'Tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'surfarama' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'surfarama' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( '<span class="cat-meta-color"%5$s>Posted in %1$s</span><div class="colorbar"%5$s></div> Tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'surfarama' );
				} else {
					$meta_text = __( '<span class="cat-meta-color"%5$s>Posted in %1$s</span><div class="colorbar"%5$s></div> Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'surfarama' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' ),
				$cat_color_write
			);
		?>

		<?php edit_post_link( __( 'Edit', 'surfarama' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
    
</article><!-- #post-<?php the_ID(); ?> -->
