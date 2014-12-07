<?php
/**
 * Model :: Post
 */

class PostModel extends QiBaseModel {

  public function get_category_meta() {
    global $post;

    $post_categories = wp_get_post_categories( $post->ID );

    if( !$post_categories ) {
      return null;
    }

    $categories = array();

    foreach( $post_categories as $cat ) {
      $cat = get_category( $cat );
      $categories[] = array(
        'id'            => $cat->term_id,
        'name'          => $cat->name,
        'slug'          => $cat->slug,
        'permalink'     => get_category_link( $cat )
        );
    }

    return $categories;
  }

  public function get_tag_meta() {
    global $post;

    $post_tags = get_the_tags( $post->ID );

    if( !$post_tags ) {
      return null;
    }

    $tags = array();

    foreach( $post_tags as $tag ) {
      $tags[] = array(
        'id'              => $tag->term_id,
        'name'            => $tag->name,
        'slug'            => $tag->slug,
        'permalink'       => get_tag_link( $tag->term_id )
      );
    }

    return $tags;
  }

  // Initializing the model
  public function __construct() {

    parent::__construct();

  }

}