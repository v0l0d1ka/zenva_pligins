<?php
/*
Plugin Name: Zenva Cron Email
Plugin URI: http://www.zenva.com
Description: Create a simple cron job. More options: http://codex.wordpress.org/Function_Reference/wp_schedule_event
Version: 1.0
Author: Zenva
Author URI: http://www.zenva.com
License: GPL2
*/

add_action('init', zenvacron_init_cronjob);
add_action('zenvacron_sendmail_hook', zenvacron_sendmail);

/**
 * initiating the cron job
 */
function zenvacron_init_cronjob() {
    if(!wp_next_scheduled('zenvacron_sendmail_hook')) {
        wp_schedule_event(time(), 'hourly', 'zenvacron_sendmail_hook');
    }
}

/**
 * send email
 */
function zenvacron_sendmail() {
    //send email code here
    //get blog admin  http://codex.wordpress.org/Function_Reference/get_bloginfo
    $zva_admin_email = get_bloginfo('admin_email');
    
    wp_mail($zva_admin_email, 'admin', 'Time for your medication!');
}
?>
