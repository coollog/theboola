<?php
/*
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.txt
Copyright 2012-2014 - Jean-Sebastien Morisset - http://surniaulula.com/
*/

if ( ! defined( 'ABSPATH' ) ) 
	die( 'These aren\'t the droids you\'re looking for...' );

if ( ! class_exists( 'NgfbUtil' ) && class_exists( 'SucomUtil' ) ) {

	class NgfbUtil extends SucomUtil {

		private $size_labels = array();	// reference array for image size labels
		private $urls_found = array();	// array to detect duplicate images, etc.

		protected $p;

		public function __construct( &$plugin ) {
			$this->p =& $plugin;
			$this->p->debug->mark();
			$this->add_actions();
		}

		protected function add_actions() {
			add_action( 'wp', array( &$this, 'add_plugin_image_sizes' ), 10, 0 );
			add_action( 'wp_scheduled_delete', array( &$this, 'delete_expired_transients' ) );
			add_action( 'wp_scheduled_delete', array( &$this, 'delete_expired_file_cache' ) );
		}

		// called from several class __construct() methods to hook their filters
		public function add_plugin_filters( &$class, $filters, $prio = 10, $lca = '' ) {
			$lca = $lca === '' ? $this->p->cf['lca'] : $lca;
			foreach ( $filters as $name => $num ) {
				$filter = $lca.'_'.$name;
				$method = 'filter_'.$name;
				add_filter( $filter, array( &$class, $method ), $prio, $num );
				$this->p->debug->log( 'filter for '.$filter.' added', 2 );
			}
		}

		public function get_image_size_label( $size_name ) {
			if ( ! empty( $this->size_labels[$size_name] ) )
				return $this->size_labels[$size_name];
			else return $size_name;
		}

		public function add_plugin_image_sizes( $post_id = false ) {
			$sizes = apply_filters( $this->p->cf['lca'].'_plugin_image_sizes', array() );
			$meta_opts = array();

			// allow custom post meta to override the image size options
			if ( isset( $this->p->addons['util']['postmeta'] ) ) {
				if ( ! is_numeric( $post_id ) && is_singular() ) {
					$obj = $this->get_post_object();
					$post_id = empty( $obj->ID ) || 
						empty( $obj->post_type ) ? 0 : $obj->ID;
				}
				if ( ! empty( $post_id ) )
					$meta_opts = $this->p->addons['util']['postmeta']->get_options( $post_id );
			}

			foreach( $sizes as $opt_prefix => $attr ) {

				// check for custom meta sizes first
				if ( ! empty( $meta_opts[$opt_prefix.'_width'] ) && $meta_opts[$opt_prefix.'_width'] > 0 && 
					! empty( $meta_opts[$opt_prefix.'_height'] ) && $meta_opts[$opt_prefix.'_height'] > 0 ) {
					$width = $meta_opts[$opt_prefix.'_width'];
					$height = $meta_opts[$opt_prefix.'_height'];
					$crop = empty( $meta_opts[$opt_prefix.'_crop'] ) ? false : true;
					$this->p->debug->log( 'found custom meta '.$opt_prefix.' size ('.$width.'x'.$height.( $crop === true ? ' cropped' : '' ).')' );
				} else {
					$width = empty( $this->p->options[$opt_prefix.'_width'] ) ? 0 : $this->p->options[$opt_prefix.'_width'];
					$height = empty( $this->p->options[$opt_prefix.'_height'] ) ? 0 : $this->p->options[$opt_prefix.'_height'];
					$crop = empty( $this->p->options[$opt_prefix.'_crop'] ) ? false : true;
				}

				if ( $width > 0 && $height > 0 ) {
					if ( is_array( $attr ) ) {
						$name = empty( $attr['name'] ) ? $opt_prefix : $attr['name'];
						$label = empty( $attr['label'] ) ? $opt_prefix : $attr['label'];
					} else $name = $label = $attr;
					$this->size_labels[$this->p->cf['lca'].'-'.$name] = $label;	// setup reference array for image size labels
					$this->p->debug->log( 'image size '.$this->p->cf['lca'].'-'.$name.
						' ('.$width.'x'.$height.( $crop === true ? ' cropped' : '' ).') added' );
					add_image_size( $this->p->cf['lca'].'-'.$name, $width, $height, $crop );
				}
			}
		}

		// deprecated function
		public function add_img_sizes_from_opts( $sizes ) {
			foreach( $sizes as $opt_prefix => $size_suffix ) {
				if ( ! empty( $this->p->options[$opt_prefix.'_width'] ) &&
					! empty( $this->p->options[$opt_prefix.'_height'] ) ) {

					$this->p->debug->log( 'image size '.$this->p->cf['lca'].'-'.$size_suffix.
						' ('.$this->p->options[$opt_prefix.'_width'].'x'.$this->p->options[$opt_prefix.'_height'].
						( empty( $this->p->options[$opt_prefix.'_crop'] ) ? '' : ' cropped' ).') added', 2 );

					add_image_size( $this->p->cf['lca'].'-'.$size_suffix, 
						$this->p->options[$opt_prefix.'_width'], 
						$this->p->options[$opt_prefix.'_height'], 
						( empty( $this->p->options[$opt_prefix.'_crop'] ) ? false : true ) );
				}
			}
		}

		public function push_add_to_options( &$opts = array(), $add_to_prefixes = array( 'plugin' => 'backend' ) ) {
			foreach ( $add_to_prefixes as $opt_prefix => $type ) {
				foreach ( $this->get_post_types( $type ) as $post_type ) {
					$option_name = $opt_prefix.'_add_to_'.$post_type->name;
					$filter_name = $this->p->cf['lca'].'_add_to_options_'.$post_type->name;
					if ( ! isset( $opts[$option_name] ) )
						$opts[$option_name] = apply_filters( $filter_name, 1 );
				}
			}
			return $opts;
		}

		public function get_post_types( $type = 'frontend', $output = 'objects' ) {
			$include = false;
			switch ( $type ) {
				case 'frontend':
					$include = array( 'public' => true );
					break;
				case 'backend':
					$include = array( 'public' => true, 'show_ui' => true );
					break;
			}
			$post_types = $include !== false ? get_post_types( $include, $output ) : array();
			return apply_filters( $this->p->cf['lca'].'_post_types', $post_types, $type, $output );
		}

		public function flush_post_cache( $post_id ) {
			switch ( get_post_status( $post_id ) ) {
			case 'draft':
			case 'pending':
			case 'future':
			case 'private':
			case 'publish':
				$lang = SucomUtil::get_locale();
				$cache_type = 'object cache';
				$sharing_url = $this->p->util->get_sharing_url( $post_id );

				$transients = array(
					'NgfbHead::get_header_array' => array( 
						'lang:'.$lang.'_post:'.$post_id.'_url:'.$sharing_url,
						'lang:'.$lang.'_post:'.$post_id.'_url:'.$sharing_url.'_crawler:pinterest',
					),
				);
				$transients = apply_filters( $this->p->cf['lca'].'_post_cache_transients', $transients, $post_id, $lang, $sharing_url );

				$objects = array(
					'SucomWebpage::get_content' => array(
						'lang:'.$lang.'_post:'.$post_id.'_filtered',
						'lang:'.$lang.'_post:'.$post_id.'_unfiltered',
					),
					'SucomWebpage::get_hashtags' => array(
						'lang:'.$lang.'_post:'.$post_id,
					),
				);
				$objects = apply_filters( $this->p->cf['lca'].'_post_cache_objects', $objects, $post_id, $lang, $sharing_url );

				$deleted = $this->flush_cache_objects( $transients, $objects );
				if ( ! empty( $this->p->options['plugin_cache_info'] ) )
					$this->p->notice->inf( $deleted.' items removed from the WordPress object and transient caches.', true );
				break;
			}
		}

		public function flush_cache_objects( &$transients = array(), &$objects = array() ) {
			$deleted = 0;
			foreach ( $transients as $group => $arr ) {
				foreach ( $arr as $val ) {
					if ( ! empty( $val ) ) {
						$cache_salt = $group.'('.$val.')';
						$cache_id = $this->p->cf['lca'].'_'.md5( $cache_salt );
						if ( delete_transient( $cache_id ) ) {
							if ( $this->p->debug->is_on() )
								$this->p->debug->log( 'flushed transient cache salt: '. $cache_salt );
							$deleted++;
						}
					}
				}
			}
			foreach ( $objects as $group => $arr ) {
				foreach ( $arr as $val ) {
					if ( ! empty( $val ) ) {
						$cache_salt = $group.'('.$val.')';
						$cache_id = $this->p->cf['lca'].'_'.md5( $cache_salt );
						if ( wp_cache_delete( $cache_id, $group ) ) {
							if ( $this->p->debug->is_on() )
								$this->p->debug->log( 'flushed object cache salt: '. $cache_salt );
							$deleted++;
						}
					}
				}
			}
			return $deleted;
		}

		public function get_topics() {
			if ( $this->p->is_avail['cache']['transient'] ) {
				$cache_salt = __METHOD__.'('.NGFB_TOPICS_LIST.')';
				$cache_id = $this->p->cf['lca'].'_'.md5( $cache_salt );
				$cache_type = 'object cache';
				$this->p->debug->log( $cache_type.': transient salt '.$cache_salt );
				$topics = get_transient( $cache_id );
				if ( is_array( $topics ) ) {
					$this->p->debug->log( $cache_type.': topics array retrieved from transient '.$cache_id );
					return $topics;
				}
			}
			if ( ( $topics = file( NGFB_TOPICS_LIST, 
				FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES ) ) === false ) {
				$this->p->notice->err( 'Error reading <u>'.NGFB_TOPICS_LIST.'</u>.' );
				return $topics;
			}
			$topics = apply_filters( $this->p->cf['lca'].'_topics', $topics );
			natsort( $topics );
			$topics = array_merge( array( 'none' ), $topics );	// after sorting the array, put 'none' first

			if ( ! empty( $cache_id ) ) {
				set_transient( $cache_id, $topics, $this->p->cache->object_expire );
				$this->p->debug->log( $cache_type.': topics array saved to transient '.$cache_id.' ('.$this->p->cache->object_expire.' seconds)');
			}
			return $topics;
		}

		public function sanitize_option_value( $key, $val, $def_val, $opts_type = false ) {
			$option_type = apply_filters( $this->p->cf['lca'].'_option_type', false, $key, $opts_type );
			$reset_msg = __( 'resetting the option to its default value.', NGFB_TEXTDOM );

			// pre-filter most values to remove html
			switch ( $option_type ) {
				case 'html':	// leave html and css / javascript code blocks as-is
				case 'code':
					break;
				default:
					$val = stripslashes( $val );
					$val = wp_filter_nohtml_kses( $val );
					$val = htmlentities( $val, ENT_QUOTES, get_bloginfo( 'charset' ), false );	// double_encode = false
					break;
			}

			switch ( $option_type ) {
				case 'at_name':		// twitter-style usernames (prepend with an at)
					if ( $val !== '' ) {
						$val = substr( preg_replace( '/[^a-z0-9_]/', '', strtolower( $val ) ), 0, 15 );
						if ( $val !== '' )
							$val = '@'.$val;
					}
					break;
				case 'url_base':	// strip leading urls off facebook usernames
					if ( $val !== '' ) {
						$val = $this->cleanup_html_tags( $val );
						$val = preg_replace( '/(http|https):\/\/[^\/]*?\//', '', $val );
					}
					break;
				case 'url':		// must be a url
					if ( $val !== '' ) {
						$val = $this->cleanup_html_tags( $val );
						if ( strpos( $val, '//' ) === false ) {
							$this->p->notice->err( 'The value of option \''.$key.'\' must be a URL'.' - '.$reset_msg, true );
							$val = $def_val;
						}
					}
					break;
				case 'numeric':		// must be numeric (blank or zero is ok)
					if ( $val !== '' && ! is_numeric( $val ) ) {
						$this->p->notice->err( 'The value of option \''.$key.'\' must be numeric'.' - '.$reset_msg, true );
						$val = $def_val;
					}
					break;
				case 'pos_num':		// integer options that must be 1 or more (not zero)
				case 'img_dim':		// image dimensions, subject to minimum value (typically, at least 200px)
					if ( $option_type == 'img_dim' )
						$min_int = empty( $this->p->cf['head']['min_img_dim'] ) ? 
							200 : $this->p->cf['head']['min_img_dim'];
					else $min_int = 1;

					if ( $val === '' && $opts_type !== false )	// custom options allowed to have blanks
						break;
					elseif ( ! is_numeric( $val ) || $val < $min_int ) {
						$this->p->notice->err( 'The value of option \''.$key.'\' must be greater or equal to '.$min_int.' - '.$reset_msg, true );
						$val = $def_val;
					}
					break;
				case 'textured':	// must be texturized 
					if ( $val !== '' )
						$val = trim( wptexturize( ' '.$val.' ' ) );
					break;
				case 'anu_case':	// must be alpha-numeric uppercase (hyphens and periods allowed as well)
					if ( $val !== '' && preg_match( '/[^A-Z0-9\-\.]/', $val ) ) {
						$this->p->notice->err( '\''.$val.'\' is not an accepted value for option \''.$key.'\''.' - '.$reset_msg, true );
						$val = $def_val;
					}
					break;
				case 'ok_blank':	// text strings that can be blank
				case 'html':
					if ( $val !== '' )
						$val = trim( $val );
					break;
				case 'not_blank':	// options that cannot be blank
				case 'code':
					if ( $val === '' ) {
						$this->p->notice->err( 'The value of option \''.$key.'\' cannot be empty'.' - '.$reset_msg, true );
						$val = $def_val;
					}
					break;
				case 'checkbox':	// everything else is a 1 of 0 checkbox option 
				default:
					if ( $def_val === 0 || $def_val === 1 )	// make sure the default option is also a 1 or 0, just in case
						$val = empty( $val ) ? 0 : 1;
					break;
			}
			return $val;
		}
	}
}

?>
