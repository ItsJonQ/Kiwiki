<?php
if ( have_posts() ) :
        // Start the Loop.
  while ( have_posts() ) : the_post();

the_content();

endwhile;

else :

endif;
?>