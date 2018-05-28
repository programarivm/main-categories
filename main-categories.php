<?php
/*
Plugin Name: Main Categories
Plugin URI: https://programarivm.com/
Description: Allows to designate a main category for posts.
Author: Jordi Bassagañas
Author URI: https://programarivm.com/
Text Domain: main-categories
Version: 1.0.0

Copyright 2018 Jordi Bassagañas

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'MAIN_CATEGORIES_VERSION', '1.0.0' );

require plugin_dir_path( __FILE__ ) . 'includes/class-main-categories.php';

function run_main_categories() {
	$plugin = new Main_Categories();
	$plugin->run();
}

run_main_categories();
