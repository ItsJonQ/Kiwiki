<?php
/**
 * View :: Base
 */

class QiBaseView {

  public function set_model( $model = null ) {

    // Automatically define Model if not defined
    if( !is_object( $model ) || !isset( $attribute ) ) {

      // Get the current View class name
      $view_name = get_class( $this );
      // Replace the word "View" with "Model"
      $view_name = str_replace( "View", "Model", $view_name );

      $model = new $view_name();
    }

    // Set the model
    $this->model = $model;
  }

  public function set_view() {
    global $post;

    if( $post ) {
      // Attaching the view content to $post
      $post->view = $this;
    }
  }

  public function render( $template = null, $model = null ) {

    // If $template is not provided..
    if( !isset( $template ) ) {
      // Try to automagically load the file
      $template = basename( $_SERVER['PHP_SELF'] );
      $template = str_replace( ".php", "", $template );
    }

    if( !isset( $model ) ) {
      $model = $this->model;
    }

    $m = new Mustache_Engine(array(
      'cache' => Qi_::$config['dir_cache'],
      'cache_file_mode' => 0777,
      'loader' => new Mustache_Loader_FilesystemLoader( Qi_::$config['dir_templates'] ),
      'partials_loader' => new Mustache_Loader_FilesystemLoader( Qi_::$config['dir_partials'] )
    ));

    // Return the template via Mustache
    echo $m->render( $template, $model );
  }

  public function __construct( $model = null ) {
    self::set_model( $model );
    self::set_view();
  }

}