<?php

/**
 * The includes-specific functionality of the plugin.
 */
class Main_Categories_Includes {

	/**
	 * The ID of this plugin.
	 *
	 * @since	1.0.0
	 * @access	private
	 * @var		string		$plugin_name	The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 	1.0.0
	 * @access 	private
	 * @var		string		$version		The current version of this plugin.
	 */
	private $version;

	/**
	 * The widgets of this plugin.
	 *
	 * @since 	1.0.0
	 * @access 	private
	 * @var		array		$widgets		The widgets of this plugin.
	 */
	private $widgets = array (
		'Main_Categories_Widget',
	);

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 	1.0.0
	 * @param	string		$plugin_name	The name of this plugin.
	 * @param	string		$version		The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Registers this plugin's widgets.
	 *
	 * @since	1.0.0
	 * @access	public
	 */
	public function register_widgets() {
		array_walk( $this->widgets, 'register_widget' );
	}

}
