<?php include 'searchform.php' ?>

<div id="podcastWidget">
    <h2>Listen to the Latest Sermon</h2>
    <?php 
    	$my_query = new WP_Query('post_type=podcast&showposts=1');	 
    	if ($my_query->have_posts()) :
    ?>
    	<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>	  
    	 <h3><?php the_title(); ?> <span class="passage"><?php echo get('podcast_passage'); ?></span></h3>
       <?php the_powerpress_content(); ?>
     		<?php endwhile; ?>
       
    <?php endif;
    wp_reset_query();
     ?>
    
    <a href="#" id="allSermons">All Sermons</a>
    <a href="#" id="sermonRSS">Sermons RSS Feed</a>
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
   	        <p><?php echo tribe_get_start_date( $post->ID, false, 'jS m Y' ); ?> | <?php echo tribe_get_venue(); ?></p>   
          </li>
    		<?php endwhile; ?>
      
   <?php endif;
   wp_reset_query();
    ?>
</ul>
<a href="#" class="button blue">All Events</a>
</div>

<p class="sidebarSlogan"><img src="<?php bloginfo('stylesheet_directory') ?>/images/livingProof.png" alt="Living Proof of a Loving God"></p>