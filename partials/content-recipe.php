<a class="col-sm-4 recipe-card-wrap" href="<?php echo get_permalink(); ?>">
    <div class="recipe-card">
        <div class="recipe-content">
            <div class="thumb">
                <?php echo get_the_post_thumbnail(get_the_ID(), 'untoldstories_thumb_recipe'); ?>
            </div>
            <h3 class="title">
                <?php echo get_the_title(); ?>
            </h3>
        </div>
        <div class="recipe-excerpt">
            <p><?php echo get_the_title(); ?></p>
            <?php echo get_the_excerpt(); ?>
            <div class="recipe-btn" data-url="<?php echo get_permalink(); ?>">
                <?php echo __('Go to recipe', 'untold-stories'); ?>
            </div>
        </div>
    </div>
</a>