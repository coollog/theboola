<?php

class Reverb_Trending_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'reverb_trending_widget', // Base ID
			'Trending Articles', // Name
			array( 'description' => __( 'The most recently popular posts on you blog' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		$current_post_permalink = get_permalink();
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		echo __( '<div id="reverb-trending-articles" data-url="'.home_url().'"></div>' );
		echo $after_widget;
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

add_action( 'widgets_init', create_function( '', 'register_widget( "reverb_trending_widget" );' ) );