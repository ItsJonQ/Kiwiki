<?php

class Qi_ {

  // Defining defaults
  public static $config = null;

  public static function setup_config() {

    $config = array(
      'post_thumbnails'         => true,
      'relative_permalink'      => true
      );

    // Setting it to Qi's config
    self::$config = $config;
  }

  // Post Thumbnails
  public static function setup_post_thumbnails() {
    if( self::$config['post_thumbnails'] ) {
      add_theme_support( 'post-thumbnails' );
    }
  }

  public static function has_relative_permalink() {
    return self::$config['relative_permalink'];
  }

  public static function initialize() {
    self::setup_config();

    self::setup_post_thumbnails();
  }
}

// Initializing Qi and adding it to global
Qi_::initialize();