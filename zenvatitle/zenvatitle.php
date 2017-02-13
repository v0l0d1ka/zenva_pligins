<?php
/*
Plugin Name: Zenva Happy Titles
Plugin URI: http://www.zenva.com
Description: Learn how to use simple filters. Find the complete list of filters here: http://codex.wordpress.org/Plugin_API/Filter_Reference/
Version: 1.0
Author: Zenva
Author URI: http://www.zenva.com
License: GPL2
*/

add_filter( 'the_title', 'zenvatitle_title');
add_filter( 'the_content', 'zenvatitle_content');
add_filter( 'list_cats', 'zenvatitle_categories');

/**
 * modify title
 */
function zenvatitle_title($text) {
    return '~|O_O|~ '.$text;
}

/**
 * modify content
 */
function zenvatitle_content($text) {
    return strtoupper($text);
}

/**
 * modify categories
 */
function zenvatitle_categories($text) {
    return strtolower($text);
}


?>
