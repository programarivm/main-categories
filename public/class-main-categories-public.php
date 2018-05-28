<?php

/**
 * The public-facing functionality of the plugin.
 */
class Main_Categories_Public
{
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
	 * Register the stylesheets for the public-facing side of the site.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/main-categories-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Registers the JavaScript for the public-facing side of the site.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/main-categories-public.js', array( 'jquery' ), $this->version, false );
		$this->localize_scripts();
	}

	/**
	 * Gets the posts by main category.
	 *
	 * @param array $posts All posts.
	 * @return array The posts filtered by main category.
	 */
	public function get_posts_by_main_category( $posts ) {
	    if ( isset($_REQUEST['main-cat']) ) {
	        $result = [];
	        foreach ( $posts as $post ) {
	            $category_id = get_post_meta( $post->ID, 'main_category_id', true );
	            if ( $category_id == $_REQUEST['main-cat'] ) {
	                $result[] = $post;
	            }
	        }
	        return $result;
	    } else {
	        return $posts;
	    }
	}

	/**
	 * Localizes registered scripts with data for JavaScript variables. 
	 */
	private function localize_scripts() {
		$data = array(
			'dropdown_id' => 'main-cat'
		);
		wp_localize_script( $this->plugin_name, 'Main_Categories_Widget', $data );
	}
}
