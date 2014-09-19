
<article id="post-<?php the_ID(); ?>" <?php post_class('post-box'); ?>>

    <header class="entry-header">
        <?php if ( 'post' == get_post_type() ) : ?>
        <div class="entry-meta">
            <?php
				if ( get_theme_mod('magazino_date_format') ) {
					$dformat = get_theme_mod('magazino_date_format');
				} else {
					$dformat = 'd.m.y';
				}
			?>
            <a href="<?php the_permalink() ?>" rel="bookmark"><?php printf( __('%s', 'magazino'), get_the_date($dformat) ); ?></a>
        </div><!-- .entry-meta -->
        <?php endif; ?>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'magazino' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>		
    </header><!-- .entry-header -->
    
    <div class="entry-content post_content">
        <?php echo magazino_excerpt(12); ?>
    </div><!-- .entry-content -->
    
    <div class="go-button"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'magazino' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php _e('&#9654;', 'magazino'); ?></a></div>
    
	<?php //Checks for plugin..
	if (class_exists('MultiPostThumbnails') && MultiPostThumbnails::has_post_thumbnail(get_post_type(), 'grid-thumbnail', strval(get_the_ID()))) : ?>

    <div class="post-box-img"><?php MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'grid-thumbnail'); ?></div>
      
    <?php else : //Plugin not installed?>
    
      <?php //Checks for attached post image instead
    $postimgs =& get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'exclude' => get_post_thumbnail_id() ) );
    if ( !empty($postimgs) ) {
        $firstimg = array_shift( $postimgs );
        $th_image = wp_get_attachment_image( $firstimg->ID, array(500, 500), false );
     ?>
        <div class="post-box-img"><?php echo $th_image; ?></div>
    <?php } ?>
    
    <?php endif; ?>
		
</article><!-- #post-<?php the_ID(); ?> -->
    

