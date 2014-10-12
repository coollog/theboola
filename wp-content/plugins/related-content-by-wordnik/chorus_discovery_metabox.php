<?php

/* Register the Discover and Lookup metaboxes */
class ChorusDiscoveryMetabox {

  public function __construct() {
    global $chorus_config;

    add_action( 'wp_ajax_submit_to_proxy', array($this, 'submit_to_proxy'));
    add_action( 'wp_ajax_put_to_proxy', array($this, 'put_to_proxy'));
  }

  public function put_to_proxy(){
    $response = wp_remote_request( $_REQUEST["url"], array(
      'method'      => 'PUT',
      'timeout'     => 45,
      'redirection' => 5,
      'httpversion' => '1.0',
      'blocking'    => true,
      'headers'     => array("content-type" => "application/json", 'api_key' => get_option(NIKIO_API_KEY, 'invalid')),
      'body'        => stripslashes($_REQUEST["content"]),
      'cookies'     => array()
    ));

    if( is_wp_error( $response ) ) {
      chorus_log('Something went wrong!');
      chorus_log($response);
      header("HTTP/1.0 " . $response["response"]["code"] . ' ' . $response["response"]["message"]);
      die($response["body"]);
    } else {
       chorus_log( "put_to_proxy successful" );
       chorus_log($response);
       header("HTTP/1.0 " . $response["response"]["code"] . ' ' . $response["response"]["message"]);
       die($response["body"]);
    }
  }

  public function submit_to_proxy(){
    $response = wp_remote_post( $_REQUEST["url"], array(
      'method'      => 'POST',
      'timeout'     => 45,
      'redirection' => 5,
      'httpversion' => '1.0',
      'blocking'    => true,
      'headers'     => array("content-type" => "application/json", 'api_key' => get_option(NIKIO_API_KEY, 'invalid')),
      'body'        => stripslashes($_REQUEST["content"]),
      'cookies'     => array()
    ));

    if( is_wp_error( $response ) ) {
      chorus_log('Something went wrong!');
      chorus_log($response);
      header("HTTP/1.0 " . $response["response"]["code"] . ' ' . $response["response"]["message"]);
      die($response["body"]);
    } else {
       chorus_log('HTTP call sucessful!');
       chorus_log( "submit_to_proxy successful" );
       chorus_log($response);
       header("HTTP/1.0 " . $response["response"]["code"] . ' ' . $response["response"]["message"]);
       die($response["body"]);
    }
  }

}

