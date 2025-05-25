<div id="sidebar" role="complementary" itemtype="http://schema.org/WPSideBar" itemscope="itemscope">
	<?php
		if( is_page_template( 'template-listing-looks.php' ) ) {
			dynamic_sidebar( 'untoldstories_blog' );
		} elseif( is_page() && is_active_sidebar( 'page' ) ) {
			dynamic_sidebar( 'untoldstories_page' );
		} else {
			dynamic_sidebar( 'untoldstories_blog' );
		}
	?>
</div><!-- /sidebar -->
