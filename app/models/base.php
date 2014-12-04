<?php
/**
 * Model :: Base
 */

class QiBaseModel {

  public function get_relative_permalink( $permalink = "" ) {
    // Remove the home url from the permalink
    $permalink = str_replace( home_url(), "", $permalink );

    return $permalink;
  }

  public function set_permalink( $permalink = "" ) {
    global $post;

    // Defining the permalink var
    $permalink = get_permalink( $post->ID );

    // Adjust the permalink based on Qi configs
    if( Qi_::has_relative_permalink() ) {
      $permalink = self::get_relative_permalink( $permalink );
    }

    // Setting the permalink
    $this->permalink = $permalink;

    return $permalink;
  }

  public function set_title( $title = null ) {
    global $post;

    $title = $post->post_title;

    // Setting the title
    $this->title = $title;

    return $title;
  }

  public function set_model() {
    global $post;

    if( $post ) {
      // Attaching the model content to $post
      $post->model = $this;
    }
  }

  // Initializing the model
  public function __construct() {

    self::set_model();

    self::set_permalink();
    self::set_title();

  }
}