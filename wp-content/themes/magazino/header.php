<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php wp_title('|', true, 'left'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="container">
	
    <div id="search-box-wrap">
        <div id="search-box">
           <div id="close-x"><?php _e( 'x', 'magazino' ); ?></div>
           <?php get_search_form(); ?>
        </div>
    </div>

	<header id="branding" role="banner">
      <div id="inner-header" class="clearfix">
		<div id="site-heading">
        	<?php if ( get_theme_mod( 'magazino_logo' ) ) : ?>
            <div id="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_theme_mod( 'magazino_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a></div>
            <?php else : ?>
			<div id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
            <?php endif; ?>
		</div>
        
        <div id="social-media" class="clearfix">
        
        	<?php if ( get_theme_mod( 'magazino_facebook' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_facebook' ) ); ?>" class="social-fb" title="<?php echo esc_url( get_theme_mod( 'magazino_facebook' ) ); ?>"><?php _e('Facebook', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_twitter' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_twitter' ) ); ?>" class="social-tw" title="<?php echo esc_url( get_theme_mod( 'magazino_twitter' ) ); ?>"><?php _e('Twitter', 'magazino') ?></a>
            <?php endif; ?>
			
            <?php if ( get_theme_mod( 'magazino_google' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_google' ) ); ?>" class="social-gp" title="<?php echo esc_url( get_theme_mod( 'magazino_google' ) ); ?>"><?php _e('Google+', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_pinterest' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_pinterest' ) ); ?>" class="social-pi" title="<?php echo esc_url( get_theme_mod( 'magazino_pinterest' ) ); ?>"><?php _e('Pinterest', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_linkedin' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_linkedin' ) ); ?>" class="social-li" title="<?php echo esc_url( get_theme_mod( 'magazino_linkedin' ) ); ?>"><?php _e('Linkedin', 'magazino') ?></a>
            <?php endif; ?>
            
			<?php if ( get_theme_mod( 'magazino_youtube' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_youtube' ) ); ?>" class="social-yt" title="<?php echo esc_url( get_theme_mod( 'magazino_youtube' ) ); ?>"><?php _e('Youtube', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_tumblr' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_tumblr' ) ); ?>" class="social-tu" title="<?php echo esc_url( get_theme_mod( 'magazino_tumblr' ) ); ?>"><?php _e('Tumblr', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_instagram' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_instagram' ) ); ?>" class="social-in" title="<?php echo esc_url( get_theme_mod( 'magazino_instagram' ) ); ?>"><?php _e('Instagram', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_flickr' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_flickr' ) ); ?>" class="social-fl" title="<?php echo esc_url( get_theme_mod( 'magazino_flickr' ) ); ?>"><?php _e('Instagram', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_vimeo' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_vimeo' ) ); ?>" class="social-vi" title="<?php echo esc_url( get_theme_mod( 'magazino_vimeo' ) ); ?>"><?php _e('Vimeo', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_yelp' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_yelp' ) ); ?>" class="social-ye" title="<?php echo esc_url( get_theme_mod( 'magazino_yelp' ) ); ?>"><?php _e('Yelp', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_rss' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_rss' ) ); ?>" class="social-rs" title="<?php echo esc_url( get_theme_mod( 'magazino_rss' ) ); ?>"><?php _e('RSS', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_email' ) ) : ?>
            <a href="<?php _e('mailto:', 'magazino'); echo sanitize_email( get_theme_mod( 'magazino_email' ) ); ?>" class="social-em" title="<?php _e('mailto:', 'magazino'); echo sanitize_email( get_theme_mod( 'magazino_email' ) ); ?>"><?php _e('Email', 'magazino') ?></a>
            <?php endif; ?>
            
            <div id="search-icon"></div>
            
        </div>
        
      </div>

		<nav id="access" class="clearfix" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Main menu', 'magazino' ); ?></h1>
			<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'magazino' ); ?>"><?php _e( 'Skip to content', 'magazino' ); ?></a></div>
			<?php magazino_main_nav(); // Adjust using Menus in Wordpress Admin ?>
			<?php //get_search_form(); ?>
		</nav><!-- #access -->

	</header><!-- #branding -->
