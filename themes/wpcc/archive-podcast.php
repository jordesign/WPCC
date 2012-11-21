<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts() 
 *
 * @package 	WordPress
 * @subpackage 	WPCC

 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

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
        <?php } ?>
        
	<?php endwhile;  ?>
	   
	  <div class="next-posts"><?php next_posts_link('Older Sermons', $my_query->max_num_pages) ?></div>
	  	<div class="prev-posts"><?php previous_posts_link('Newer Sermons', $my_query->max_num_pages) ?></div>
	<?php else: ?>

		<p><?php _e('Sorry, no posts matched your criteria','themnific');?>.</p>

	<?php endif; ?>
	</div>
	


</div>

    
    
    
        <div id="sidebar">
        
        		<?php include 'sidebar_sermon.php'; ?>
        
        </div>
	</div>


<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>