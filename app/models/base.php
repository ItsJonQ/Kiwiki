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

  public function get_post_thumbnail_meta( $size = null ) {
    global $post;

    // Return if post_thumbnails is disabled in the config
    if( !Qi_::$config['post_thumbnails'] ) {
      return;
    }

    $post_thumbnail = null;
    $post_thumbnail_id = get_post_thumbnail_id( $post->ID );

    if( $post_thumbnail_id ) {

      // Setting the image ID
      $post_thumbnail['id'] = $post_thumbnail_id;

      // Getting the thumbnail meta
      $post_thumbnail = wp_get_attachment_image_src( $post_thumbnail_id, $size );

      // Image alt text
      $post_thumbnail_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true);

      if( !$post_thumbnail_alt ) {
        $post_thumbnail_alt = $this->title;
      }
      // Setting the image alt meta info
      $post_thumbnail['alt'] = $post_thumbnail_alt;
    }

    return $post_thumbnail;
  }

  public function get_post_thumbnail_url( $size = null ) {
    global $post;

    // Getting the thumbail meta
    $post_thumbnail = self::get_post_thumbnail_meta( $size );

    if( isset( $post_thumbnail[0] ) ) {
      $post_thumbnail = $post_thumbnail[0];
    }

    return $post_thumbnail;
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

  public function set_featured_image_url() {
    $featured_image = self::get_post_thumbnail_url();

    $this->featured_image_url = $featured_image;
  }

  public function set_post_thumbnail_url() {
    $post_thumbnail = self::get_post_thumbnail_url( 'thumbnail' );

    $this->post_thumbnail_url = $post_thumbnail;
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

    // Initialize
    self::set_model();

    // Base
    self::set_permalink();
    self::set_title();

    // Image
    self::set_featured_image_url();
    self::set_post_thumbnail_url();

  }
}