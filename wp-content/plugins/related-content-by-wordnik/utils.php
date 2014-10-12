<?php

if(!function_exists('chorus_log')){
  # turn on error logging in wp-config.php
  #
  #   define('WP_DEBUG', true);
  #   define('WP_DEBUG_LOG', true);
  #   define('WP_DEBUG_DISPLAY', false);
  #   @ini_set('display_errors',0);#
  #
  # the log will be output to wp-config/debug.log
  function chorus_log($message) {
    if(WP_DEBUG){
      if( is_array( $message ) || is_object( $message ) ){
        error_log( print_r( $message, true ) );
      } else {
        error_log( $message );
      }
    }
  } 
}