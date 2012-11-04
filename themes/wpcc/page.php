<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	WPCC

 */
?>
    <?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if(is_front_page()) { ?>
 <div id="homeIntro">
    <div class="main flexslider" id="homeSlide">
        <?php 
        	$my_query = new WP_Query('post_type=slides');	 
        	if ($my_query->have_posts()) :
        ?>
        <ul class="slides">
        	<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>	  
        	    <li>
                <a href="<?php echo get('slide_link'); ?>">
                    <?php echo get_image('slide_image',1,1,1,NULL, NULL, NULL, 'feature_slide') ?>
    
                </a>
                </li>
    		    <?php endwhile; ?>
        </ul>
    </div>
    <h2><img src="<?php bloginfo('stylesheet_directory') ?>/images/livingProof.png" alt="Living Proof of a Loving God"></h2>
    <p><a href="#">Find out more about us and what we believe</a></p>
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
    <a href="/events/" class="button blue">All Events</a>
    </div>
</div>
<div id="homeSecondary">
    <div id="homePathways">
        <div class="pathway odd">
            <a href="/connect/men/"><img src="<?php bloginfo('stylesheet_directory')?>/images/men.jpg" alt="Men watching a speaker"></a>
            <h3><a href="/connect/men/"><strong>WWPC</strong> For Men</a></h3>
        </div>
        <div class="pathway even">
            <a href="/connect/women/"><img src="<?php bloginfo('stylesheet_directory')?>/images/women.jpg" alt="Women doing Craft"></a>
            <h3><a href="/connect/women/"><strong>WWPC</strong> For Women</a></h3>
        </div>
        <div class="pathway odd">
            <a href="/connect/youth/"><img src="<?php bloginfo('stylesheet_directory')?>/images/youth.jpg" alt="Children Playing Outside"></a>
            <h3><a href="/connect/youth/"><strong>WWPC</strong> For Youth</a></h3>
        </div>
        <div class="pathway even">
            <a href="/connect/children/"><img src="<?php bloginfo('stylesheet_directory')?>/images/kids.jpg" alt="Children with Toys"></a>
            <h3><a href="/connect/children/"><strong>WWPC</strong> For Children</a></h3>
        </div>
    </div>
    <div id="homeTimes">
        <h3><img src="<?php bloginfo('stylesheet_directory') ?>/images/joinUs.png" alt="Come join us this Sunday"></h3>
        <h4><a href="/connect/services/#traditional">Traditional Service</a></h4>
        <p>8:00am Sunday</p>
        <h4><a href="/connect/services/#contemporary">Contemporary + Kid's Service</a></h4>
        <p>9:30am Sunday</p>
        <h4><a href="/connect/services/#salt">Salt @ Six</a></h4>
        <p>6:00pm Sunday</p>
    </div>
    <div id="homeLocation">
        <a href="#" id="locationLink">Where Are We?</a>
        <img src="<?php bloginfo('stylesheet_directory') ?>/images/justJesus.jpg" alt="Just Jesus Sign">
    </div>
</div>
    <?php endif; ?>
    
  
  <?php }elseif (is_page('sermons')) { ?>
  		
  <div id="main">
  	<div id="content">
          <h2 class="leading">Latest Sermons</h2>
          <div id="articleList">
          <?php
          $sermonCount = 0;
          $paged = get_query_var('paged') ? get_query_var('paged') : 1;
          $my_query = new WP_Query(array(
           'post_type' => 'podcast',
           'paged' => $paged,
           'posts_per_page' => 21
          ));
           if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); 
          $sermonCount ++; 
          
          if ($sermonCount === 1 && $paged < 2 ) { ?>
              <div class="topPost">
                  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                  <p class="meta"><?php the_time('jS M Y') ?>  | <?php the_terms( $post->ID, 'speaker', '', ', ', ' ' ); ?> | <?php the_terms( $post->ID, 'series', '', ', ', ' ' ); ?> | <?php the_terms( $post->ID, 'service', '', ', ', ' ' ); ?></p>
                  <?php the_powerpress_content(); ?>
              </div>
              <?php }else{  ?>
              
  		            <div class="post <?php if ($sermonCount % 2 != 0){ ?> even<?php } ?>">
  		            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  		            <p class="meta"><?php the_time('jS M Y') ?>  | <?php the_terms( $post->ID, 'speaker', '', ', ', ' ' ); ?> | <?php the_terms( $post->ID, 'series', '', ', ', ' ' ); ?> | <?php the_terms( $post->ID, 'service', '', ', ', ' ' ); ?></p>
  		            </div>
          <?php } ?>
          
  	<?php endwhile;  ?>
  	   
  	  <div class="next-posts"><?php next_posts_link('Older Sermons', $my_query->max_num_pages) ?></div>
  	  	<div class="prev-posts"><?php previous_posts_link('Newer Sermons', $my_query->max_num_pages) ?></div>
  	<?php else: ?>
  
  		<p><?php _e('Sorry, no posts matched your criteria','themnific');?>.</p>
  
  	<?php endif; ?>
  	</div>
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
  
  
  </div>
</div>
  
      
      
      
          <div id="sidebar">
          
          		<?php get_sidebar(); ?>
          
          </div>
  	</div>
  
  
  
  
  <?php }else{ ?>
    <div id="main">
        <div id="content">
        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <h2><?php the_title(); ?></h2>
            <?php if ( has_post_thumbnail() ) {
            	the_post_thumbnail();
            } ?>
            <?php the_content(); ?>
        <?php endwhile; ?>
        </div>
        <div id="sidebar">
            <?php get_sidebar() ?>
        </div>
    </div>
<?php } ?>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>