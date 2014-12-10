<?php
/**
 * Model :: Base
 */

class QiBaseModel {

  public function get_the_permalink( $permalink = "" ) {

    if( Qi_::has_relative_permalink() ) {
      // Remove the home url from the permalink
      $permalink = str_replace( home_url(), "", $permalink );
    }

    return $permalink;
  }

  public function get_author_meta( $id = null ) {
    global $post;

    if( !isset( $id ) ) {
      $id = $post->post_author;
    }

    // Creating the $author empty object
    $author = new stdClass();

    // Getting the user data
    $user_data =  get_userdata( $id );

    // Setting the author data
    $author->id = $id;
    $author->status = $user_data->data->user_status;
    $author->role = $user_data->roles[0];
    $author->login = $user_data->data->user_login;
    $author->display_name = $user_data->data->display_name;
    $author->email = $user_data->data->user_email;
    $author->url = $user_data->data->user_url;

    // Returning the author object
    return $author;
  }

  public function get_comment_meta() {
    global $post;

    // Creating the empty comment object
    $comment = new stdClass();

    // Setting the comment data
    $comment->count = $post->comment_count;
    $comment->status = $post->comment_status;

    // Returning the comment object
    return $comment;
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
    $image = null;
    $post_thumbnail_id = get_post_thumbnail_id( $post->ID );

    if( $post_thumbnail_id ) {

      // Creating empty image object
      $image = new stdClass();

      // Getting the thumbnail meta
      $post_thumbnail = wp_get_attachment_image_src( $post_thumbnail_id, $size );

      // Image alt text
      $post_thumbnail_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true);

      if( !$post_thumbnail_alt ) {
        $post_thumbnail_alt = $this->title;
      }

      // Setting the image data
      $image->url = self::get_the_permalink( $post_thumbnail[0] );
      $image->width = $post_thumbnail[1];
      $image->height = $post_thumbnail[2];
      $image->alt = $post_thumbnail_alt;
    }

    return $image;
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
    $permalink = self::get_the_permalink( $permalink );

    // Setting the permalink
    $this->permalink = $permalink;

    return $permalink;
  }

  public function set_featured_image() {
    $featured_image = self::get_post_thumbnail_meta();

    $this->featured_image = $featured_image;

    return $featured_image;
  }

  public function set_post_thumbnail() {
    $post_thumbnail = self::get_post_thumbnail_meta( 'thumbnail' );

    $this->post_thumbnail = $post_thumbnail;

    return $post_thumbnail;
  }

  public function set_author() {
    $author = self::get_author_meta();

    $this->author = $author;

    return $author;
  }

  public function set_comments() {
    $comment = self::get_comment_meta();

    $this->comment = $comment;

    return $comment;
  }

  public function set_content( $content = null ) {
    $content = self::get_content( $content );

    $this->content = $content;

    return $content;
  }

  public function set_date( $format = null  ) {
    global $post;

    $date = self::get_date( $format );

    $this->date = $date;
    $this->date_utc = $post->post_date;

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

  public function set_last_modified() {
    global $post;

    $modified = $post->post_modified;

    // Setting the title
    $this->last_modified = $modified;

    return $modified;
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
    self::set_author();
    self::set_content();
    self::set_excerpt();
    self::set_comments();
    self::set_last_modified();

    // Image
    self::set_featured_image();
    self::set_post_thumbnail();

  }
}