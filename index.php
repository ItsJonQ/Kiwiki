<?php

// print_r($wp_query);


if ( have_posts() ) :
        // Start the Loop.
  while ( have_posts() ) : the_post();

$c = new PostModel();

print_r($post->model);

// the_content();

endwhile;

else :

endif;
?>