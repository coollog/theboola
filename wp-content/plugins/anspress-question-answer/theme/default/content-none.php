<?php

 $clearfix_class = array('clearfix');

?>

<article id="post-0" <?php post_class($clearfix_class); ?>>
	<div class="no-questions">
		<?php _e('No topics posted yet!, be the first to post a topic.', 'ap'); ?>
		
		<a href="<?php echo ap_get_link_to('ask'); ?>" class="ap-btn ap-success"><?php _e('Post topic', 'ap'); ?></a>
	</div>
</article><!-- list item -->
