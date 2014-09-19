<?php
/**
 * Plugin Name: Facebook By WebLizar
 * Version: 0.7
 * Description: Display your facebook page live stream & friends on WordPress blog.
 * Author: WebLizar
 * Author URI: http://www.weblizar.com
 * Plugin URI: http://www.weblizar.com/plugins/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * Constant Values & Variables
 */
define("WEBLIZAR_FACEBOOK_PLUGIN_URL", plugin_dir_url(__FILE__));
define("WEBLIZAR_FACEBOOK_TEXT_DOMAIN", "wl_facebook");

/**
 * Get Ready Plugin Translation
 */
add_action('plugins_loaded', 'FacebookTranslation');
function FacebookTranslation() {
	load_plugin_textdomain( WEBLIZAR_FACEBOOK_TEXT_DOMAIN, FALSE, dirname( plugin_basename(__FILE__)).'/lang/' );
}

/**
 * Adds WeblizarFacebook Widget
 */
class WeblizarFacebook extends WP_Widget {

    /**
     * Register widget with WordPress
     */
    function __construct() {
		add_action('plugins_loaded', 'GetReadyFacebookTranslation');
        parent::__construct(
            'weblizar_facebook_likebox', // Base ID
            'Facebook By WebLizar', // Widget Name
            array( 'description' => __( 'Display Facebook Page Live Stream & Fans', WEBLIZAR_FACEBOOK_TEXT_DOMAIN ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $FbAppId = apply_filters( 'facebook_app_id', $instance['FbAppId'] );
        $ColorScheme = apply_filters( 'facebook_color_scheme', $instance['ColorScheme'] );
        $ForceWall = apply_filters( 'facebook_force_wall', $instance['ForceWall'] );
        $Header = apply_filters( 'facebook_header', $instance['Header'] );
        $Height = apply_filters( 'facebook_height', $instance['Height'] );
        $FacebookPageURL = apply_filters( 'facebook_page_url', $instance['FacebookPageURL'] );
        $ShowBorder = apply_filters( 'facebook_show_border', $instance['ShowBorder'] );
        $ShowFaces = apply_filters( 'facebook_show_faces', $instance['ShowFaces'] );
        $Stream = apply_filters( 'facebook_stream', $instance['Stream'] );
        $Width = apply_filters( 'facebook_width', $instance['Width'] );

        if ( ! empty( $Title ) )
            echo $args['before_title'] . $Title . $args['after_title']; ?>
		<style>
		@media (max-width:767px) {
			.fb_iframe_widget {
				width: 100%;
			}
			.fb_iframe_widget span {
				width: 100% !important;
			}
			.fb_iframe_widget iframe {
				width: 100% !important;
			}
			._8r {
				margin-right: 5px;
				margin-top: -4px !important;
			}
		}
		</style>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=<?php echo $FbAppId; ?>&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <div class="fb-like-box" style="background-color: auto;" colorscheme="<?php echo $ColorScheme; ?>" data-header="<?php echo $Header; ?>" data-height="<?php echo $Height; ?>" data-href="<?php echo $FacebookPageURL; ?>" data-show-border="<?php echo $ShowBorder; ?>" data-show-faces="<?php echo $ShowFaces; ?>" data-stream="<?php echo $Stream; ?>" data-width="<?php echo $Width; ?>" data-force-wall="<?php echo $ForceWall; ?>"></div>

        <?php
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {

        //default values & Submitted Values
        $ColorScheme = 'lite';
        if ( isset( $instance[ 'ColorScheme' ] ) ) {
            $ColorScheme = $instance[ 'ColorScheme' ];
        }

        $ForceWall = 'false';
        if ( isset( $instance[ 'ForceWall' ] ) ) {
            $ForceWall = $instance[ 'ForceWall' ];
        }

        $Header = 'true';
        if ( isset( $instance[ 'Header' ] ) ) {
            $Header = $instance[ 'Header' ];
        }

        $Height = 560;
        if ( isset( $instance[ 'Height' ] ) ) {
            $Height = $instance[ 'Height' ];
        }

        $FacebookPageURL = 'https://www.facebook.com/pages/Weblizar/1440510482872657';
        if ( isset( $instance[ 'FacebookPageURL' ] ) ) {
            $FacebookPageURL = $instance[ 'FacebookPageURL' ];
        }

        $ShowBorder = 'true';
        if ( isset( $instance[ 'ShowBorder' ] ) ) {
            $ShowBorder = $instance[ 'ShowBorder' ];
        }

        $ShowFaces = 'true';
        if ( isset( $instance[ 'ShowFaces' ] ) ) {
            $ShowFaces = $instance[ 'ShowFaces' ];
        }

        $Stream = 'true';
        if ( isset( $instance[ 'Stream' ] ) ) {
            $Stream = $instance[ 'Stream' ];
        }

        $Width = 292;
        if ( isset( $instance[ 'Width' ] ) ) {
            $Width = $instance[ 'Width' ];
        }

        $FbAppId = '488390501239538';
        if ( isset( $instance[ 'FbAppId' ] ) ) {
            $FbAppId = $instance[ 'FbAppId' ];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'FacebookPageURL' ); ?>"><?php _e( 'Facebook Page URL', WEBLIZAR_FACEBOOK_TEXT_DOMAIN ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'FacebookPageURL' ); ?>" name="<?php echo $this->get_field_name( 'FacebookPageURL' ); ?>" type="text" value="<?php echo esc_attr( $FacebookPageURL ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'ColorScheme' ); ?>"><?php _e( 'Widget Color Scheme', WEBLIZAR_FACEBOOK_TEXT_DOMAIN ); ?></label>
            <select id="<?php echo $this->get_field_id( 'ColorScheme' ); ?>" name="<?php echo $this->get_field_name( 'ColorScheme' ); ?>">
                <option value="light" <?php if($ColorScheme == "light") echo "selected=selected" ?>>Light Color Theme</option>
                <option value="dark" <?php if($ColorScheme == "dark") echo "selected=selected" ?>>Dark Color Theme</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'Header' ); ?>"><?php _e( 'Show Widget Header', WEBLIZAR_FACEBOOK_TEXT_DOMAIN ); ?></label>
            <select id="<?php echo $this->get_field_id( 'Header' ); ?>" name="<?php echo $this->get_field_name( 'Header' ); ?>">
                <option value="true" <?php if($Header == "true") echo "selected=selected" ?>>Yes</option>
                <option value="false" <?php if($Header == "false") echo "selected=selected" ?>>No</option>
            </select>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id( 'ShowFaces' ); ?>"><?php _e( 'Show Faces', WEBLIZAR_FACEBOOK_TEXT_DOMAIN ); ?></label>
            <select id="<?php echo $this->get_field_id( 'ShowFaces' ); ?>" name="<?php echo $this->get_field_name( 'ShowFaces' ); ?>">
                <option value="true" <?php if($ShowFaces == "true") echo "selected=selected" ?>>Yes</option>
                <option value="false" <?php if($ShowFaces == "false") echo "selected=selected" ?>>No</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'Stream' ); ?>"><?php _e( 'Show Live Stream', WEBLIZAR_FACEBOOK_TEXT_DOMAIN ); ?></label>
            <select id="<?php echo $this->get_field_id( 'Stream' ); ?>" name="<?php echo $this->get_field_name( 'Stream' ); ?>">
                <option value="true" <?php if($Stream == "true") echo "selected=selected" ?>>Yes</option>
                <option value="false" <?php if($Stream == "false") echo "selected=selected" ?>>No</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'Width' ); ?>"><?php _e( 'Widget Width', WEBLIZAR_FACEBOOK_TEXT_DOMAIN ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'Width' ); ?>" name="<?php echo $this->get_field_name( 'Width' ); ?>" type="text" value="<?php echo esc_attr( $Width ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'Height' ); ?>"><?php _e( 'Widget Height', WEBLIZAR_FACEBOOK_TEXT_DOMAIN ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'Height' ); ?>" name="<?php echo $this->get_field_name( 'Height' ); ?>" type="text" value="<?php echo esc_attr( $Height ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'FbAppId' ); ?>"><?php _e( 'Facebook App ID', WEBLIZAR_FACEBOOK_TEXT_DOMAIN ); ?> (<?php _e("Required",WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?>)</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'FbAppId' ); ?>" name="<?php echo $this->get_field_name( 'FbAppId' ); ?>" type="text" value="<?php echo esc_attr( $FbAppId ); ?>">
            <?php _e("Get Your Facebook App. Id",WEBLIZAR_FACEBOOK_TEXT_DOMAIN); ?>: <a href="http://weblizar.com/get-facebook-app-id/" target="_blank">HERE</a>
        </p>

        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['FacebookPageURL'] = ( ! empty( $new_instance['FacebookPageURL'] ) ) ? strip_tags( $new_instance['FacebookPageURL'] ) : 'https://www.facebook.com/pages/Weblizar/1440510482872657';
        $instance['ColorScheme'] = ( ! empty( $new_instance['ColorScheme'] ) ) ? strip_tags( $new_instance['ColorScheme'] ) : 'light';
        $instance['Header'] = ( ! empty( $new_instance['Header'] ) ) ? strip_tags( $new_instance['Header'] ) : 'true';
        $instance['Width'] = ( ! empty( $new_instance['Width'] ) ) ? strip_tags( $new_instance['Width'] ) : '292';
        $instance['Height'] = ( ! empty( $new_instance['Height'] ) ) ? strip_tags( $new_instance['Height'] ) : '560';
        $instance['Stream'] = ( ! empty( $new_instance['Stream'] ) ) ? strip_tags( $new_instance['Stream'] ) : 'true';
        $instance['ShowFaces'] = ( ! empty( $new_instance['ShowFaces'] ) ) ? strip_tags( $new_instance['ShowFaces'] ) : 'true';
        $instance['ShowBorder'] = ( ! empty( $new_instance['ShowBorder'] ) ) ? strip_tags( $new_instance['ShowBorder'] ) : 'true';
        $instance['ForceWall'] = ( ! empty( $new_instance['ForceWall'] ) ) ? strip_tags( $new_instance['ForceWall'] ) : 'false';
        $instance['FbAppId'] = ( ! empty( $new_instance['FbAppId'] ) ) ? strip_tags( $new_instance['FbAppId'] ) : '488390501239538';
        return $instance;
    }

} // class WeblizarFacebook

// register WeblizarFacebook widget
function WeblizarFacebookWidget() {
    register_widget( 'WeblizarFacebook' );
}
add_action( 'widgets_init', 'WeblizarFacebookWidget' );

/**
 * Facebook By Weblizar Menu
 */
add_action('admin_menu','WeblizarFacebookMenu');
function WeblizarFacebookMenu() {
    $AdminMenu = add_menu_page( 'Facebook By Weblizar', 'Facebook By Weblizar', 'administrator', 'facebooky-by-weblizar', 'facebooky_by_weblizar_page_function', 'dashicons-facebook-alt');
}

function facebooky_by_weblizar_page_function() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('bootstrap-min-js', WEBLIZAR_FACEBOOK_PLUGIN_URL.'js/bootstrap.min.js');
	wp_enqueue_script('weblizar-tab-js', WEBLIZAR_FACEBOOK_PLUGIN_URL .'js/option-js.js',array('jquery', 'media-upload', 'jquery-ui-sortable'));
	wp_enqueue_style('weblizar-option-style-css', WEBLIZAR_FACEBOOK_PLUGIN_URL .'css/weblizar-option-style.css');
	wp_enqueue_style('op-bootstrap-css', WEBLIZAR_FACEBOOK_PLUGIN_URL. 'css/bootstrap.min.css');
	wp_enqueue_style('weblizar-bootstrap-responsive-google', WEBLIZAR_FACEBOOK_PLUGIN_URL .'css/bootstrap-responsive.css');
	wp_enqueue_style('font-awesome-min-css', WEBLIZAR_FACEBOOK_PLUGIN_URL.'css/font-awesome-latest/css/font-awesome.min.css');
	wp_enqueue_style('Respo-pricing-table-css', WEBLIZAR_FACEBOOK_PLUGIN_URL .'css/pricing-table-responsive.css');
	wp_enqueue_style('pricing-table-css', WEBLIZAR_FACEBOOK_PLUGIN_URL .'css/pricing-table.css');
	require_once("facebook-by-weblizar-help.php");
}

/**
 * Load Facebook Like Box Shortcode
 */
	require_once("facebook-by-weblizar-short-code.php");
?>