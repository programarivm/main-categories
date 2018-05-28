<?php

/**
 * Fired when the plugin is uninstalled.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

$wpdb->query("DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key='main_category_id'");
