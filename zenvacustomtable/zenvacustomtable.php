<?php
/*
Plugin Name: Zenva Custom Table
Plugin URI: http://www.zenva.com
Description: Create and use custom tables
Version: 1.0
Author: Zenva
Author URI: http://www.zenva.com
License: GPL2
*/

//plugin activation hook
register_activation_hook( __FILE__, 'zvact_create_update_table' );

//plugin deactivation hook (NOT the same as plugin uninstall!)
register_deactivation_hook( __FILE__, 'zvact_deactivate' );

//hook when showing a post
add_filter( 'the_content', 'zvact_save_hit');

/**
 * Create custom tables
 * @global type $wpdb
 */
function zvact_create_update_table() {
    global $wpdb;
    $tablename = $wpdb->prefix . "hits";
    
    //if the table doesn't exist, create it
    if( $wpdb->get_var("SHOW TABLES LIKE '$tablename'") != $tablename ) {

        $sql = "CREATE TABLE `$tablename` (
        `hit_id` INT( 11 ) NOT NULL AUTO_INCREMENT,
        `hit_ip` VARCHAR( 100 ) NOT NULL ,
        `hit_post_id` INT( 11 ) NOT NULL ,
        `hit_date` DATETIME,
        PRIMARY KEY (hit_id)
        );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

/**
 * plugin deactivation
 */
function zvact_deactivate() {
    error_log('plugin deactivated');
}

/**
 * save hit on post
 */
function zvact_save_hit($content) {
    
    //execute if showing a single post only
    if(!is_single()) {
        return $content;
    }
    
    //info
    $post_id = get_the_ID();
    $ip = $_SERVER['REMOTE_ADDR'];
    
    global $wpdb;
    $tablename = $wpdb->prefix . "hits";
    // Insert a record
    $newdata = array(
        'hit_ip' => $ip,
        'hit_date' => current_time( 'mysql' ),
        'hit_post_id' => $post_id
    );
    $wpdb->insert(
        $tablename,
        $newdata
    );
        
    return $content;
}

?>