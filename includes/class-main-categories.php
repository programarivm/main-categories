<?php

/**
 * Main_Categories class.
 *
 * Allows to designate a primary category for posts.
 */
class Main_Categories
{
	protected $loader;

	protected $plugin_name;

	protected $version;

	public function __construct() {
		if ( defined( 'MAIN_CATEGORIES_VERSION' ) ) {
			$this->version = MAIN_CATEGORIES_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'main-categories';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_includes_hooks();
		$this->define_public_hooks();
	}

	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-main-categories-includes.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-main-categories-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-main-categories-widget.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-main-categories-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-main-categories-public.php';

		$this->loader = new Main_Categories_Loader();
	}

	private function define_admin_hooks() {
		$plugin_admin = new Main_Categories_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_main_category_meta_box');
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_postdata');
	}

	private function define_includes_hooks() {
		$plugin_includes = new Main_Categories_Includes( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'widgets_init', $plugin_includes, 'register_widgets');
	}

	private function define_public_hooks() {
		$plugin_public = new Main_Categories_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'the_posts', $plugin_public, 'get_posts_by_main_category' );
	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}
}
