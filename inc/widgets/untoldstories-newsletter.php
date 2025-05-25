<?php
if ( ! class_exists( 'Untoldstories_Widget_Newsletter' ) ):
	class Untoldstories_Widget_Newsletter extends WP_Widget {

		protected $defaults = array(
			'title' => '',
			'text'  => '',
		);

		public function __construct() {
			$widget_ops  = array( 'description' => esc_html__( 'Provides styling for popular newsletter forms.', 'untold-stories' ) );
			$control_ops = array();
			parent::__construct( 'untoldstories-newsletter', $name = esc_html__( 'Theme - Newsletter', 'untold-stories' ), $widget_ops, $control_ops );
		}

		public function widget( $args, $instance ) {

			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$text  = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );

			echo $args['before_widget'];
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			?><div class="widget_untoldstories_newsletter"><?php echo ! empty( $instance['filter'] ) ? wpautop( do_shortcode( $text ) ) : do_shortcode( $text ); ?></div><?php

			echo $args['after_widget'];
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title'] = strip_tags( $new_instance['title'] );
			if ( current_user_can( 'unfiltered_html' ) ) {
				$instance['text'] = $new_instance['text'];
			} else {
				$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed
			}
			$instance['filter'] = ! empty( $new_instance['filter'] );

			return $instance;
		}

		public function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title = strip_tags( $instance['title'] );
			$text  = esc_textarea( $instance['text'] );
			?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'untold-stories' ); ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"/></p>

			<p><?php esc_html_e( 'Paste your newsletter form as given by popular 3rd-party newsletter services, such as MailChimp, Campaign Monitor, etc.', 'untold-stories' ); ?></p>
			<p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php esc_html_e( 'Newsletter form HTML:', 'untold-stories' ); ?></label><textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea></p>

			<p><input id="<?php echo $this->get_field_id( 'filter' ); ?>" name="<?php echo $this->get_field_name( 'filter' ); ?>" type="checkbox" <?php checked( isset( $instance['filter'] ) ? $instance['filter'] : 0 ); ?> />&nbsp;<label for="<?php echo $this->get_field_id( 'filter' ); ?>"><?php esc_html_e( 'Automatically add paragraphs', 'untold-stories' ); ?></label></p>
			<?php
		}
	}

	register_widget( 'Untoldstories_Widget_Newsletter' );

endif;