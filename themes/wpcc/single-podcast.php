<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

    		
    <div id="main">
    	
        
            <div id="content">
            
            <?php
             if (have_posts()) : while (have_posts()) : the_post(); ?>
                     <p class="breadcrumb">Sermons</p>
                     <h2 class="leading"><?php the_title(); ?></h2>
                     <div id="articleList">
                         <div id="singlePodcast">
                            <?php the_powerpress_content(); ?>
                        </div>
                        
                        <div class="sermonDetails">
                            <p><strong>Date:</strong> <?php the_time('jS M Y') ?></p>
                            <p><strong>Series:</strong> <?php the_terms( $post->ID, 'series', '', ', ', ' ' ); ?></p>
                            <p><strong>Speaker:</strong> <?php the_terms( $post->ID, 'speaker', '', ', ', ' ' ); ?></p> 
                            <p><strong>Service:</strong> <?php the_terms( $post->ID, 'service', '', ', ', ' ' ); ?></p>
                        
                        </div>
                        
                        <?php if(get('podcast_passage')!=''){ ?>
                            <div class="sermonPassage">
                                <h5>Sermon Passage</h5><p><?php echo get('podcast_passage'); ?></p>
                            </div>
                        <?php } ?>
                        <?php if (get('podcast_transcription') !='') { echo get('podcast_transcription'); } ?>
    		        </div>
    		        
            
    	<?php endwhile;  ?>
    	<?php else: ?>
    
    		<p><?php _e('Sorry, no posts matched your criteria','themnific');?>.</p>
    
    	<?php endif; ?>
    	
    
    
            </div><!-- end #core .eightcol-->
    
        
        
        
            <div id="sidebar">
            
            		<?php include 'sidebar_sermon.php'; ?>
            
            </div>
    	</div><!--end #core .row-->

    
   
</div><!--end #core-->
<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>