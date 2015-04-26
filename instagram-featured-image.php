<?php
/*
Plugin Name: Instagram Featured Image
Plugin URI: http://wp-time.com/instagram-featured-image/
Description: Add instagram featured image in your sidebar easily, responsive and hover animation.
Version: 1.2
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


// WP Time Menu
if( !function_exists('WPTime_Add_Admin_Bar_Menu_Aff') ) {

	function WPTime_Add_Admin_Bar_Menu_Aff() {

		global $wp_admin_bar;

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-parent',
				'parent'	=>		0,
				'title' 	=> 		'WP Time',
				'href' 		=> 		'http://wp-time.com',
				'meta'		=>		array('target' => '_blank')
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-gl',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'Best Gallery & Portfolio WordPress Plugins',
				'href' 		=> 		'http://j.mp/GL_WPTime',
				'meta'		=>		array('target' => '_blank')
			)
		);
		
		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-et',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'Collection Of 87 WP Themes For $69 Only',
				'href' 		=> 		'http://j.mp/ET_WPTime_ref_pl',
				'meta'		=>		array('target' => '_blank')
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-cm',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'WP Themes On Creative Market',
				'href' 		=> 		'http://j.mp/CM_WPTime',
				'meta'		=>		array('target' => '_blank')
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-tf',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'WP Themes On Themeforest',
				'href' 		=> 		'http://j.mp/TF_WPTime',
				'meta'		=>		array('target' => '_blank')
			)
		);
	
		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-cc',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'WP Plugins On Codecanyon',
				'href' 		=> 		'http://j.mp/CC_WPTime',
				'meta'		=>		array('target' => '_blank')
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-bh',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'Unlimited Web Hosting For $3.95 Only',
				'href' 		=> 		'http://j.mp/BH_WPTime',
				'meta'		=>		array('target' => '_blank')
			)
		);

		$wp_admin_bar->add_menu(
			array(
				'id' 		=> 		'wptime-aff-menu-cas',
				'parent'	=>		'wptime-aff-menu-parent',
				'title' 	=> 		'Contact And Support',
				'href' 		=> 		'http://wp-time.com/contact/',
				'meta'		=>		array('target' => '_blank')
			)
		);

	}
	
	add_action( 'wp_before_admin_bar_render', 'WPTime_Add_Admin_Bar_Menu_Aff');

}


// WP Time Page
if( !function_exists('WP_Time_Ghozylab_Aff') ) {
	function WP_Time_Ghozylab_Aff() {
		add_menu_page( 'WP Time', 'WP Time', 'update_core', 'WP_Time_Ghozylab_Aff', 'WP_Time_Ghozylab_Aff_Page');
		function WP_Time_Ghozylab_Aff_Page() {
			?>
            	<div class="wrap">
                	<h2>WP Time</h2>
					<div class="tool-box">
                		<h3 class="title">Thanks for using our plugins!</h3>
                    	<p>For more plugins, please visit <a href="http://wp-time.com" target="_blank">WP Time Website</a> and <a href="https://profiles.wordpress.org/qassimdev/#content-plugins" target="_blank">WP Time profile on WordPress</a>.</p>
                        <p>For contact or support, please visit <a href="http://wp-time.com/contact/" target="_blank">WP Time Contact Page</a>.</p>
					</div>
					<div class="tool-box">
						<h3 class="title">Great WordPress Plugins</h3>
						<p>Best Gallery & Portfolio WordPress Plugins <a href="http://j.mp/GL_WPTime" target="_blank">Download Now</a>.</p>
                        <p><a href="http://j.mp/GL_WPTime" target="_blank"><img src="http://content.ghozylab.com/partners/aff/images/global-aff-img.png" width="728" height="90"></a></p>
					</div>
                </div>
			<?php
		}
	}
	add_action( 'admin_menu', 'WP_Time_Ghozylab_Aff' );
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