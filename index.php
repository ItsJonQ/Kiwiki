<?php

// print_r($wp_query);


if ( have_posts() ) :
        // Start the Loop.
  while ( have_posts() ) : the_post();


$vm = new PostView();

// print_r($post);
// print_r($vm);

$vm->render();

// the_content();

endwhile;

else :

endif;
?>