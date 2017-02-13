<?php

//only execute the contents of this file if the plugin is really being uninstalled
if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit ();
}

global $wpdb;
$tablename = $wpdb->prefix . "hits";

//if the table doesn't exist, create it
if( $wpdb->get_var("SHOW TABLES LIKE '$tablename'") == $tablename ) {

    $sql = "DROP TABLE `$tablename`;";
    $wpdb->query($sql);
}

?>
