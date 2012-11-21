 <?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

    		
    <div id="main">
        
            <div id="content">
            <p class="breadcrumb">Sermons by Speaker</p>
            <h2 class="leading"><?php the_terms( $post->ID, 'speaker', '', ', ', ' ' ); ?></h2>
            <div id="articleList">
            <?php
            $sermonCount = 0;
             if (have_posts()) : while (have_posts()) : the_post(); 
            $sermonCount ++; ?>
            
                
    		            <div class="post <?php if ($sermonCount % 2 == 0){ ?> even<?php } ?>">
    		            <?php print apply_filters( 'taxonomy-images-list-the-terms', '',array(
    		                'image_size' => 'sermon_image',
    		                'class' => 'sermonImage',
    		                'taxonomy' => 'series',
    		                'after'        => '',
    		                    'after_image'  => '',
    		                    'before'       => '',
    		                    'before_image' => '',
    		                ) );  ?>
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
    	
    
    
            </div><!-- end #core .eightcol-->
    
        
        
        
            <div id="sidebar">
            
            		<?php include 'sidebar_sermon.php'; ?>
            
            </div>
    	</div><!--end #core .row-->

    
   
</div><!--end #core-->
<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>