<?php include 'searchform.php' ?>

<div id="articleCats">
    <h4>Search Sermons</h4>
    <div class="cats">
        <h5>Series</h5>
        <?php wp_tag_cloud( array( 'taxonomy' => 'series', 'format' => 'list' ) ); ?>
    </div>
    <div class="cats">
        <h5>Speaker</h5>
        <?php wp_tag_cloud( array( 'taxonomy' => 'speaker', 'format' => 'list' ) ); ?>
    </div>
    <div class="cats">
        <h5>Service</h5>
        <?php wp_tag_cloud( array( 'taxonomy' => 'service', 'format' => 'list' ) ); ?>
    </div>
    <!-- <div class="cats">
        <h5>Topics</h5>
        <?php // wp_tag_cloud( array( 'taxonomy' => 'topic', 'format' => 'list' ) ); ?>
    </div> -->
    
    
</div>

<div id="eventWidget">

<h2>Coming Events</h2>
<ul>
   <?php 
   	$event_query = new WP_Query('post_type=tribe_events&showposts=2');	 
   	if ($event_query->have_posts()) :
   ?>
   	<?php while ($event_query->have_posts()) : $event_query->the_post(); ?>
   	    <li>
   	        <p class="dateCard">
   	            <span class="month"><?php echo tribe_get_start_date( $post->ID, false, 'M' ); ?></span>
   	            <span class="day"><?php echo tribe_get_start_date( $post->ID, false, 'j' ); ?></span>
   	        </p>
   	        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
   	        <p><?php echo tribe_get_venue(); ?></p>   
          </li>
    		<?php endwhile; ?>
      
   <?php endif;
   wp_reset_query();
    ?>
</ul>
<a href="#" class="button blue">All Events</a>
</div>

<p class="sidebarSlogan"><img src="<?php bloginfo('stylesheet_directory') ?>/images/livingProof.png" alt="Living Proof of a Loving God"></p>