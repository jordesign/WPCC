<div id="header">
	<h1><a href="/"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>"></a></h1>
	<p id="headerLocation">Come join us this Sunday at 8:00am, 9:30am or 6pm. <a href="#">7 Gray Street Woonona NSW</a></p>
	<a href="#menu" class="menu-link">Menu</a>
	<div id="menu" class="menu" role="navigation">
	    <?php wp_nav_menu( array( 'theme_location' => 'primary-menu' ) ); ?>
	</div>
</div>
<div id="container">