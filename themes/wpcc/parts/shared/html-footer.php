
	<?php wp_footer(); ?>
	
</div>
	<div id="utilities">
	    <ul>  
	        <?php if(is_user_logged_in()) { ?>
	            <li><?php edit_post_link(); ?></li>  
	        <?php } ?>   
	        <li id="uSermons"><a href="/wpcc/sermons/">Sermons </a></li>              
	        <li id="uEvents"><a href="/wpcc/events/">Coming Events </a></li>                            
	        <li id="uMembers"><a href="/wpcc/members/">Members</a></li>
	    </ul>
	</div>
	</body>
</html>