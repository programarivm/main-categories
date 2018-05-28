<?php

/**
 * The includes-specific functionality of the plugin.
 */
class Main_Categories_Includes {

	/**
	 * The plugin's name.
	 *
	 * @var string $plugin_name The plugin's name.
	 */
	private $plugin_name;

	/**
	 * The plugin's version.
	 *
	 * @var string $plugin_name The plugin's version.
	 */
	private $version;

	/**
	 * The plugin's widgets.
	 *
	 * @var array $widgets The plugin's widgets.
	 */
	private $widgets = array (
		'Main_Categories_Widget',
	);

	/**
	 * Constructor.
	 *
	 * @param string $plugin_name The plugin's name.
	 * @param string $version The plugin's version.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Registers this plugin's widgets.
	 *
	 */
	public function register_widgets() {
		array_walk( $this->widgets, 'register_widget' );
	}
}
