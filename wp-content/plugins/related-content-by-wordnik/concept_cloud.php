<?php

class Concept_Cloud_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'concept_cloud_widget', // Base ID
			'Concept Cloud', // Name
			array( 'description' => __( 'A static list of concepts automatically detected in your post' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		if(is_single()) {
			$current_post_permalink = get_permalink();
			echo $before_widget;
			if ( ! empty( $title ) )
				echo $before_title . $title . $after_title;
			echo __( '<div id="chorus-concept-cloud" data-url="'.$current_post_permalink.'"></div>' );
			echo $after_widget;
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( '' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}	

}

add_action( 'widgets_init', create_function( '', 'register_widget( "concept_cloud_widget" );' ) );