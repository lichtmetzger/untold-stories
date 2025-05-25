<?php
if ( ! class_exists( 'Untoldstories_Widget_Socials' ) ):
	class Untoldstories_Widget_Socials extends WP_Widget {

		protected $defaults = array(
			'title' => '',
		);

		function __construct() {
			$widget_ops  = array( 'description' => esc_html__( "Displays the site's social icons.", 'untold-stories' ) );
			$control_ops = array();
			parent::__construct( 'untoldstories-socials', $name = esc_html__( 'Theme - Social Icons', 'untold-stories' ), $widget_ops, $control_ops );
		}

		function widget( $args, $instance ) {
			extract( $args );

			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo $before_widget;

			if ( $title ) {
				echo $before_title . $title . $after_title;
			}

			get_template_part( 'part', 'social-icons' );

			echo $after_widget;
		} // widget

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title'] = sanitize_text_field( $new_instance['title'] );

			return $instance;
		}

		function form( $instance ) {
			$instance = wp_parse_args( (array) $instance, $this->defaults );

			$title = $instance['title'];

			?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'untold-stories' ); ?></label><input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" class="widefat" /></p>
			<p><?php esc_html_e( "This widget displays your site's social icons. In order to set them up, you need to visit Appearance > Customize > Social Networks and provide the appropriate URLs where desired.", 'untold-stories' ); ?></p>
			<?php
		} // form

	} // class

	register_widget( 'Untoldstories_Widget_Socials' );

endif;