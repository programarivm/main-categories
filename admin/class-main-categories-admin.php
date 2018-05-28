<?php

/**
 * The admin-specific functionality of the plugin.
 */
class Main_Categories_Admin
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
	 * Registers the stylesheets for the admin area.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/main-categories-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Registers the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/main-categories-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Adds a meta box for the main category.
	 */
	public function add_main_category_meta_box() {
	    add_meta_box(
	        'main_category_id',
	        __( 'Main Category', 'main_category' ),
			function ($post) {
				$args = array(
					"hide_empty" => 0,
					"orderby"   => "name",
					"order"     => "ASC"
				);

				$categories = get_categories( $args );
				$category_id = get_post_meta( $post->ID, 'main_category_id', true );
				?>
				<select name="main_category_ID" class="postbox">
					<option value="">None</option>
					<?php
					foreach ( $categories as $category ) {
						$category->cat_ID == $category_id ? $selected = 'selected' : $selected = '';
						?>
						<option value="<?php echo $category->cat_ID?>" <?php echo $selected ?>><?php echo $category->name?></option>
					<?php
					}
					?>
				</select>
				<?php
			},
	        'post',
	        'normal',
	        'high'
	    );
	}

	/**
	 * Saves the main_category_id meta key into the postmeta table.
	 */
	public function save_postdata( $post_id ) {
	    if ( ! empty( $_POST['main_category_ID'] ) ) {
	        $post_categories = array_merge( wp_get_post_categories( $post_id ), [ $_POST['main_category_ID'] ] );
	        $post_categories = array_map( 'intval', $post_categories );
	        $term_taxonomy_ids = wp_set_object_terms( $post_id, $post_categories, 'category' );
	        update_post_meta( $post_id, 'main_category_id', $_POST['main_category_ID'] );
	    } else {
	        update_post_meta( $post_id, 'main_category_id', null );
	    }
	}
}
