<?php
/**
 * @package Chorus
 * @version 0.6.11
 */
/*
Plugin Name: Reverb for Publishers
Plugin URI: http://wordpress.wordnik.com
Description: Reverb for Publishers is the fastest, most intelligent way to show related content on your blog with thumbnail images or plain text.
Author: wordnik
Version: 0.6.11
Author URI: http://www.helloreverb.com
*/
if(!defined('CHORUS_PLUGIN_PATH'))    define( 'CHORUS_PLUGIN_PATH', plugin_dir_path(__FILE__) );
if(!defined('CHORUS_PLUGIN_URL'))     define( 'CHORUS_PLUGIN_URL',  plugin_dir_url(__FILE__));
if(!defined('CHORUS_BUILD_VERSION'))  define( 'CHORUS_BUILD_VERSION', '0.6.11');
if(!defined('NIKIO_API_KEY'))         define( 'NIKIO_API_KEY',"wordnik-nikio-api-key");
if(!defined('MANIFEST_KEY'))          define( 'MANIFEST_KEY',"wordnik-manifest-key");

require_once 'utils.php';
require_once "environment.php";
require_once 'chorus_discovery_metabox.php';
require_once 'wordnik_lookup_metabox.php';
require_once 'chorus_inline_discovery.php';
require_once 'concept_cloud.php';
require_once 'trending_widget.php';

class WordnikChorus {

  public function __construct() {
    register_activation_hook(__FILE__, array($this, 'register_site'));
    register_deactivation_hook(__FILE__, array($this, 'deactivate_site'));

    # Inject Chorus JavaScript into the page.
    add_action('wp_head',     array($this, 'inject_chorus'));
    // Wrap the content in article tags for full content and excerpts
    add_filter('the_content', array($this, 'wrap_in_article_tags'));
    add_filter('the_excerpt', array($this, 'wrap_in_article_tags'));


    # plugin settings
    add_filter("plugin_action_links_" . plugin_basename( __FILE__ ), array($this, 'chorus_settings_link' ));
    add_action('admin_menu',  array($this, 'chorus_admin_menu_link'));

    add_action('trash_post', array($this, 'notify_trashed_post'));

    # For admin, we add the metaboxes
    if(is_admin()) {
      new ChorusDiscoveryMetabox();
    }
    
    new ChorusInlineDiscovery();
  }

  public function notify_trashed_post($post_id) {
    // chorus_log("Trashed post id is " . $post_id);
    
    $permalink = get_permalink($post_id);
    // chorus_log("Permalink of post is " . $permalink);

    $api_key = get_option(NIKIO_API_KEY, 'invalid');
    // chorus_log("API key is " . $api_key);

    $base_url = $this->get_base_url();        
    $url = $base_url . 'site.json/deleteDocument?permalink=' . urlencode($permalink);
    // chorus_log("URL to delete is " . $url);

    $response = wp_remote_post($url, array(
      'method'        => 'DELETE',
      'timeout'       => 45,
      'redirection'   => 5,
      'httpversion'   => '1.0',
      'blocking'      => true,
      'headers'       => array('content-type' => 'application/json', 'api_key' => $api_key),
      'cookies'       => array()
      )
    );
    
    if(!$this->handle_error($url, $response)) {
      chorus_log("Error notifying plugin of a trashed post " . $permalink);
      return;
    }

    // chorus_log($response);
  }

  public function get_latest_post() {
    $recent_posts = wp_get_recent_posts('numberposts=1');
    if(sizeof($recent_posts) > 0) {
      $latest_post = current($recent_posts);
      $latest_post_permalink = get_permalink($latest_post["ID"]);
      return $latest_post_permalink;
    } else {
      return home_url();
    }
  }

  public function wrap_in_article_tags($content) {
    // only show on single post/page
    if(!is_single()) return $content;

    // Latest post 
    $recent_posts = wp_get_recent_posts('numberposts=1');
    $latest_post = current($recent_posts);
    $latest_post_permalink = get_permalink($latest_post["ID"]);
    
    // Current post details
    $id = get_the_ID();
    $post = get_post($id);
    $title = $post->post_title;
    $last_modified_date = $post->post_modified_gmt;

    $current_post_permalink = get_permalink($id);
    $user_logged_in = is_user_logged_in();

    // Categories
    $categories_array = array();
    foreach((get_the_category($id)) as $category) { 
      array_push($categories_array, $category->cat_name);
    }
    $categories = implode("~", $categories_array);

    // Tags
    $tagsArray = array();
    $post_tags = get_the_tags($id);
    if($post_tags) {
      foreach(($post_tags) as $tag) { 
        array_push($tagsArray, $tag->name);
      }
    }
    $tags = implode("~", $tagsArray);
    
    return <<<HTM
      <article itemscope itemtype="http://nik.io/v1/schema/Article">
      <span itemprop="lastModifiedDate" content="$last_modified_date"></span><span itemprop="title" content="$title"></span><span itemprop="categories" content="$categories"></span><span itemprop="tags" content="$tags"></span><span itemprop="srcType" content="wordpress.org"></span><span itemprop="permalink" content="$current_post_permalink"></span><span id= "wpLogin" itemprop="wpLogin" content="$user_logged_in"></span>$content
      </article>
HTM;
  }

  public function chorus_settings_link($links) { 
    $settings_link = '<a href="options-general.php?page=chorus.php">Settings</a>';
    array_unshift($links, $settings_link); 
    return $links;
  }

  // Add link to chorus options page
  public function chorus_admin_menu_link() {
    $page = add_options_page('Related Content by Wordnik Options', 'Related Content by Wordnik', 'manage_options', basename(__FILE__), array($this,'render_chorus_options'));
    add_action( "admin_print_scripts-$page", array($this, 'chorus_settings_register_scripts'));
    add_action( "admin_print_styles-$page",  array($this, 'chorus_settings_register_styles'));

    // <?php add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    $page = $mainsectionpage = add_menu_page(
      __('Dashboard','wordnik_chorus'),           # title 
      "Reverb for Publishers",                          # menu-title 
      'manage_options',                           # capability 
      'chorus',                                   # menu slug
      array($this,'render_chorus_options'),       # function
      CHORUS_PLUGIN_URL . '/images/menu_logo.png');

    add_action( "admin_print_scripts-$page", array($this, 'chorus_settings_register_scripts'));
    add_action( "admin_print_styles-$page",  array($this, 'chorus_settings_register_styles'));

  } 

  public function chorus_settings_register_styles() {
    global $chorus_config;
    $assetsHost  = $chorus_config['assets_host'];
    
    $wp_settings_css = $chorus_config['assets_host'] . '/wp_settings.css';
    wp_enqueue_style( 'wp_setttings_css', $wp_settings_css);    
  } 

  public function chorus_settings_register_scripts() {
    global $chorus_config;
    $assetsHost  = $chorus_config['assets_host'];
    
    $chorus_js  = $chorus_config['assets_host'] . '/chorus.js';

    $name = 'chorus_js';
    wp_register_script( $name, $chorus_js, array( 'jquery-ui-tabs'));
    wp_enqueue_script( $name );

    $wp_chorus_config = WordnikChorus::create_wp_chorus_config();
    $wp_chorus_config['blogName'] = get_bloginfo('name');
    $wp_chorus_config['blogUrl'] = home_url();
    $wp_chorus_config['blogDescription'] = get_bloginfo('description');
    $wp_chorus_config['blogPublishedPosts'] = wp_count_posts()->publish;
    $wp_chorus_config['latestBlogPostUrl'] = $this->get_latest_post();
    $wp_chorus_config['settingsPage'] = true;
    
    wp_localize_script($name, 'wpChorusConfig', $wp_chorus_config);
  } 

  /**
   * Render the Sign Up Page (after user has activated the plugin)
   */
  public function render_chorus_options() {
    global $chorus_config;
    include "views/chorus_sign_up.php";
  }

  /**
   * Inject the chorus js into the page.
   */
  public static function inject_chorus() {
    global $chorus_config;
    $assets_host  = $chorus_config['assets_host'];    
    $nikio_host  = $chorus_config['nikio_host'];
    $myLink = get_permalink();
    $apiKey = get_option(NIKIO_API_KEY, 'invalid');
    $topScriptSrc = $assets_host.'/related_content.js';

    $wp_chorus_config = WordnikChorus::create_wp_chorus_config();

    $wp_chorus_config = json_encode($wp_chorus_config);

    echo <<<JS
      <script type='text/javascript'>
      var wordnikChorus = {};

      (function() {

        window.wpChorusConfig = $wp_chorus_config;

        wordnikChorus.getRecsEndpoint = "http://$nikio_host/api/recommendation.json/byUrl";
        wordnikChorus.apiKey ="$apiKey";
        wordnikChorus.permalink = "$myLink";
        wordnikChorus.baseApiUrl = "http://$nikio_host";
        window.chorusGenesisTime = new Date();

        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.async = 'async';        
        script.src = '$topScriptSrc';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(script, s);
      })();
      </script>
JS;
  }

  public static function create_wp_chorus_config() {
    global $chorus_config;
    $nikio_host       = $chorus_config['nikio_host'];
    $assets_host      = $chorus_config['assets_host'];

    $user_logged_in   = is_user_logged_in();
    $admin_user       = current_user_can('administrator');
    $api_key          = get_option(NIKIO_API_KEY, 'invalid');
    $manifest_key     = get_option(MANIFEST_KEY, '');

    $wp_chorus_config = array(
      "version"           => CHORUS_BUILD_VERSION,
      "wpVersion"         => get_bloginfo('version'),
      "wpTheme"           => get_template(),
      "wpSiteUrl"         => site_url(),
      "wpHomeUrl"         => home_url(),
      "apiHost"           => $nikio_host,
      "apiUrl"            => "http://$nikio_host",
      "apiKey"            => $api_key,
      "manifestKey"       => $manifest_key,
      "assetUrl"          => $assets_host,
      "siteUrl"           => home_url(),
      "isWordPressStaff"  => $user_logged_in,
      "isWordPressAdmin"  => $admin_user,
      "wpLang"            => WPLANG

    );

    if($admin_user) {
      $wp_chorus_config['_wpnonce'] = wp_create_nonce('chorus');
    }

    return $wp_chorus_config;
  }

  # ##########################################################
  # Registration
  # ##########################################################  

  function deactivate_site() {
    if(function_exists('wp_remote_get')) {
      // If all outgoing HTTP requests are NOT blocked by the server. 
      $site_url = home_url();
      $api_key = get_option(NIKIO_API_KEY, 'invalid');
      $this->deactivate_site_by_url($this->get_base_url() . 'site.json/deactivateSite?url=' . urlencode($site_url), $api_key);

      delete_option(NIKIO_API_KEY);
    }
  }

  function register_site() {
    if(!function_exists('wp_remote_get')) {
      // It is ok. We will register the site from the sign up the screen. Registering via PHP
      // is just to jump start processing.

      // It is also ok if there is an exception when registering the site. Again, we will try to register
      // the site in the sign up screen if it fails here.

      // This can happen if all outgoing HTTP requests are blocked by the server.
      return;
    }

    $base_url = $this->get_base_url();        
    $url = $base_url . 'sites.json/create';
    $site_config = $this->get_site_config();
    
    // Register the site with the server
    $response = wp_remote_post($url, array(
      'method'        => 'POST',
      'timeout'       => 45,
      'redirection'   => 5,
      'httpversion'   => '1.0',
      'blocking'      => true,
      'headers'       => array('content-type' => 'application/json'),
      'body'          => json_encode($site_config),
      'cookies'       => array()
      )
    );
    
    if(!$this->handle_error($url, $response)) {
      return;
    }

    // chorus_log($response);

    $api_key = $this->extract_api_key_and_persist($response);

    // BEGIN - POST URLS to the server
    $startTime = $this->millitime();
    global $wpdb;

    $postID = $wpdb->get_col("
      SELECT ID FROM $wpdb->posts
      WHERE (post_type = 'post')
      AND (post_status = 'publish')
      AND (post_password = '')
      ORDER BY post_date desc
    ");

    $all_urls =  array();
    foreach($postID as $post_link) {
      $permalink = get_permalink($post_link);
      array_push($all_urls, $permalink);
      if(count($all_urls) >= 1000) {
        break;
      }
    }

    // chorus_log("All urls length is " . count($allUrls));
    $this->post_urls($base_url . 'site.json/addSiteDocUrls?siteUrl=' . urlencode($site_config['url']), $api_key, $all_urls);

    //chorus_log("Total Time taken to get all the URLs of the blog is " . ($this->millitime() - $startTime));
  }

  function get_base_url() {
    global $chorus_config;
    # re-include the enviroment.php again since register_site hook
    # is running separately, and does not any references to the $chorus_config
    require "environment.php";

    return 'http://' . $chorus_config['nikio_host'] . '/api/';    
  }

  function get_site_config() {
    $blog_name = get_bloginfo('name');
    $blog_url  = home_url();
    $blog_desc = get_bloginfo('description');
    $total_published_posts = wp_count_posts()->publish;
        
    $site_config = array(
      'name'        =>$blog_name,
      'url'         =>$blog_url,
      'description' =>$blog_desc,
      'siteType'    =>'wordpress.org',
      'settings'    =>array( 
        'pluginVersion'         => '0.6.11', 
        'wpTotalPublishedPosts' => $total_published_posts, 
        'wpVersion'             => get_bloginfo('version'),
        'wpTheme'               => get_template(),
        'wpSiteUrl'             => site_url(),
        'wpHomeUrl'             => home_url(),
        'wpLang'                => WPLANG
      )
    );
    return $site_config;
  }

  function extract_api_key_and_persist($response) {
    $site = json_decode(wp_remote_retrieve_body($response));
    chorus_log($site);
    if(empty($site -> { 'apiKey'})) {
      chorus_log("API key is empty");
      $site -> { 'apiKey'} = "invalid-test-api-key";
    }    
    $api_key = $site -> { 'apiKey'};    
    update_option(NIKIO_API_KEY, $site -> { 'apiKey'});
    update_option(MANIFEST_KEY, $site -> { 'manifestKey'});

    return $api_key;    
  }

  function post_urls($url, $api_key, $post_data) {
    // $startTime = $this->millitime();
    // log_error("URL is " . $url);
    $response = wp_remote_post($url, array(
      'method'        => 'POST',
      'timeout'       => 45,
      'redirection'   => 5,
      'httpversion'   => '1.0',
      'blocking'      => true,
      'headers'       => array('content-type' => 'application/json', 'api_key' => $api_key),
      'body'          => json_encode($post_data),
      'cookies'       => array()
      )
    );
    
    if(!$this->handle_error($url, $response)) {
      return false;
    }

    return true;
  }

  function deactivate_site_by_url($url, $api_key) {
    // log_error("URL is " . $url);
    $response = wp_remote_post($url, array(
      'method'        => 'PUT',
      'timeout'       => 45,
      'redirection'   => 5,
      'httpversion'   => '1.0',
      'blocking'      => true,
      'headers'       => array('content-type' => 'application/json', 'api_key' => $api_key),
      'cookies'       => array()
      )
    );
    
    if(!$this->handle_error($url, $response)) {
      return false;
    }

    return true;
  }

  public static function handle_error($url, $response) {
    if(is_wp_error($response)) {
      $error_code = $response->get_error_code();
      $error_message = "Error calling " . $url . ", error code is " . $error_code .
        ", error message: " . $response->get_error_message($error_code);
      chorus_log($error_message);
      //throw new Exception($error_message);
      // It is ok. We will register the site in the sign up screen.
      return false;
    }  
    
    $response_code = wp_remote_retrieve_response_code($response);
    if($response_code != 200) {
      $error_message = "Error calling " . $url . " , response code is " . $response_code .
        ", response message: " . wp_remote_retrieve_response_message($response);
      chorus_log($error_message);
      return false;       
      //throw new Exception($error_message);
    }

    return true;
  }

  public static function millitime() {
    $microtime = microtime();
    $comps = explode(' ', $microtime);

    // Note: Using a string here to prevent loss of precision
    // in case of "overflow" (PHP converts it to a double)
    return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
  }

}

new WordnikChorus();
