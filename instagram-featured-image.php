<?php
/*
Plugin Name: Instagram Featured Image
Plugin URI: http://wp-time.com/instagram-featured-image/
Description: Add instagram featured image in your sidebar easily, responsive and hover animation.
Version: 1.0.1
Author: Qassim Hassan
Author URI: http://qass.im
License: GPLv2 or later
*/

/*  Copyright 2015  Qassim Hassan  (email : qassim.pay@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if( !function_exists('WP_Time') ) {
	function WP_Time() {
		add_menu_page( 'WP Time', 'WP Time', 'update_core', 'WP_Time', 'WP_Time_Page', 'dashicons-admin-links');
		function WP_Time_Page() {
			?>
            	<div class="wrap">
                	<h2>WP Time</h2>
					<div class="tool-box">
                		<h3 class="title">Thanks for using our plugins!</h3>
                    	<p>For more plugins, please visit <a href="http://wp-time.com" title="Our Website" target="_blank">WP Time Website</a> and <a href="https://profiles.wordpress.org/qassimdev/#content-plugins" title="Our profile on WordPress" target="_blank">WP Time profile on WordPress</a>.</p>
                        <p>For contact or support, please visit <a href="http://wp-time.com/contact/" title="Contact us!" target="_blank">WP Time Contact Page</a>.</p>
                        <p>Follow WP Time owner on <a href="https://twitter.com/Qassim_Dev" title="Follow him!" target="_blank">Twitter</a>.</p>
					</div>
					<div class="tool-box">
						<h3 class="title">Beautiful WordPress Themes</h3>
						<p>Get collection of 87 WordPress themes for only $69, a lot of features and free support! <a href="http://j.mp/et_ref_wptimeplugins" title="Get it now!" target="_blank">Get it now</a>.</p>
                        <p>See also <a href="http://j.mp/cm_ref_wptimeplugins" title="CreativeMarket - WordPress themes" target="_blank">CreativeMarket</a> and <a href="http://j.mp/tf_ref_wptimeplugins" title="Themeforest - WordPress themes" target="_blank">Themeforest</a>.</p>
                        <p><a href="http://j.mp/et_ref_wptimeplugins" title="Get collection of 87 WordPress themes for only $69" target="_blank"><img src="http://www.elegantthemes.com/affiliates/banners/570x100.jpg"></a></p>
					</div>
                </div>
			<?php
		}
	}
	add_action( 'admin_menu', 'WP_Time' );
}


// Instagram Featured Image
class QassimInstagramFeaturedImageWidget extends WP_Widget {
	function QassimInstagramFeaturedImageWidget() {
		parent::__construct( false, 'Instagram Featured Image', array('description' => 'Display instagram featured image.') );
	}

	function widget( $args, $instance ) {
		$title = apply_filters('widget_title', esc_attr($instance['title']));
		$instagram_link = $instance['instagram_link'];
		?>
			<?php echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; ?>
                <?php
					$transient_name = $this->id;
					$get_transient = get_transient( $transient_name );
					
					if ( empty( $get_transient ) ){	 
						$transient_output = '';
						
						if( !empty($instagram_link) and preg_match("/(instagram.com)|(instagr.am)+/", $instagram_link) ){
							$instagram_api	= wp_remote_get("http://api.instagram.com/oembed?url=$instagram_link");
							$retrieve		= wp_remote_retrieve_body( $instagram_api );
							$response		= json_decode($retrieve);
							
							if( preg_match('/(No Media Match)|(No URL Match)+/', $retrieve) ){
								echo '<ul><li>Sorry, maybe error link or deleted link.</li></ul>';
								return false;
							}
							
							else{
								$thumbnail_url	= $response->thumbnail_url;
								$transient_output .= '<div class="WPTime-instagram-featured">';
								$transient_output .= '<a href="'.$thumbnail_url.'">';
    							$transient_output .= '<img src="'.$thumbnail_url.'">';
								$transient_output .= '</a>';
								$transient_output .= '</div>';
							}
						}
						
						else{
							echo '<ul><li>Please enter instagram link.</li></ul>';
						}
						
						echo $transient_output;
						set_transient($transient_name, $transient_output, 1800);
						
					}else{
						echo $get_transient;
					}
				?>
			<?php echo $args['after_widget']; ?>
        <?php
	}//widget
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['instagram_link'] = strip_tags($new_instance['instagram_link']);
		return $instance;
	}//update
	
	function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance
		);
		
		$defaults = array(
			'title' => 'Instagram Image',
			'instagram_link' => ''
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$instagram_link = $instance['instagram_link'];
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
            
			<p>
				<label for="<?php echo $this->get_field_id('instagram_link'); ?>">Instagram Link:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id('instagram_link'); ?>" name="<?php echo $this->get_field_name('instagram_link'); ?>" type="text" value="<?php echo $instagram_link; ?>" />
			</p>
            <p>Note: if you want to change instagram link, enter new instagram link and wait 30 minutes, or delete this widget and drag and drop the widget again.</p>
        <?php
		
	}//form
	
}
add_action('widgets_init', create_function('', 'return register_widget("QassimInstagramFeaturedImageWidget");') );

// Add wp head functions
function QassimInstagramFeaturedImageWidget_CSS(){
	?>
    	<style type="text/css">
			.WPTime-instagram-featured{
				overflow:hidden !important;
			}
			.WPTime-instagram-featured a{
				display:block !important;
				text-decoration:none !important;
				border:none !important;
			}

			.WPTime-instagram-featured img{
				transition:ease-in-out 1s !important;
				-moz-transition:ease-in-out 1s !important;
				-o-transition:ease-in-out 1s !important;
				-webkit-transition:ease-in-out 1s !important;
				width:100% !important;
				max-width:100% !important;
				height:auto !important;
			}

			.WPTime-instagram-featured:hover img{
				transform:scale(1.3) !important;
				-webkit-transform:scale(1.3) !important;
				-o-transform:scale(1.3) !important;
				-moz-transform:scale(1.3) !important;
				-ms-transform:scale(1.3) !important;
			}
		</style>
    <?php
}
add_action( 'wp_head', 'QassimInstagramFeaturedImageWidget_CSS' ); 

?>