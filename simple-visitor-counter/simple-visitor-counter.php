<?php
/*
Plugin Name: Simple Visitor Counter
Plugin URI: https://www.vox360.com
Description: This is plugin is use for site visitor counter
Version: 1.0
Author: Azhar Deraiya
Author URI: https://azharderaiya.in
*/
?>
<?php 

function getPostViews( $postID ){
	?><style type="text/css">
		p.counter {
		    /*background-color: #000;
		    margin: 0 auto;
		    display: block;		    
		    padding: 0px 37px;
		    width: 170px;
		    letter-spacing: 5px;*/
		    color: #fff;
		    font-size: 15px;
		    text-align: center;
		    margin-top: 20px;
		}
		p.total-visit.counter span {
			background: black;
			text-align: center !important;
			margin: 1px;
			padding: 0px 5px 0px 5px;
			/* height: 10px !important; */
			border: 2px solid black;
			border-radius: 5px;
			}
	</style><?php
    $post_count_key = 'post_views_count';
    $count = get_post_meta( $postID, $post_count_key, true );
    $totalvisitcount = get_option( 'site_visit_counter' );
    $cnt_visit_counter = str_split( $totalvisitcount );

    //echo $cnt_visit_counter;
    
    if( $count=='' ){
        delete_post_meta( $postID, $post_count_key );
        add_post_meta( $postID, $post_count_key, '0' );
        return "0 View";
    }
    echo '<p class="total-visit counter">';
    foreach ( $cnt_visit_counter as $key => $sin_cnt ) 
    {
    	echo '<span>'.$sin_cnt.'</span>';
    }
    echo '</p>';
    return '<!--<p class="counter">'.$count.' </p>-->
    <!--<p class="total-visit counter">'. $totalvisitcount.'</p>-->';
}



/**
* We are set the view for count
*
*/
function setPostViews( $postID ) {
    
    $post_count_key = 'post_views_count';

    $total_count_key = 'site_visit_counter';

    $count = get_post_meta( $postID, $post_count_key, true );

    $totalvisitcount = get_option( $total_count_key );

    /*This condition is for single post/page count view*/
    if( $count == '' )
    {
        $count = 0;
        delete_post_meta( $postID, $post_count_key );
        add_post_meta( $postID, $post_count_key, '0' );
        
    }
    else
    {
        $count++;
        update_post_meta( $postID, $post_count_key, $count );
    }


    /*This condition is Total Count View*/
    if( $totalvisitcount == '' )
    {
        $totalvisitcount = 0;
        delete_option( $total_count_key );
        add_option( $total_count_key,0 );
    }
    else
    {
        $totalvisitcount++;
        update_option( $total_count_key, $totalvisitcount );
    }

}
// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );


// Create Shorcode for Total View Counter
function simple_visitor_counter_shortcode( $atts_total_view_counter )
{
	$totalvisitcount = get_option( 'site_visit_counter' );
	$total_count_key = 'site_visit_counter';

	$atts_total_view_counter = shortcode_atts( array(
									'start' => add_option $total_count_key, 0 ),
								), $atts_total_view_counter, 'bartag' );

	return "Total Site Visit = {$atts_total_view_counter['start']}";
}
add_shortcode( 'svc', 'simple_visitor_counter_shortcode' );
?>