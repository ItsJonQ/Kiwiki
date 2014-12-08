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

  public function get_content( $content = null ) {
    global $post;

    if( !isset( $content ) ) {
      $content = $post->post_content;
    }

    return $content;
  }

  public function get_date( $format = null ) {
    global $post;

    if( !isset( $format) ) {
      $format = 'F j, Y';
    }

    // Getting the date
    $date = get_the_date( $format, $post->ID );

    return $date;
  }

  public function get_excerpt( $excerpt = null ) {
    global $post;

    if( !isset( $excerpt ) ) {
      $excerpt = $post->post_excerpt;
    }

    return $excerpt;
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

  public function get_title( $title = null ) {
    global $post;

    if( !isset( $title ) ) {
      $title = $post->post_title;
    }

    return $title;
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

    return $featured_image;
  }

  public function set_post_thumbnail_url() {
    $post_thumbnail = self::get_post_thumbnail_url( 'thumbnail' );

    $this->post_thumbnail_url = $post_thumbnail;

    return $post_thumbnail;
  }

  public function set_content( $content = null ) {
    $content = self::get_content( $content );

    $this->content = $content;

    return $content;
  }

  public function set_date( $format = null  ) {
    $date = self::get_date( $format );

    $this->date = $date;

    return $date;
  }

  public function set_excerpt( $excerpt = null ) {
    $excerpt = self::get_excerpt( $excerpt );

    $this->excerpt = $excerpt;

    return $excerpt;
  }

  public function set_id() {
    global $post;

    $id = $post->ID;

    $this->id = $id;

    return $id;
  }

  public function set_title( $title = null ) {
    global $post;

    $title = self::get_title( $title );

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
    self::set_id();

    // Base
    self::set_permalink();
    self::set_title();
    self::set_date();
    self::set_content();
    self::set_excerpt();

    // Image
    self::set_featured_image_url();
    self::set_post_thumbnail_url();

  }
}