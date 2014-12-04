<?php

class Qi_ {

  // Defining defaults
  public static $config = null;

  public static function setup_config() {

    $config = array(
      'relative_permalink'     => false
      );

    // Setting it to Qi's config
    self::$config = $config;
  }

  //

  public static function has_relative_permalink() {
    return self::$config['relative_permalink'];
  }

  public static function initialize() {
    self::setup_config();
  }
}

// Initializing Qi and adding it to global
Qi_::initialize();