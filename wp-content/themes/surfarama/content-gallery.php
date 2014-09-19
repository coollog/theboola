
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php
//first get the current category ID
$categories = get_the_category($post->ID);
$cat_id = $categories[0]->cat_ID;
//then i get the data from the database
$cat_data = get_option("taxonomy_$cat_id");
//and then i just display my category image if it exists
if (isset($cat_data['cat_color'])){
echo 'style="background-color: '. $cat_data['cat_color'] .'"';
} ?>>

	<?php 
                $gallery = get_post_gallery( $post, false );
				if ( !empty($gallery['ids']) ) {
					$ids = explode( ",", $gallery['ids'] );
					$total_images = 0;
					foreach( $ids as $id ) {
						
						$title = get_post_field('post_title', $id);
						$meta = get_post_field('post_excerpt', $id);
						$link = wp_get_attachment_url( $id );
						$image  = wp_get_attachment_image( $id, array(640, 480));
						$total_images++;
						
						if ($total_images == 1) {
							$first_img = $image;
						}
					}
				} else {
					$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
					if ( $images ) {
						$total_images = count( $images );
						$first_img = array_shift( $images );
						$image = wp_get_attachment_image( $first_img->ID, array(640, 480) );
					} else {
						$total_images = 0;
						$first_img = '';
						$image = '';	
					}
				}
        ?>

	<?php if ( has_post_thumbnail()) : ?>
     	<div class="grid-box-img"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'full' ); ?></a></div>
	<?php else : ?>
		<div class="grid-box-img"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo $first_img; ?></a></div> 
    <?php endif; ?>
    
    <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
		<?php
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( __( ', ', 'surfarama' ) );
            if ( $categories_list && surfarama_categorized_blog() ) :
        ?>
        <span class="cat-links" <?php if (isset($cat_data['cat_color'])) echo 'style="background-color: '. $cat_data['cat_color'] .'"';?>>
            <?php printf( __( '%1$s', 'surfarama' ), $categories_list ); ?>
        </span>
        <?php endif; // End if categories ?>
    <?php endif; // End if 'post' == get_post_type() ?>

	<header class="entry-header">
      <?php if ( is_single() ) : ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'surfarama' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
      <?php else : ?>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'surfarama' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
      <?php endif; ?>

		<div class="entry-meta">
			<?php surfarama_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->


	<div class="entry-content post_content">
			<?php if ( post_password_required() ) : ?>
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'surfarama' ) ); ?>

			<?php else : ?>
				<p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'surfarama' ),
						'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'surfarama' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
						number_format_i18n( $total_images )
					); ?></em></p>
			<?php endif; ?>
			<?php if ( has_excerpt() ) {
				the_excerpt();
			} else {
				echo surfarama_excerpt(15);
			} ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'surfarama' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->


	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'surfarama' ) );
				if ( $categories_list && surfarama_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'surfarama' ), $categories_list ); ?>
			</span>
			<span class="sep"> | </span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'surfarama' ) );
				if ( $tags_list ) :
			?>
			<span class="tag-links">
				<?php printf( __( 'Tagged %1$s', 'surfarama' ), $tags_list ); ?>
			</span>
			<span class="sep"> | </span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'surfarama' ), __( '1 Comment', 'surfarama' ), __( '% Comments', 'surfarama' ) ); ?></span>
		<span class="sep"> | </span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'surfarama' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
