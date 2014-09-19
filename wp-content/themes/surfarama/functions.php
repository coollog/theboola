<?php
/**
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 */


if ( ! function_exists( 'surfarama_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function surfarama_setup() {
		
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'surfarama', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'surfarama' ),
	) );

	add_theme_support('post-thumbnails'); 
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	
	
	// custom backgrounds
	$surfarama_custom_background = array(
		// Background color default
		'default-color' => 'ffffff',
		// Background image default
		'default-image' => '',
		'wp-head-callback' => '_custom_background_cb'
	);
	add_theme_support('custom-background', $surfarama_custom_background );
	
	
	// adding post format support
	add_theme_support( 'post-formats', 
		array( 
			'aside', /* Typically styled without a title. Similar to a Facebook note update */
			'gallery', /* A gallery of images. Post will likely contain a gallery shortcode and will have image attachments */
			'link', /* A link to another site. Themes may wish to use the first <a href=ÓÓ> tag in the post content as the external link for that post. An alternative approach could be if the post consists only of a URL, then that will be the URL and the title (post_title) will be the name attached to the anchor for it */
			'image', /* A single image. The first <img /> tag in the post could be considered the image. Alternatively, if the post consists only of a URL, that will be the image URL and the title of the post (post_title) will be the title attribute for the image */
			'quote', /* A quotation. Probably will contain a blockquote holding the quote content. Alternatively, the quote may be just the content, with the source/author being the title */
			'status', /*A short status update, similar to a Twitter status update */
			'video', /* A single video. The first <video /> tag or object/embed in the post content could be considered the video. Alternatively, if the post consists only of a URL, that will be the video URL. May also contain the video as an attachment to the post, if video support is enabled on the blog (like via a plugin) */
			'audio', /* An audio file. Could be used for Podcasting */
			'chat' /* A chat transcript */
		)
	);
}
endif;
add_action( 'after_setup_theme', 'surfarama_setup' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! function_exists( 'surfarama_content_width' ) ) :
	function surfarama_content_width() {
		global $content_width;
		if (!isset($content_width))
			$content_width = 800; /* pixels */
	}
endif;
add_action( 'after_setup_theme', 'surfarama_content_width' );



/*******************************************************************
* These are settings for the Theme Customizer in the admin panel. 
*******************************************************************/
if ( ! function_exists( 'surfarama_theme_customizer' ) ) :

	function surfarama_theme_customizer( $wp_customize ) {
		
		$wp_customize->remove_section( 'title_tagline');
		$wp_customize->remove_section( 'static_front_page' );
	
	
		/* color scheme option */
		$wp_customize->add_setting( 'surfarama_color', array (
			'default'	=> '#359bed',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'surfarama_color', array(
			'label'    => __( 'Primary Theme Color', 'surfarama' ),
			'section'  => 'colors',
			'settings' => 'surfarama_color',
		) ) );
		
		/* site title color option */
		$wp_customize->add_setting( 'surfarama_title_color', array (
			'default'	=> '#000000',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'surfarama_title_color', array(
			'label'    => __( 'Site Title Color', 'surfarama' ),
			'section'  => 'colors',
			'settings' => 'surfarama_title_color',
		) ) );
		
		/* main text color option */
		$wp_customize->add_setting( 'surfarama_text_color', array (
			'default'	=> '#000000',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'surfarama_text_color', array(
			'label'    => __( 'Main Text Color', 'surfarama' ),
			'section'  => 'colors',
			'settings' => 'surfarama_text_color',
		) ) );
		
		/* main text color option */
		$wp_customize->add_setting( 'surfarama_meta_color', array (
			'default'	=> '#a4a4a4',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'surfarama_metacolor', array(
			'label'    => __( 'Meta Data Text Color', 'surfarama' ),
			'section'  => 'colors',
			'settings' => 'surfarama_meta_color',
		) ) );
		
		/* post links color option */
		$wp_customize->add_setting( 'surfarama_link_color', array(
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'surfarama_link_color', array(
			'label'    => __( 'Post/Page Links Color', 'surfarama' ),
			'section'  => 'colors',
			'settings' => 'surfarama_link_color',
		) ) );
		
		/* navigation and widget background color option */
		$wp_customize->add_setting( 'surfarama_nav_color', array (
			'default'	=> '#000000',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'surfarama__nav_color', array(
			'label'    => __( 'Navigation and Widget Background Color', 'surfarama' ),
			'section'  => 'colors',
			'settings' => 'surfarama_nav_color',
		) ) );
		
		
		/* logo option */
		$wp_customize->add_section( 'surfarama_logo_section' , array(
			'title'       => __( 'Site Logo', 'surfarama' ),
			'priority'    => 31,
			'description' => __( 'Upload a logo to replace the default site name in the header', 'surfarama' ),
		) );
		
		$wp_customize->add_setting( 'surfarama_logo', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'surfarama_logo', array(
			'label'    => __( 'Choose your logo (ideal width is 100-300px and ideal height is 40-100px)', 'surfarama' ),
			'section'  => 'surfarama_logo_section',
			'settings' => 'surfarama_logo',
		) ) );
	
		
		/* social media option */
		$wp_customize->add_section( 'surfarama_social_section' , array(
			'title'       => __( 'Social Media Icons', 'surfarama' ),
			'priority'    => 32,
			'description' => __( 'Optional media icons in the header', 'surfarama' ),
		) );
		
		$wp_customize->add_setting( 'surfarama_facebook', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_facebook', array(
			'label'    => __( 'Enter your Facebook url', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_facebook',
			'priority'    => 101,
		) ) );
	
		$wp_customize->add_setting( 'surfarama_twitter', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_twitter', array(
			'label'    => __( 'Enter your Twitter url', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_twitter',
			'priority'    => 102,
		) ) );
		
		$wp_customize->add_setting( 'surfarama_google', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_google', array(
			'label'    => __( 'Enter your Google+ url', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_google',
			'priority'    => 103,
		) ) );
		
		$wp_customize->add_setting( 'surfarama_pinterest', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_pinterest', array(
			'label'    => __( 'Enter your Pinterest url', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_pinterest',
			'priority'    => 104,
		) ) );
		
		$wp_customize->add_setting( 'surfarama_linkedin', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_linkedin', array(
			'label'    => __( 'Enter your Linkedin url', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_linkedin',
			'priority'    => 105,
		) ) );
		
		$wp_customize->add_setting( 'surfarama_youtube', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_youtube', array(
			'label'    => __( 'Enter your Youtube url', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_youtube',
			'priority'    => 106,
		) ) );
		
		$wp_customize->add_setting( 'surfarama_tumblr', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_tumblr', array(
			'label'    => __( 'Enter your Tumblr url', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_tumblr',
			'priority'    => 107,
		) ) );
		
		$wp_customize->add_setting( 'surfarama_instagram', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_instagram', array(
			'label'    => __( 'Enter your Instagram url', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_instagram',
			'priority'    => 108,
		) ) );
		
		$wp_customize->add_setting( 'surfarama_flickr', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_flickr', array(
			'label'    => __( 'Enter your Flickr url', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_flickr',
			'priority'    => 109,
		) ) );
		
		$wp_customize->add_setting( 'surfarama_vimeo', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_vimeo', array(
			'label'    => __( 'Enter your Vimeo url', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_vimeo',
			'priority'    => 110,
		) ) );
		
		$wp_customize->add_setting( 'surfarama_yelp', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_yelp', array(
			'label'    => __( 'Enter your Yelp url', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_yelp',
			'priority'    => 111,
		) ) );
		
		$wp_customize->add_setting( 'surfarama_rss', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_rss', array(
			'label'    => __( 'Enter your RSS url', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_rss',
			'priority'    => 112,
		) ) );
		
		$wp_customize->add_setting( 'surfarama_email', array (
			'sanitize_callback' => 'sanitize_email',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_email', array(
			'label'    => __( 'Enter your email address', 'surfarama' ),
			'section'  => 'surfarama_social_section',
			'settings' => 'surfarama_email',
			'priority'    => 113,
		) ) );
		
		
		/* category link in homepage option */
		$wp_customize->add_section( 'surfarama_cat_section' , array(
			'title'       => __( 'Display Category Link', 'surfarama' ),
			'priority'    => 34,
			'description' => __( 'Option to show/hide the category link in the homepage/category grid posts.', 'surfarama' ),
		) );
		
		$wp_customize->add_setting( 'surfarama_cat_show_link', array (
			'sanitize_callback' => 'surfarama_sanitize_checkbox',
		) );
		
		 $wp_customize->add_control('cat_show_link', array(
			'settings' => 'surfarama_cat_show_link',
			'label' => __('Show the categories links on homepage?', 'surfarama'),
			'section' => 'surfarama_cat_section',
			'type' => 'checkbox',
		));
		
		/* image border option */
		$wp_customize->add_section( 'surfarama_imgborder_section' , array(
			'title'       => __( 'Set Border For Images', 'surfarama' ),
			'priority'    => 34,
			'description' => __( 'Option to set a border (in pixels) for the homepage images.', 'surfarama' ),
		) );
		
		$wp_customize->add_setting( 'surfarama_imgborder', array (
			'sanitize_callback' => 'surfarama_sanitize_integer',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'surfarama_imgborder', array(
			'label'    => __( 'Set the image border (in pixels)', 'surfarama' ),
			'section'  => 'surfarama_imgborder_section',
			'settings' => 'surfarama_imgborder',
		) ) );
		
	}
	
endif;
add_action('customize_register', 'surfarama_theme_customizer');


/**
 * Sanitize checkbox
 */
if ( ! function_exists( 'surfarama_sanitize_checkbox' ) ) :
	function surfarama_sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		} else {
			return '';
		}
	}
endif;


/**
 * Sanitize integer input
 */
if ( ! function_exists( 'surfarama_sanitize_integer' ) ) :
	function surfarama_sanitize_integer( $input ) {
		return absint($input);
	}
endif;


$surfarama_counter = 1;

/**
* Apply Color Scheme
*/
if ( ! function_exists( 'surfarama_customize_options' ) ) :

	function surfarama_customize_options() { ?>
	 <style id="surfarama-styles" type="text/css">
	 <?php
	 if ( get_theme_mod('surfarama_title_color') ) { ?>
	 #site-title a { color: <?php echo get_theme_mod('surfarama_title_color'); ?>; }
	 <?php }
	 
	 if ( get_theme_mod('surfarama_color') ) { ?>
	.post_content a, .post_content a:visited, .cycle-pager span.cycle-pager-active, .post_content ul li:before, .post_content ol li:before, .colortxt { color: <?php echo get_theme_mod('surfarama_color'); ?>; }
	#search-box-wrap, #search-icon,	nav[role=navigation] .menu ul li a:hover, nav[role=navigation] .menu ul li.current-menu-item a, .nav ul li.current_page_item a, nav[role=navigation] .menu ul li.current_page_item a, .meta-by, .meta-on, .meta-com, .grid-box, .grid-box .cat-links, .pagination a:hover, .pagination .current, .cat-meta-color, .colorbar, #respond #submit { background-color: <?php echo get_theme_mod('surfarama_color'); ?>; }
	.pagination a:hover, .pagination .current, footer[role=contentinfo] a {	color: #fff; }
	#sidebar .widget, #sidebar-home .widget { border-top-color: <?php echo get_theme_mod('surfarama_color'); ?>; }
	<?php }
	if ( get_theme_mod('surfarama_link_color') ) { ?>
	.post_content a, .post_content a:visited { color: <?php echo get_theme_mod('surfarama_link_color'); ?>; }
	<?php }
	if ( get_theme_mod('surfarama_meta_color') ) { ?>
	.entry-meta a, .category-archive-meta, .category-archive-meta a, .commentlist .vcard time a, .comment-meta a, #respond .comment-notes, #respond .logged-in-as { color: <?php echo get_theme_mod('surfarama_meta_color'); ?>; }
	<?php }
	if ( get_theme_mod('surfarama_text_color') ) { ?>
	body, .entry-meta, #comment-nav-above a, #comment-nav-below a, #nav-above a, #nav-below a, #image-navigation a, #sidebar .widget a, #sidebar-home .widget a, #respond a, #site-generator, #site-generator a { color: <?php echo get_theme_mod('surfarama_text_color'); ?>; }
	<?php }
	if ( get_theme_mod('surfarama_nav_color') ) { ?>
	nav[role=navigation] div.menu, .pagination span, .pagination a, #sidebar .widget-title, #sidebar-home .widget-title { background-color: <?php echo get_theme_mod('surfarama_nav_color'); ?>; }
	#sidebar .widget, #sidebar-home .widget { border-left-color: <?php echo get_theme_mod('surfarama_nav_color'); ?>; border-right-color: <?php echo get_theme_mod('surfarama_nav_color'); ?>; border-bottom-color: <?php echo get_theme_mod('surfarama_nav_color'); ?>; }
	footer[role=contentinfo] { border-top-color: <?php echo get_theme_mod('surfarama_nav_color'); ?>; }
	<?php }
	if ( get_theme_mod('surfarama_cat_show_link') ) { ?>
	.grid-box .cat-links { display: block; }
	.grid-box-noimg { height: auto; min-height: 30px; }
	<?php }
	if ( get_theme_mod('surfarama_imgborder') ) { ?>
	.grid-box article[id*=post-] { padding: <?php echo get_theme_mod('surfarama_imgborder'); ?>px; }
	<?php } 

	?>
     </style>
	<?php
	}
endif;
add_action( 'wp_head', 'surfarama_customize_options' );


/**
 * Title filter 
 */
if ( ! function_exists( 'surfarama_filter_wp_title' ) ) :
	function surfarama_filter_wp_title( $old_title, $sep, $sep_location ) {
		
		if ( is_feed() ) return $old_title;
	
		$site_name = get_bloginfo( 'name' );
		$site_description = get_bloginfo( 'description' );
		// add padding to the sep
		$ssep = ' ' . $sep . ' ';
		
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			return $site_name . ' | ' . $site_description;
		} else {
			// find the type of index page this is
			if( is_category() ) $insert = $ssep . __( 'Category', 'surfarama' );
			elseif( is_tag() ) $insert = $ssep . __( 'Tag', 'surfarama' );
			elseif( is_author() ) $insert = $ssep . __( 'Author', 'surfarama' );
			elseif( is_year() || is_month() || is_day() ) $insert = $ssep . __( 'Archives', 'surfarama' );
			else $insert = NULL;
			 
			// get the page number we're on (index)
			if( get_query_var( 'paged' ) )
			$num = $ssep . __( 'Page ', 'surfarama' ) . get_query_var( 'paged' );
			 
			// get the page number we're on (multipage post)
			elseif( get_query_var( 'page' ) )
			$num = $ssep . __( 'Page ', 'surfarama' ) . get_query_var( 'page' );
			 
			// else
			else $num = NULL;
			 
			// concoct and return new title
			return $site_name . $insert . $old_title . $num;
			
		}
	
	}
endif;
// call our custom wp_title filter, with normal (10) priority, and 3 args
add_filter( 'wp_title', 'surfarama_filter_wp_title', 10, 3 );


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
if ( ! function_exists( 'surfarama_main_nav' ) ) :
function surfarama_main_nav() {
	// display the wp3 menu if available
    wp_nav_menu( 
    	array( 
    		'menu' => '', /* menu name */
    		'theme_location' => 'primary', /* where in the theme it's assigned */
    		'container_class' => 'menu', /* container class */
    		'fallback_cb' => 'surfarama_main_nav_fallback' /* menu fallback */
    	)
    );
}
endif;

if ( ! function_exists( 'surfarama_main_nav_fallback' ) ) :
	function surfarama_main_nav_fallback() { wp_page_menu( 'show_home=Home&menu_class=menu' ); }
endif;

if ( ! function_exists( 'surfarama_enqueue_comment_reply' ) ) :
	function surfarama_enqueue_comment_reply() {
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
					wp_enqueue_script( 'comment-reply' );
			}
	 }
endif;
add_action( 'comment_form_before', 'surfarama_enqueue_comment_reply' );

if ( ! function_exists( 'surfarama_page_menu_args' ) ) :
	function surfarama_page_menu_args( $args ) {
		$args['show_home'] = true;
		return $args;
	}
endif;
add_filter( 'wp_page_menu_args', 'surfarama_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */

function surfarama_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Home Page Widgets', 'surfarama' ),
		'id' => 'sidebar-home',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="widget-title">',
		'after_title' => '</div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Category/Archive Widgets', 'surfarama' ),
		'id' => 'sidebar-archive',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="widget-title">',
		'after_title' => '</div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Post Widgets', 'surfarama' ),
		'id' => 'sidebar-post',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="widget-title">',
		'after_title' => '</div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Page Widgets', 'surfarama' ),
		'id' => 'sidebar-page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="widget-title">',
		'after_title' => '</div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Full Page Widgets', 'surfarama' ),
		'id' => 'sidebar-full',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="widget-title">',
		'after_title' => '</div>',
	) );

}

add_action( 'widgets_init', 'surfarama_widgets_init' );

if ( ! function_exists( 'surfarama_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 */
function surfarama_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'surfarama' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr; Previous', 'Previous post link', 'surfarama' ) . '</span>' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '<span class="meta-nav">' . _x( 'Next &rarr;', 'Next post link', 'surfarama' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'surfarama' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'surfarama' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif;


if ( ! function_exists( 'surfarama_comment' ) ) :
/**
 * Template for comments and pingbacks.
 */
function surfarama_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'surfarama' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'surfarama' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>">
			<footer class="clearfix comment-head">
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s', 'surfarama' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'surfarama' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'surfarama' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'surfarama' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif;

if ( ! function_exists( 'surfarama_recent_comments' ) ) :
	function surfarama_recent_comments($no_comments = 10, $comment_len = 80, $avatar_size = 48) {
		$comments_query = new WP_Comment_Query();
		$comments = $comments_query->query( array( 'number' => $no_comments ) );
		$comm = '';
		if ( $comments ) : foreach ( $comments as $comment ) :
		$comm .= '<li>';
		$comm .= '<a class="author" href="' . get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID . '"><strong>';		$comm .= get_comment_author( $comment->comment_ID ) . ':</strong></a> ';

		$comm .= strip_tags( substr( apply_filters( 'get_comment_text', $comment->comment_content ), 0, $comment_len ) ) . '</li>';
		endforeach; else :
		$comm .= 'No comments.';
		endif;
		echo $comm;	
	}
endif;

if ( ! function_exists( 'surfarama_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function surfarama_posted_on() {
	printf( __( '<span class="sep meta-by">Author </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span><span class="byline"> <span class="sep meta-on"> Date </span> <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>', 'surfarama' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'surfarama' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Adds custom classes to the array of body classes.
 */
if ( ! function_exists( 'surfarama_body_classes' ) ) :
	function surfarama_body_classes( $classes ) {
		// Adds a class of single-author to blogs with only 1 published author
		if ( ! is_multi_author() ) {
			$classes[] = 'single-author';
		}
	
		return $classes;
	}
endif;
add_filter( 'body_class', 'surfarama_body_classes' );

/**
 * Returns true if a blog has more than 1 category
 */
if ( ! function_exists( 'surfarama_categorized_blog' ) ) :
function surfarama_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so surfarama_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so surfarama_categorized_blog should return false
		return false;
	}
}
endif;
/**
 * Flush out the transients used in surfarama_categorized_blog
 */
if ( ! function_exists( 'surfarama_category_transient_flusher' ) ) :
	function surfarama_category_transient_flusher() {
		// Like, beat it. Dig?
		delete_transient( 'all_the_cool_cats' );
	}
endif;
add_action( 'edit_category', 'surfarama_category_transient_flusher' );
add_action( 'save_post', 'surfarama_category_transient_flusher' );

/**
 * Remove WP default gallery styling
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
if ( ! function_exists( 'surfarama_enhanced_image_navigation' ) ) :
	function surfarama_enhanced_image_navigation( $url ) {
		global $post, $wp_rewrite;
	
		$id = (int) $post->ID;
		$object = get_post( $id );
		if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
			$url = $url . '#main';
	
		return $url;
	}
endif;
add_filter( 'attachment_link', 'surfarama_enhanced_image_navigation' );

/**
 * Adds color picker meta field to categories
 */
if ( ! function_exists( 'surfarama_cat_add_color' ) ) :
function surfarama_cat_add_color() {
	// this will add the custom meta field to the add new term page
	?>
	<div class="form-field">
		<label for="term_meta[cat_color]"><?php _e( 'Category Color', 'surfarama' ); ?></label>
		<input type="text" name="term_meta[cat_color]" id="term_meta[cat_color]" value="" class="surfarama-color-field" />
		<p class="description"><?php _e( 'Choose Color for this Category','surfarama' ); ?></p>
	</div>
<?php
}
endif;
add_action( 'category_add_form_fields', 'surfarama_cat_add_color', 10, 2 );

if ( ! function_exists( 'surfarama_cat_edit_color' ) ) :
function surfarama_cat_edit_color($term) {
 
	// put the term ID into a variable
	$t_id = $term->term_id;
 
	// retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option( "taxonomy_$t_id" ); ?>
	<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[cat_color]"><?php _e( 'Category Color', 'surfarama' ); ?></label></th>
		<td>
			<input type="text" name="term_meta[cat_color]" id="term_meta[cat_color]" value="<?php echo esc_attr( $term_meta['cat_color'] ) ? esc_attr( $term_meta['cat_color'] ) : ''; ?>" class="surfarama-color-field" />
			<p class="description"><?php _e( 'Choose Color for this Category','surfarama' ); ?></p>
		</td>
	</tr>
<?php
}
endif;
add_action( 'category_edit_form_fields', 'surfarama_cat_edit_color', 10, 2 );

// Save category color.
if ( ! function_exists( 'surfarama_save_cat_color' ) ) :
	function surfarama_save_cat_color( $term_id ) {
		if ( isset( $_POST['term_meta'] ) ) {
			$t_id = $term_id;
			$term_meta = get_option( "taxonomy_$t_id" );
			$cat_keys = array_keys( $_POST['term_meta'] );
			foreach ( $cat_keys as $key ) {
				if ( isset ( $_POST['term_meta'][$key] ) ) {
					$term_meta[$key] = $_POST['term_meta'][$key];
				}
			}
			// Save the option array.
			update_option( "taxonomy_$t_id", $term_meta );
		}
	}  
endif;
add_action( 'edited_category', 'surfarama_save_cat_color', 10, 2 );  
add_action( 'create_category', 'surfarama_save_cat_color', 10, 2 );

/*************************************************************************/


/**
 * Surfarama pagination
 */
if ( ! function_exists( 'surfarama_pagination' ) ) :
function surfarama_pagination($pages = '', $range = 4)
{
     $showitems = ($range * 2)+1; 
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
 
     if(1 != $pages)
     {
         printf( __( '<div class="pagination"><span>Page %1$s of %2$s</span>', 'surfarama'), $paged, $pages );
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) printf( __( '<a href="%1$s">&laquo; First</a>', 'surfarama' ), get_pagenum_link(1) );
         if($paged > 1 && $showitems < $pages) printf( __( '<a href="%1$s">&lsaquo; Previous</a>', 'surfarama' ), get_pagenum_link($paged - 1) );
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) printf( __( '<a href="%1$s">Next &rsaquo;</a>', 'surfarama' ), get_pagenum_link($paged + 1) );
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) printf( __( '<a href="%1$s">Last &raquo;</a>', 'surfarama' ), get_pagenum_link($pages) );
         echo "</div>\n";
     }
}
endif;

if ( ! function_exists( 'surfarama_excerpt' ) ) :
	function surfarama_excerpt($limit) {
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
		} else {
		$excerpt = implode(" ",$excerpt);
		}	
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
		return $excerpt;
	}
endif;

if ( ! function_exists( 'surfarama_w3c_valid_rel' ) ) :
	function surfarama_w3c_valid_rel( $text ) {
		$text = str_replace('rel="category tag"', 'rel="tag"', $text); return $text; 
	}
endif;
add_filter( 'the_category', 'surfarama_w3c_valid_rel' );

if ( ! function_exists( 'surfarama_modernizr_addclass' ) ) :
	function surfarama_modernizr_addclass($output) {
		return $output . ' class="no-js"';
	}
endif;
add_filter('language_attributes', 'surfarama_modernizr_addclass');

if ( ! function_exists( 'surfarama_modernizr_script' ) ) :
	function surfarama_modernizr_script() {
		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/library/js/modernizr-2.6.2.min.js', false, '2.6.2');
	}  
endif;  
add_action('wp_enqueue_scripts', 'surfarama_modernizr_script');


if ( ! function_exists( 'surfarama_custom_scripts' ) ) :
	function surfarama_custom_scripts() {
		wp_register_script( 'imagesloaded', get_template_directory_uri() . '/library/js/imagesloaded.pkgd.min.js');
		wp_register_script( 'masonry', get_template_directory_uri() . '/library/js/masonry.pkgd.min.js');
		wp_enqueue_script( 'surfarama_custom_js', get_template_directory_uri() . '/library/js/scripts.js', array( 'jquery', 'masonry', 'imagesloaded' ), '1.0.0' );
		wp_enqueue_style( 'surfarama_style', get_stylesheet_uri() );
	}
endif;
add_action('wp_enqueue_scripts', 'surfarama_custom_scripts');


if ( ! function_exists( 'surfarama_enqueue_color_picker' ) ) :
	function surfarama_enqueue_color_picker( $hook_suffix ) {
		// first check that $hook_suffix is appropriate for your admin page
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'surfarama-color-picker', get_template_directory_uri() . '/library/js/scripts-admin.js', array( 'wp-color-picker' ), false, true );
	}
endif;
add_action( 'admin_enqueue_scripts', 'surfarama_enqueue_color_picker' );



/**
 * Get Embed Video for post format video
 */
if ( ! function_exists('surfarama_featured_video') ) :
	function surfarama_featured_video( &$content ) {
		$url = trim( array_shift( explode( "\n", $content ) ) );
		$w = get_option( 'embed_size_w' );
		if ( !is_single() )
		$url = str_replace( '448', $w, $url );
		
		if ( ( 0 === strpos( $url, 'http://' ) ) || ( 0 === strpos( $url, 'https://' ) ) || ( 0 === strpos( $url, '//www' ) ) ) {
			 echo apply_filters( 'the_content', $url );
			 $content = trim( str_replace( $url, '', $content ) ); 
			 } else if ( preg_match ( '#^<(script|iframe|embed|object)#i', $url ) ) {
			 $h = get_option( 'embed_size_h' );
			 if ( !empty( $h ) ) {
			 if ( $w === $h ) $h = ceil( $w * 0.75 );
			
			 $url = preg_replace( 
			 array( '#height="[0-9]+?"#i', '#height=[0-9]+?#i' ), 
			 array( sprintf( 'height="%d"', $h ), sprintf( 'height=%d', $h ) ), 
			 $url 
			 );
		 }
		
		echo $url;
			$content = trim( str_replace( $url, '', $content ) ); 
		}
	}
endif;
?>