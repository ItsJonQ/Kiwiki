<?php

class Qi_ {

  // Defining defaults
  public static $config = null;

  public static function setup_config() {

    $config = array(
      'theme'                   => 'qi',
      'dir'                     => 'app',
      'dir_templates'           => 'templates/',
      'dir_partials'            => 'templates/partials',
      'post_thumbnails'         => true,
      'relative_permalink'      => true
      );

    // Setting it to Qi's config
    self::$config = $config;
  }

  public static function setup_dir() {
    self::$config['dir'] = get_theme_root() . '/' . self::$config['theme'] . '/' . self::$config['dir'];
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
    self::setup_dir();
    self::setup_post_thumbnails();
  }
}

// Initializing Qi and adding it to global
Qi_::initialize();