<?php
/* Register and render a metabox for the Wordnik Lookup */
class WordnikLookupMetabox {
  public function __construct() {
    add_action( 'add_meta_boxes', array($this, 'add_meta_box_wordnik_lookup') );
    add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts'), 10, 1 );

  } 

  public function enqueue_scripts($hook) {
    if( $hook == 'post-new.php' || $hook == 'post.php' ) {
      global $chorus_config;
      $assetsHost  = $chorus_config['assets_host'];
      
      $wp_main_js  = $chorus_config['assets_host'] . '/wp_authoring.js';
      $wp_main_css = $chorus_config['assets_host'] . '/wp_authoring.css';
      $chorus_admin_css =  CHORUS_PLUGIN_URL . '/stylesheets/chorus-admin.css';
      # shouldn't enqueue here ...
      # wp_enqueue_script('wp_main_js',  $wp_main_js, array( 'jquery-ui-tabs') );
      wp_enqueue_style( 'wp_main_css', $wp_main_css);

      $name = 'wp_main_js';
      wp_register_script( $name, $wp_main_js, array( 'jquery-ui-tabs'));
      wp_enqueue_script( $name );

      $wp_chorus_config = WordnikChorus::create_wp_chorus_config();    
      wp_localize_script($name, 'wpChorusConfig', $wp_chorus_config);
    }
  }

  /**
   * Add the meta box
   */
  public function add_meta_box_wordnik_lookup() {
    // add_meta_box( $id, $title, $callback, $post_type, $context, $priority, $callback_args );    
    add_meta_box( 'wordnik_lookup', __('Lookup by Wordnik', 'lookup'), array($this, 'render_wordnik_lookup_meta_box'), 'post', 'normal');
    add_meta_box( 'wordnik_lookup', __('Lookup by Wordnik', 'lookup'), array($this, 'render_wordnik_lookup_meta_box'), 'page', 'normal');
  }

  /* Render the HTML for the Meta box in WP write/edit screen */
  function render_wordnik_lookup_meta_box() {
    include 'views/wordnik_lookup.php';
  }

}