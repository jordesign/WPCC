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
    <?php endif; ?></div>
    
    <div class="sidebar">
        <div id="homeIntro">
            <h2>Living Proof of a Loving God</h2>
            <p><a href="#">Find out more about us and what we believe</a></p>
        </div>
        
        <div id="homePodcast">
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
        
        <div id="homeEvents">
        
        <h2>Upcoming Events</h2>
        <ul>
           <?php 
           	$event_query = new WP_Query('post_type=tribe_events&showposts=2');	 
           	if ($event_query->have_posts()) :
           ?>
           	<?php while ($event_query->have_posts()) : $event_query->the_post(); ?>
           	    <li>
           	        <span class="calendarDate">
           	            <em><?php echo tribe_get_start_date( $post->ID, false, 'M' ); ?></em>
           	            <?php echo tribe_get_start_date( $post->ID, false, 'j' ); ?>
           	        </span>
           	        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
           	        <p><?php echo tribe_get_start_date( $post->ID, false, 'jS m Y' ); ?> | <?php echo tribe_get_venue(); ?></p>
                      <?php the_excerpt(); ?>     
                  </li>
            		<?php endwhile; ?>
              
           <?php endif;
           wp_reset_query();
            ?>
        </ul>
        <a href="#" class="button blue">All Events</a>
        </div>
    </div>
    
    <div id="homeSecondary">
        <div id="homePathways">
            <div class="pathway odd">
                <a href="#"><img src="<?php bloginfo('stylesheet_url')?>/images/men.jpg" alt="Men watching a speaker"></a>
                <h3><a href="#"><strong>WWPC</strong> For Men</a></h3>
            </div>
            <div class="pathway even">
                <a href="#"><img src="<?php bloginfo('stylesheet_url')?>/images/women.jpg" alt="Women doing Craft"></a>
                <h3><a href="#"><strong>WWPC</strong> For Womenn</a></h3>
            </div>
            <div class="pathway odd">
                <a href="#"><img src="<?php bloginfo('stylesheet_url')?>/images/youth.jpg" alt="Children Playing Outside"></a>
                <h3><a href="#"><strong>WWPC</strong> For Youth</a></h3>
            </div>
            <div class="pathway even">
                <a href="#"><img src="<?php bloginfo('stylesheet_url')?>/images/kids.jpg" alt="Children with Toys"></a>
                <h3><a href="#"><strong>WWPC</strong> For Children</a></h3>
            </div>
        </div>
        <div id="homeTimes">
            <h4><a href="#">Traditional Service</a></h4>
            <p>8:00am Sunday</p>
            <h4><a href="#">Contemporary + Kid's Service</a></h4>
            <p>9:30am Sunday</p>
            <h4><a href="#">Salt @ Six</a></h4>
            <p>6:00pm Sunday</p>
        </div>
        <div id="homeLocation">
            <a href="#" id="locationLink">Where Are We?</a>
            <img src="<?php bloginfo('stylesheet_url') ?>/images/justJesus.jpg" alt="Just Jesus Sign">
        </div>
    
<?php }else{ ?>

    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <h2><?php the_title(); ?></h2>
    <?php the_content(); ?>
    <?php comments_template( '', true ); ?>
    <?php endwhile; ?>
    
<?php } ?>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>