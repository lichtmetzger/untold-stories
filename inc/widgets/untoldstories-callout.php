<?php
if ( ! class_exists( 'Untoldstories_Widget_Callout' ) ):
	class Untoldstories_Widget_Callout extends WP_Widget {

		protected $defaults = array(
			'title' => '',
			'image' => '',
			'url'   => '',
		);

		function __construct() {
			$widget_ops  = array( 'description' => esc_html__( 'Display a linked call to action box with a background image and title.', 'untold-stories' ) );
			$control_ops = array();
			parent::__construct( 'untoldstories-callout', $name = esc_html__( 'Theme - Call to Action Box', 'untold-stories' ), $widget_ops, $control_ops );
		}

		function widget( $args, $instance ) {
			extract( $args );

			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$image = $instance['image'];
			$url   = $instance['url'];

			echo $before_widget;

			echo '<div class="ci-action-box group">';
			if ( ! empty ( $url ) ){
				echo sprintf('<a href="%s">', esc_url( $url ));
			}

			if ( $image ) {
				$attachment = wp_prepare_attachment_for_js( $image );

				echo sprintf( '<img src="%s" alt="%s" />',
					esc_url( untoldstories_get_image_src( $image, 'untoldstories_thumb_slider' ) ),
					esc_attr( $attachment['alt'] )
				);
			}


			if ( $title ) {
				echo $before_title . $title . $after_title;
			}

			if ( ! empty ( $url ) ){
				echo '</a>';
			}

			echo '</div>';

			echo $after_widget;
		} // widget

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title'] = sanitize_text_field( $new_instance['title'] );
			$instance['image'] = intval( $new_instance['image'] );
			$instance['url']   = esc_url_raw( $new_instance['url'] );

			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title = $instance['title'];
			$image = $instance['image'];
			$url   = $instance['url'];

			?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'untold-stories' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" /></p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Author Image:', 'untold-stories' ); ?></label>
				<div class="untoldstories-upload-preview">
					<div class="upload-preview">
						<?php if ( ! empty( $image ) ): ?>
							<?php
								$image_url = untoldstories_get_image_src( $image, 'untoldstories_thumb_featgal_small_thumb' );
								echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon" title="%s"></a>',
									$image_url,
									esc_attr( esc_html__( 'Remove image', 'untold-stories' ) )
								);
							?>
						<?php endif; ?>
					</div>
					<input type="hidden" class="untoldstories-uploaded-id" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_attr( $image ); ?>" />
					<input id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" type="button" class="button untoldstories-media-button" value="<?php esc_attr_e( 'Select Image', 'untold-stories' ); ?>" />
				</div>
			</p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_html_e( 'Link URL:', 'untold-stories' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="url" value="<?php echo esc_url( $url ); ?>" class="widefat" /></p>

			<?php
		} // form

	} // class

	register_widget( 'Untoldstories_Widget_Callout' );

endif;