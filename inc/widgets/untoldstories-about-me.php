<?php
if ( ! class_exists( 'Untoldstories_Widget_About' ) ):
	class Untoldstories_Widget_About extends WP_Widget {

		protected $defaults = array(
			'title'           => '',
			'image'           => '',
			'round'           => 1,
			'invert_color'    => '',
			'text'            => '',
			'greeting_text'   => '',
			'signature_text'  => '',
			'signature_image' => '',
		);

		function __construct() {
			$widget_ops  = array( 'description' => esc_html__( 'Provide information for the blog author, accompanied by a picture.', 'untold-stories' ) );
			$control_ops = array();
			parent::__construct( 'untoldstories-about', $name = esc_html__( 'Theme - About Me', 'untold-stories' ), $widget_ops, $control_ops );
		}

		function widget( $args, $instance ) {
			extract( $args );

			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$text            = $instance['text'];
			$image           = $instance['image'];
			$round           = $instance['round'];
			$invert_color    = $instance['invert_color'];
			$greeting_text   = $instance['greeting_text'];
			$signature_text  = $instance['signature_text'];
			$signature_image = $instance['signature_image'];

			$invert_class  = $invert_color ? 'widget-attention' : '';
			$before_widget = str_replace( 'class="', 'class="' . $invert_class . ' ', $before_widget );

			echo $before_widget;

			if ( $title ) {
				echo $before_title . $title . $after_title;
			}

			echo '<div class="widget_about group">';

			if ( $image ) {
				$attachment = wp_prepare_attachment_for_js( $image );

				echo sprintf( '<p class="widget_about_avatar"><img src="%s" class="%s" alt="%s" /></p>',
					esc_url( untoldstories_get_image_src( $image, 'untoldstories_thumb_square' ) ),
					esc_attr( $round == 1 ? 'img-round' : '' ),
					esc_attr( $attachment['alt'] )
				);
			}

			echo wpautop( do_shortcode( $text ) );

			if ( ! empty( $greeting_text ) || ! empty( $signature_text ) || ! empty( $signature_image ) ) {
				?>
				<p class="widget_about_sig">
					<?php echo esc_html( $greeting_text ); ?>
					<?php if ( ! empty( $signature_image ) ): ?>
						<?php echo wp_get_attachment_image( $signature_image, 'untoldstories_thumb_masonry' ); ?>
					<?php elseif ( ! empty( $signature_text ) ): ?>
						<span><?php echo esc_html( $signature_text ); ?></span>
					<?php endif; ?>
				</p>
				<?php
			}

			echo '</div>';

			echo $after_widget;
		} // widget

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title']           = sanitize_text_field( $new_instance['title'] );
			$instance['image']           = intval( $new_instance['image'] );
			$instance['round']           = untoldstories_sanitize_checkbox_ref( $new_instance['round'] );
			$instance['invert_color']    = untoldstories_sanitize_checkbox_ref( $new_instance['invert_color'] );
			$instance['text']            = wp_kses_post( $new_instance['text'] );
			$instance['greeting_text']   = sanitize_text_field( $new_instance['greeting_text'] );
			$instance['signature_text']  = sanitize_text_field( $new_instance['signature_text'] );
			$instance['signature_image'] = intval( $new_instance['signature_image'] );

			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title           = $instance['title'];
			$image           = $instance['image'];
			$round           = $instance['round'];
			$invert_color    = $instance['invert_color'];
			$text            = $instance['text'];
			$greeting_text   = $instance['greeting_text'];
			$signature_text  = $instance['signature_text'];
			$signature_image = $instance['signature_image'];

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
									esc_attr( esc_html__('Remove image', 'untold-stories') )
								);
							?>
						<?php endif; ?>
					</div>
					<input type="hidden" class="untoldstories-uploaded-id" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_attr( $image ); ?>" />
					<input id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" type="button" class="button untoldstories-media-button" value="<?php esc_attr_e( 'Select Image', 'untold-stories' ); ?>" />
				</div>
			</p>

			<p><label for="<?php echo $this->get_field_id( 'round' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'round' ); ?>" id="<?php echo $this->get_field_id( 'round' ); ?>" value="1" <?php checked( $round, 1 ); ?> /><?php esc_html_e( 'Show round image. For this to work, you need a square image. (200&times;200px or higher).', 'untold-stories' ); ?></label></p>

			<p><label for="<?php echo $this->get_field_id( 'invert_color' ); ?>"><input type="checkbox" name="<?php echo $this->get_field_name( 'invert_color' ); ?>" id="<?php echo $this->get_field_id( 'invert_color' ); ?>" value="1" <?php checked( $invert_color, 1 ); ?> /><?php esc_html_e( 'Invert widget color scheme.', 'untold-stories' ); ?></label></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'About text:', 'untold-stories' ); ?></label><textarea rows="10" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" class="widefat"><?php echo esc_textarea( $text ); ?></textarea></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'greeting_text' ) ); ?>"><?php esc_html_e( 'Greeting (sign off) text:', 'untold-stories' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'greeting_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'greeting_text' ) ); ?>" type="text" value="<?php echo esc_attr( $greeting_text ); ?>" class="widefat" /></p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'signature_text' ) ); ?>"><?php esc_html_e( 'Signature text:', 'untold-stories' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'signature_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'signature_text' ) ); ?>" type="text" value="<?php echo esc_attr( $signature_text ); ?>" class="widefat" /></p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'signature_image' ) ); ?>"><?php esc_html_e( 'Signature Image:', 'untold-stories' ); ?></label>
				<div class="untoldstories-upload-preview">
					<div class="upload-preview">
						<?php if ( ! empty( $signature_image ) ): ?>
							<?php
								$image_url = untoldstories_get_image_src( $signature_image, 'untoldstories_thumb_featgal_small_thumb' );
								echo sprintf( '<img src="%s" /><a href="#" class="close media-modal-icon" title="%s"></a>',
									$image_url,
									esc_attr( esc_html__('Remove image', 'untold-stories') )
								);
							?>
						<?php endif; ?>
					</div>
					<input type="hidden" class="untoldstories-uploaded-id" name="<?php echo esc_attr( $this->get_field_name( 'signature_image' ) ); ?>" value="<?php echo esc_attr( $signature_image ); ?>" />
					<input id="<?php echo esc_attr( $this->get_field_id( 'signature_image' ) ); ?>" type="button" class="button untoldstories-media-button" value="<?php esc_attr_e( 'Select Image', 'untold-stories' ); ?>" />
				</div>
			</p>

			<?php
		} // form

	} // class

	register_widget( 'Untoldstories_Widget_About' );

endif;