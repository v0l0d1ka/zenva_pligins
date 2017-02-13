<?php
/*
Plugin Name: Zenva Shortcodes and remote data
Plugin URI: http://www.zenva.com
Description: Learn how to create shortcodes and to retrieve data from the web. Shortcodes in Wordpress: http://wp.smashingmagazine.com/2012/05/01/wordpress-shortcodes-complete-guide/ , default shortcodes you can use: http://en.support.wordpress.com/shortcodes/
Version: 1.0
Author: Zenva
Author URI: http://www.zenva.com
License: GPL2
*/

add_action('init', 'zvash_register_shortcodes');

function zvash_register_shortcodes() {
    //register shortcode    [rate from="USD" to="EUR"]USD/EUR[/currency]     1.1 USD/EUR
    add_shortcode( 'rate', 'zvash_rate' );
}

function zvash_rate($args, $content) {
    $result = wp_remote_get('http://finance.yahoo.com/d/quotes.csv?s='.$args['from'].$args['to'].'=X&f=l1');
    return $result['body'].' '.esc_attr($content);    
}


?>