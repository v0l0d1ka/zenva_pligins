<?php
/*
Plugin Name: Zenva Video Widget
Plugin URI: http://www.zenva.com
Description: Learn how to create simple widgets and post metadata.
Version: 1.0
Author: Zenva
Author URI: http://www.zenva.com
License: GPL2
*/

//show metabox in post editing page
add_action('add_meta_boxes', 'zvavw_add_metabox' );

//save metabox data
add_action('save_post', 'zvavw_save_metabox' ); 

//register widgets
add_action('widgets_init', 'zvavw_widget_init');

function zvavw_add_metabox() {
    //doc http://codex.wordpress.org/Function_Reference/add_meta_box
    add_meta_box('zvavw_youtube', 'YouTube Video Link','zvavw_youtube_handler', 'post');
}

/**
 * metabox handler
 */
function zvavw_youtube_handler() {
    $value = get_post_custom($post->ID);
    $youtube_link = esc_attr($value['zvavw_youtube'][0]);
    echo '<label for="zvavw_youtube">YouTube Video Link</label><input type="text" id="zvavw_youtube" name="zvavw_youtube" value="'.$youtube_link.'" />';
}

/**
 * save metadata
 */
function zvavw_save_metabox($post_id) {
    //don't save metadata if it's autosave
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return; 
    }    
    
    //check if user can edit post
    if( !current_user_can( 'edit_post' ) ) {
        return;  
    }
    
    if( isset($_POST['zvavw_youtube'] )) {
        update_post_meta($post_id, 'zvavw_youtube', esc_url($_POST['zvavw_youtube']));
    }
}

/**
 * register widget
 */
function zvavw_widget_init() {
    register_widget(Zvavw_Widget);
}

/**
 * widget class
 */
class Zvavw_Widget extends WP_Widget {
    function Zvavw_Widget() {
        $widget_options = array(
            'classname' => 'zvavw_class', //CSS
            'description' => 'Show a YouTube Video from post metadata'
        );
        
        $this->WP_Widget('zvavw_id', 'YouTube Video', $widget_options);
    }
    
    /**
     * show widget form in Appearence / Widgets
     */
    function form($instance) {
        $defaults = array('title' => 'Video');
        $instance = wp_parse_args( (array) $instance, $defaults);
        
        $title = esc_attr($instance['title']);
        
        echo '<p>Title <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'" /></p>';
    }
    
    /**
     * save widget form
     */
    function update($new_instance, $old_instance) {
        
        $instance = $old_instance;        
        $instance['title'] = strip_tags($new_instance['title']);        
        return $instance;
    }
    
    /**
     * show widget in post / page
     */
    function widget($args, $instance) {
        extract( $args );        
        $title = apply_filters('widget_title', $instance['title']);
        
        //show only if single post
        if(is_single()) {
            echo $before_widget;
            echo $before_title.$title.$after_title;
            
            //get post metadata
            $zvavw_youtube = esc_url(get_post_meta(get_the_ID(), 'zvavw_youtube', true));
            
            //print widget content
            echo '<iframe width="200" height="200" frameborder="0" allowfullscreen src="http://www.youtube.com/embed/'.get_yt_videoid($zvavw_youtube).'"></iframe>';       
            
            echo $after_widget;
        }
    }
}

/**
 * get youtube video id from link 
 * from: http://stackoverflow.com/questions/3392993/php-regex-to-get-youtube-video-id
 */
function get_yt_videoid($url) {
    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
    return $my_array_of_vars['v']; 
}

?>
