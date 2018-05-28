<?php

/**
 * Main_Categories_Widget class.
 *
 * A list or dropdown of the main categories.
 */
class Main_Categories_Widget extends WP_Widget
{
	/**
	 * Constructor.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_categories',
			'description' => __( 'A list or dropdown of the main categories.' ),
			'customize_selective_refresh' => true,
		);

		parent::__construct( 'main_categories_widget', __( 'Main Categories' ), $widget_ops );
	}

	/**
	 * Outputs the content to be displayed on the front end.
	 *
	 * @param array $args Display arguments.
	 * @param array $instance Settings for the current Categories widget instance.
	 */
	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Main Categories' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if ( ! empty( $instance['dropdown'] ) ) {

			$dropdown_args = [
				'id' => 'main-cat',
				'name' => 'main-cat',
				'selected' => $_REQUEST['main-cat'],
				'count' => ! empty( $instance['count'] )
			];

			echo $this->dropdown_categories($dropdown_args);

		} else {

			$ul_args = [
				'name' => 'main-cat',
				'count' => ! empty( $instance['count'] )
			];

			echo $this->ul_categories($ul_args);
		}

		echo $args['after_widget'];
	}

	/**
	 * Handles updating settings for the current Plugin_Name_Widget instance.
	 *
	 * @param array $new_instance New settings for this instance.
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['dropdown'] = $new_instance['dropdown'];
		$instance['count'] = $new_instance['count'];

		return $instance;
	}

	/**
	 * Outputs the settings form in the WordPress admin area.
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title = sanitize_text_field( $instance['title'] );
		$dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
		$count = isset($instance['count']) ? (bool) $instance['count'] :false;
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
			<label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label>
			<br/>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label>
		</p>
		<?php
	}

	/**
	 * Gets the main categories.
	 *
	 * @return array|object|null Database query results.
	 */
	private function get_main_categories() {
		global $wpdb;

		$main_categories = $wpdb->get_results("SELECT t.name AS term_name, p.meta_value AS term_id, COUNT(p.meta_value) AS count
			FROM {$wpdb->prefix}postmeta AS p
			JOIN {$wpdb->prefix}terms t ON p.meta_value=t.term_id
			WHERE p.meta_key='main_category_id'
			GROUP BY p.meta_value
			ORDER BY count DESC"
		);

		return $main_categories;
	}

	/**
	 * Gets a dropdown of categories.
	 *
	 * @return string Dropdown of categories.
	 */
	private function dropdown_categories(array $args) {
		$categories = $this->get_main_categories();

		$output = "<form action='" . esc_url( home_url() ) . "' method='get'>\n";
		$output .= "\t<select id='{$args['id']}' class='postform' name='{$args['name']}'>\n";
		$output .= "\t\t<option value='-1'>Select Category</option>\n";
		foreach ( $categories as $category ) {
			$category->term_id == $args['selected'] ? $selected = 'selected' : $selected = '';
			$args['count'] ? $count = "({$category->count})" : $count = '';
			$output .= "\t\t<option class='level-0' value='{$category->term_id}' $selected>{$category->term_name} $count</option>\n";
		}
		$output .= "\t</select></form>\n";

		return $output;
	}

	/**
	 * Gets a list of categories.
	 *
	 * @return string List of categories.
	 */
	private function ul_categories(array $args) {
		$categories = $this->get_main_categories();

		$output = "<ul>\n";
		foreach ( $categories as $category ) {
			$args['count'] ? $count = "({$category->count})" : $count = '';
			$output .= "\t<li class='cat-item main-cat-item-{$category->term_id}'>
				<a href='" . esc_url( home_url() ) . "/?{$args['name']}={$category->term_id}'>{$category->term_name}</a> $count
			</li>\n";
		}
		$output .= "</ul>\n";

		return $output;
	}
}
