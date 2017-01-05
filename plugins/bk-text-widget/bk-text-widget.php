<?php
/*
Plugin Name: BK Text Widget
Plugin URI: https://bravokeyl.com/
Description:
Version: 1.0.0
Author: bravokeyl
Author URI: https://bravokeyl.com/
Text Domain: bk-text-widget
*/
class BK_Widget_Text extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_text',
			'description' => __( 'Customized text widget.' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'bktext', __( 'BK Text' ), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {

		$title = apply_filters( 'bk_widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$widget_text = ! empty( $instance['text'] ) ? $instance['text'] : '';

		$text = apply_filters( 'bk_widget_text', $widget_text, $instance, $this );

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
    echo empty($args['before_widget_body'])? '':$args['before_widget_body'];
    ?>
			<div class="textwidget"><?php echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text; ?></div>
		<?php
    echo empty($args['after_widget_body'])? '':$args['after_widget_body'];
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = wp_kses_post( $new_instance['text'] );
		}
		$instance['filter'] = ! empty( $new_instance['filter'] );
		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
		$title = sanitize_text_field( $instance['title'] );
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Content:' ); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox"<?php checked( $filter ); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
		<?php
	}
}

function register_bk_text_widget() {
	register_widget( 'BK_Widget_Text' );
}
add_action( 'widgets_init', 'register_bk_text_widget' );
