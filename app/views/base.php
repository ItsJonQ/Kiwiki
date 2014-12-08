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

  public function __construct( $model = null ) {
    self::set_model( $model );
    self::set_view();
  }

}