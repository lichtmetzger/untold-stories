<?php get_header(); ?>

<div class="row">
	<div class="col-xs-12">
		<main id="content" class="single" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">
			<div class="row">
				<div class="col-md-12">
					<?php woocommerce_content(); ?>
				</div>
			</div>
		</main>
	</div>
</div>

<?php get_footer(); ?>
