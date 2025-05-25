<?php
if ( ! class_exists( 'Untoldstories_Widget_Category_Image' ) ):
	class Untoldstories_Widget_Category_Image extends WP_Widget {

		protected $defaults = array(
			'title'   => '',
			'term_id' => '',
		);

		function __construct() {
			$widget_ops  = array( 'description' => esc_html__( 'Display a linked category image.', 'untold-stories' ) );
			$control_ops = array();
			parent::__construct( 'untoldstories-category-image', $name = esc_html__( 'Theme - Category Image', 'untold-stories' ), $widget_ops, $control_ops );
		}

		function widget( $args, $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$term_id    = $instance['term_id'];
			$term       = false;
			$term_title = '';
			if ( ! empty( $term_id ) ) {
				$term_id = intval( $term_id );
				$term    = get_term( $term_id, 'category' );
				if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
					$term_title = $term->name;
				} else {
					return;
				}
			}

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? $term_title : $instance['title'], $instance, $this->id_base );

			echo $args['before_widget'];

			$image_id  = get_term_meta( $term_id, 'image_id', true );
			$image_url = untoldstories_get_image_src( $image_id, 'untoldstories_thumb_slider' );

			$style_attr = '';
			if ( ! empty( $image_url ) ) {
				$style_attr = sprintf( 'style="background-image: url(%s); background-position: center; background-size: cover;"',
					esc_url( $image_url )
				);
			}

			?>
			<div class="ci-category-image group" <?php echo $style_attr; ?>>
				<a href="<?php echo esc_url( get_term_link( $term_id ) ); ?>">
					<?php if ( $title ) {
						echo $args['before_title'] . $title . $args['after_title'];
					} ?>
				</a>
			</div>
			<?php

			echo $args['after_widget'];
		} // widget

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']   = sanitize_text_field( $new_instance['title'] );
			$instance['term_id'] = untoldstories_sanitize_intval_or_empty( $new_instance['term_id'] );

			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title   = $instance['title'];
			$term_id = $instance['term_id'];

			?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title (optional):', 'untold-stories' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" /></p>

			<p><label for="<?php echo $this->get_field_id( 'term_id' ); ?>"><?php esc_html_e( 'Category:', 'untold-stories' ); ?></label>
			<?php wp_dropdown_categories( array(
				'taxonomy'          => 'category',
				'show_option_none'  => ' ',
				'option_none_value' => '',
				'show_count'        => 1,
				'echo'              => 1,
				'selected'          => $term_id,
				'hierarchical'      => 1,
				'name'              => $this->get_field_name( 'term_id' ),
				'id'                => $this->get_field_id( 'term_id' ),
				'class'             => 'postform widefat',
			) ); ?>

			<?php
		} // form

	} // class

	register_widget( 'Untoldstories_Widget_Category_Image' );

endif;