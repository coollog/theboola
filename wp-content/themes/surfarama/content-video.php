
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php
//first get the current category ID
$categories = get_the_category($post->ID);
if ( $categories ) {
	$cat_id = $categories[0]->cat_ID;
	//then i get the data from the database
	$cat_data = get_option("taxonomy_$cat_id");
	//and then i just display my category image if it exists
	if (isset($cat_data['cat_color'])){
	echo ' style="background-color: '. $cat_data['cat_color'] .'"';
	}
}?>>
	
    <?php if ( has_post_thumbnail()) : ?>
     	<div class="grid-box-img"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'full' ); ?></a></div>
		
	<?php else : ?>
    <div class="vid-wrapper">
    <?php 
    $content = trim( get_the_content() );
    echo surfarama_featured_video( $content );
    ?>
    </div>
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
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'surfarama' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php if(the_title( '', '', false ) !='') the_title(); else _e( 'View Post', 'surfarama' ); ?></a></h2>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php surfarama_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
    

	<div class="entry-content post_content">
		<?php
		if ( has_excerpt() ) {
			the_excerpt();
		} else {
			echo surfarama_excerpt(15);
		} ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			
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
