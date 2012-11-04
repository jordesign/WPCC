 <?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

    		
    <div id="main">
        
            <div id="content">
            <p class="breadcrumb">Sermons by Service</p>
            <h2 class="leading"><?php the_terms( $post->ID, 'service', '', ', ', ' ' ); ?></h2>
            <div id="articleList">
            <?php
            $sermonCount = 0;
             if (have_posts()) : while (have_posts()) : the_post(); 
            $sermonCount ++; ?>
            
                
    		            <div class="post <?php if ($sermonCount % 2 == 0){ ?> even<?php } ?>">
    		            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    		            <p class="meta"><?php the_time('jS M Y') ?>  | <?php the_terms( $post->ID, 'speaker', '', ', ', ' ' ); ?> | <?php the_terms( $post->ID, 'series', '', ', ', ' ' ); ?> | <?php the_terms( $post->ID, 'service', '', ', ', ' ' ); ?></p>
    		            </div>
            
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
    	    <div class="cats">
    	        <h5>Topics</h5>
    	        <?php wp_tag_cloud( array( 'taxonomy' => 'topic', 'format' => 'list' ) ); ?>
    	    </div>
    	    
    	    
    	</div>
    
    
            </div><!-- end #core .eightcol-->
    
        
        
        
            <div id="sidebar">
            
            		<?php get_sidebar(); ?>
            
            </div>
    	</div><!--end #core .row-->

    
   
</div><!--end #core-->
<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>