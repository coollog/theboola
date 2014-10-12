<?php
if(!defined('CHORUS_ENV'))
  define( 'CHORUS_ENV', 'production' );  // this will be replaced during build process

$env = (CHORUS_ENV == '$BUILD_ENV' . '$') ? 'development' : CHORUS_ENV;

# Base config 
$chorus_config = array(
  'env'          => 'default'
  ,'nikio_host'  => 'chorus-dev.nik.io'
  ,'assets_host' => 'http://chorus-dev.nik.io/chorus'
);

require plugin_dir_path(__FILE__) . '/environments/' . $env . '.php';
