<?php

  global $qi;

  require 'lib/Mustache/Autoloader.php';
  Mustache_Autoloader::register();

  require_once( 'config/qi.php' );

  // Models
  require_once( 'app/models/base.php' );
  require_once( 'app/models/post.php' );

  // Views
  require_once( 'app/views/base.php' );
  require_once( 'app/views/post.php' );
