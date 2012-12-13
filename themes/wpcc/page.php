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
    <div id="homeIntroWidgets">
        <h2><img src="<?php bloginfo('stylesheet_directory') ?>/images/livingProof.png" alt="Living Proof of a Loving God"></h2>
        <p><a href="<?php bloginfo('url') ?>/about-us/what-we-believe">Find out more about us and what we believe</a></p>
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
            
            <a href="<?php bloginfo('url') ?>/sermons/" id="allSermons">All Sermons</a>
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
           	        <p><?php echo tribe_get_venue(); ?></p>   
                  </li>
            		<?php endwhile; ?>
              
           <?php endif;
           wp_reset_query();
            ?>
        </ul>
        <a href="/events/" class="button blue">All Events</a>
        </div>
    </div>
</div>
<div id="homeSecondary">
    <div id="homePathways">
        <div class="pathway odd">
            <a href="<?php bloginfo('url') ?>/connect/men/"><img src="<?php bloginfo('stylesheet_directory')?>/images/men.jpg" alt="Men watching a speaker"></a>
            <h3><a href="<?php bloginfo('url') ?>/connect/men/"><strong>WWPC</strong> For Men</a></h3>
        </div>
        <div class="pathway even">
            <a href="<?php bloginfo('url') ?>/connect/women/"><img src="<?php bloginfo('stylesheet_directory')?>/images/women.jpg" alt="Women doing Craft"></a>
            <h3><a href="<?php bloginfo('url') ?>/connect/women/"><strong>WWPC</strong> For Women</a></h3>
        </div>
        <div class="pathway odd">
            <a href="<?php bloginfo('url') ?>/connect/youth/"><img src="<?php bloginfo('stylesheet_directory')?>/images/youth.jpg" alt="Children Playing Outside"></a>
            <h3><a href="<?php bloginfo('url') ?>/connect/youth/"><strong>WWPC</strong> For Youth</a></h3>
        </div>
        <div class="pathway even">
            <a href="<?php bloginfo('url') ?>/connect/children/"><img src="<?php bloginfo('stylesheet_directory')?>/images/kids.jpg" alt="Children with Toys"></a>
            <h3><a href="<?php bloginfo('url') ?>/connect/children/"><strong>WWPC</strong> For Children</a></h3>
        </div>
    </div>
    <div id="homeTimeLocation">
        <div id="homeTimes">
            <h3><img src="<?php bloginfo('stylesheet_directory') ?>/images/joinUs.png" alt="Come join us this Sunday"></h3>
            <h4><a href="<?php bloginfo('url') ?>/connect/services/#traditional">Traditional Service</a></h4>
            <p>8:00am Sunday</p>
            <h4><a href="<?php bloginfo('url') ?>/connect/services/#contemporary">Contemporary + Kid's Service</a></h4>
            <p>9:30am Sunday</p>
            <h4><a href="<?php bloginfo('url') ?>/connect/services/#salt">Salt @ Six</a></h4>
            <p>6:00pm Sunday</p>
        </div>
        <div id="homeLocation">
            <a href="http://maps.google.com/maps?q=Woonona+Presbyterian+Community+Church,+Gray+Street,+Woonona,+New+South+Wales,+Australia&hl=en&ll=-34.34635,150.907291&spn=0.007476,0.007296&sll=37.0625,-95.677068&sspn=57.902911,59.765625&oq=woonona+presby&t=h&hq=Woonona+Presbyterian+Community+Church,&hnear=Gray+St,+Woonona+New+South+Wales+2517,+Australia&z=17" target="_blank" id="locationLink"><img src="<?php bloginfo('stylesheet_directory') ?>/images/whereAreWe.jpg" alt="Where Are We?"></a>
            <span id="justJesus">
                <img src="<?php bloginfo('stylesheet_directory') ?>/images/justJesus.jpg" alt="Just Jesus Sign">
            </span>
        </div>
    </div>
</div>
    <?php endif; ?>

  <?php }else{ ?>
    <div id="main">
        <div id="content">
        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <h2><?php the_title(); ?></h2>
            <?php if ( has_post_thumbnail() ) {
            	the_post_thumbnail();
            } ?>
            <?php the_content(); ?>
            <?php edit_post_link(); ?>
        <?php endwhile; ?>
        </div>
        <div id="sidebar">
            <?php get_sidebar() ?>
        </div>
    </div>
<?php } ?>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>