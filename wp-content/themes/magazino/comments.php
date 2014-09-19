<?php
/**
 * The template for displaying Comments.
 */
?>
	<?php if ( have_comments() ) : ?>
	<div id="comments-title">
		<?php
            printf( _n( '<h3>One Comment</h3> on &ldquo;%2$s&rdquo;', '<h3>%1$s Comments</h3> on &ldquo;%2$s&rdquo;', get_comments_number(), 'magazino' ),
                number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
        ?>
    </div>
    <?php endif; ?>
    
	<div id="comments" class="clearfix">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'magazino' ); ?></p>
        <div class="clearfix"></div>
	</div><!-- #comments -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
    	<div id="comments-title-mobile">
			<?php
                printf( _n( 'One Comment on &ldquo;%2$s&rdquo;', '%1$s Comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'magazino' ),
                    number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
            ?>
        </div>

		<ol class="commentlist">
			<?php
				/* Loop through and list the comments.
				 */
				wp_list_comments( array( 'callback' => 'magazino_comment' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'magazino' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'magazino' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'magazino' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are no comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'magazino' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>
    

</div><!-- #comments -->
<div class="clearfix"></div>