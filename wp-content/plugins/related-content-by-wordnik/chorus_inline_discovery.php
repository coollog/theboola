<?php

/* Register the Discover and Lookup metaboxes */
class ChorusInlineDiscovery {

  public function __construct() {
    add_filter('the_content', array($this, 'enable_inline_discovery_full_content'));
    add_filter('the_excerpt', array($this, 'enable_inline_discovery_excerpt'));
  }

  function enable_inline_discovery_full_content($content) {
    return $this->enable_inline_discovery_internal($content, false);
  }

  function enable_inline_discovery_excerpt($content) {
    return $this->enable_inline_discovery_internal($content, true);
  }

  function enable_inline_discovery_internal($content, $excerpt) {
    if($excerpt) return $content;

    if(is_page()) {
      return $content;
    }
    
    $current_post_permalink = get_permalink();
    // chorus_log($_GET);

    if(isset($_GET['_escaped_fragment_'])) {
      // http://stackoverflow.com/questions/10228133/ajax-fragment-meta-tag-googlebot-isnt-reading-the-pages-content
      // chorus_log('SEO param is set');
      $recommendations_html = $this->get_reco_html($current_post_permalink);
    } else {
      if(is_single()) {
        $recommendations_html = '<div data-chorus-discovery data-url="'.$current_post_permalink.'"></div>';
      } else {
        $recommendations_html = '<div data-chorus-discovery data-url="'.$current_post_permalink.'"></div>';
        $pos=strpos($content, '<a href="'.$current_post_permalink.'"');
        if(!$pos) {
          $pos=strpos($content, '<a href="'.$current_post_permalink.'#');
        }
        if($pos) {
          //do not insert recs widget if we are looking at post fragments with more links
          $recommendations_html = "";
        }
      }
    }
    $html = <<<CODE
      $content
      $recommendations_html
CODE;
    
    return $html;
  }

  function get_reco_html($post_permalink) {
    global $chorus_config;
    $nikio_host = $chorus_config['nikio_host'];
    $api_key = get_option(NIKIO_API_KEY, 'invalid');

    $remote_url = 'http://' . $nikio_host . '/api/recommendation.json/byUrl?count=3&url=' . $post_permalink;
    
    $response = wp_remote_get($remote_url, array(
      'timeout'       => 45,
      'redirection'   => 5,
      'httpversion'   => '1.0',
      'blocking'      => true,
      'headers'       => array('content-type' => 'application/json', 'api_key' => $api_key),
      // 'body'          => json_encode($post_data),
      'cookies'       => array()
      )
    );

    if(!WordnikChorus::handle_error($remote_url, $response)) {
      chorus_log("Error getting recommendations for the url " . $remote_url);
      return "";
    }

    $response_body = json_decode($response['body']);
    $recommendations = $response_body->_1;

    $recommendations_html = '<div data-chorus-discovery-no-ajax data-url="'.$post_permalink.'"></div>';
    foreach ($recommendations as $rec) {
      $recommendations_html .= $this->get_single_reco_html($rec->title, $rec->url, $rec->summary);
    }
    $recommendations_html .= "</div>";

    // chorus_log("recommendations html is " . $recommendations_html);
    return $recommendations_html;
  }

  function get_single_reco_html($title, $url, $summary) {
    $html = <<<CODE
      <div class="title"><a href="$url" class="chorus_preview">$title</a></div>
      <div class="rec_meta">
        <a href="$url" target="_blank" class="link"></a>
      </div>
      <div class="summary">
        $summary
      </div>    
CODE;
    return $html;
  }

}