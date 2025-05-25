<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchform" method="get" role="search">
	<div>
		<label class="screen-reader-text"><?php esc_html_e( 'Search for:', 'untold-stories' ); ?></label>
		<input type="text" placeholder="<?php esc_html_e( 'Search', 'untold-stories' ); ?>" name="s" value="<?php echo get_search_query(); ?>">
		<button class="searchsubmit" type="submit"><i class="fa fa-search"></i><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'untold-stories' ); ?></span></button>
	</div>
</form>