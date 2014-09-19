<div class="single-meta">
	<div><?php 
		printf( __( '<span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>', 'magazino' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'magazino' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
	?></div>
    
    <div><?php 
		printf( __( '<span class="sep">on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>', 'magazino' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	?></div>
    
    <div><?php
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', 'magazino' ) );
		printf( __('under %s', 'magazino'),
			$category_list
		);
	?>
    </div>
    
    <div><?php
		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', ', ' );
		if ( '' != $tag_list ) {
			printf( __('tagged %s', 'magazino'),
				$tag_list
			);
		}
	?>
    </div>
    
    <div><?php
		printf( __('&#8734; <a href="%1$s" title="Permalink to %2$s" rel="bookmark">Permalink</a>', 'magazino'),
			get_permalink(),
			the_title_attribute( 'echo=0' )
		);
	?>
    </div>
    
    <div>
    	<?php edit_post_link( __( 'Edit', 'magazino' ), '<span class="edit-link">', '</span>' ); ?>
    </div>
</div>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-pad'); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
        <div class="entry-meta mobile-meta">
			<?php magazino_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content post_content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'magazino' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
    
    <footer class="entry-meta mobile-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'magazino' ) );
				if ( $categories_list && magazino_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'magazino' ), $categories_list ); ?>
			</span>
			<span class="sep"> | </span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'magazino' ) );
				if ( $tags_list ) :
			?>
			<span class="tag-links">
				<?php printf( __( 'Tagged %1$s', 'magazino' ), $tags_list ); ?>
			</span>
			<span class="sep"> | </span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'magazino' ), __( '1 Comment', 'magazino' ), __( '% Comments', 'magazino' ) ); ?></span>
		<span class="sep"> | </span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'magazino' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->

	<?php magazino_content_nav( 'nav-below' ); ?>
</article><!-- #post-<?php the_ID(); ?> -->
