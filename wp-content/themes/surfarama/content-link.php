
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

	<?php if ( has_post_thumbnail()) : ?>
     	<div class="grid-box-img"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'full' ); ?></a></div>
		
	<?php else : ?>
    <?php
    	$postimgs =& get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
		if ( !empty($postimgs) ) {
			$firstimg = array_shift( $postimgs );
			$th_image = wp_get_attachment_image( $firstimg->ID, 'full', false );
		 ?>
			<div class="grid-box-img"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo $th_image; ?></a></div> 
		
	<?php } else { ?>
		
			<div class="grid-box-noimg"></div> 
		
	<?php } ?>
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
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'surfarama' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header><!-- .entry-header -->


	<div class="entry-content post_content">
    	<?php if ( has_excerpt() ) {
				the_excerpt();
		} else { ?>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'surfarama' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'surfarama' ), 'after' => '</div>' ) ); ?>
        <?php } ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php surfarama_posted_on(); ?>
	</footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
