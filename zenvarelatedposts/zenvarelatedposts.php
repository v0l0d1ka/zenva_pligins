<?php
/*
Plugin Name: Zenva Related Posts
Plugin URI: http://www.zenva.com
Description: Load posts from the database. Read: https://codex.wordpress.org/Class_Reference/WP_Query and https://codex.wordpress.org/The_Loop and https://codex.wordpress.org/Template_Tags
Version: 1.0
Author: Zenva
Author URI: http://www.zenva.com
License: GPL2
*/

add_filter( 'the_content', 'zvarp_add_related_posts' );

/**
 * Add links to related posts at the end of the content
 */
function zvarp_add_related_posts($content) {
    //if it's not a singular post, ignore
    if(!is_singular('post')) {
        return $content;
    }
    
    //get post categories   http://codex.wordpress.org/Function_Reference/get_the_terms
    $categories = get_the_terms(get_the_ID(),'category' );
    $categoriesIds = array(); 
    
    foreach($categories as $category) {
        $categoriesIds[] = $category->term_id;
    }
    
    $loop = new WP_Query(array(
        'category_in' => $categoriesIds,
        'posts_per_page' => 4,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand'
    ));
    
    //if there are posts
    if($loop->have_posts()) {
        
        $content .= 'RELATED POSTS:<br/><ul>';
        while($loop->have_posts()) {
            $loop->the_post();
            $content .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
        }
        $content .= '</ul>';
    }
    
    //retore data http://codex.wordpress.org/Function_Reference/wp_reset_query
    wp_reset_query();
    
    return $content;
}

?>
