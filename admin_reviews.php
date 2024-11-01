<?php
/*
 * Plugin Name:  WP Admin Reviews
 * Version: 1.0
 * Plugin URI: https://webmantechnologies.com
 * Description: Toolkit for add new comments from admin.
 * Author: Webman Technologies
 * Text Domain: arw_admin_review  
 * Tested up to: 4.9  
 * License: GPLv2 or later
 
WP Admin Reviews is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

WP Admin Reviews is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>


 Copyright (C) 2018  Orem Technologies
*/

defined( 'ABSPATH' ) or exit; 

class ARW_admin_reviews{
    public function __construct() {		
        add_action( 'admin_enqueue_scripts', array( $this, 'ARW_admin_enqueue_scripts' ));  
		add_action( 'admin_menu', array( $this, 'ARW_add_menu' ));
		add_action( 'wp_ajax_ARW_get_products', array( $this, 'ARW_get_products' ));
		add_action( 'wp_ajax_ARW_get_userlist', array( $this, 'ARW_get_userlist' ));				add_action( 'edit_form_top' , array( $this, 'change_comment_title' ));
    }	public function change_comment_title() {				global $current_screen;		if( $current_screen->id == 'edit-comments' ) {						echo "<a href='#' id='my-custom-header-link'>hhh</a>";		}			}
    public function ARW_add_menu() {
		add_comments_page('Add new', 'Add new', 'manage_options', 'admin_reviews-dashboard', array(
		__CLASS__,'ARW_render_submenu_pages'), 'dashicons-share','2.2.9');
    }

	public function ARW_get_products() {
		$postdata = $_POST;
		$status=0;
		$spi_postname = trim($postdata['spi_postname']);
		$arw_posttype = $postdata['post_type'];

		global $wpdb;
		$sql = "SELECT * FROM $wpdb->posts WHERE post_type='$arw_posttype' and post_status = 'publish' and post_title LIKE '%$spi_postname%'";
		 $listhtml="";
		$myposts = $wpdb->get_results( $sql);
		if($myposts){
			$listhtml="<span class='select2-container select2-container--default select2-container--open'><span class='select2-dropdown select2-dropdown--below' dir='ltr' style='width: 247px;'><span class='select2-results'><ul class='select2-results__options' role='listbox'>";
			foreach($myposts as $postkey=>$single_post){
				
				$post_title = substr($single_post->post_title,0,20);
				$listhtml=$listhtml."<li  role='option' class='select2-results__option search_post' postid='".$single_post->ID."'>".$post_title."</li>";
			}
			$listhtml=$listhtml."</ul></span></span></span>";
			$status=1;
		}
		$Response = array('status' =>$status, 'html' => $listhtml);
		echo json_encode($Response);
		exit();  
    }
	public function get_IP_address()
	{
		foreach (array('HTTP_CLIENT_IP',
					   'HTTP_X_FORWARDED_FOR',
					   'HTTP_X_FORWARDED',
					   'HTTP_X_CLUSTER_CLIENT_IP',
					   'HTTP_FORWARDED_FOR',
					   'HTTP_FORWARDED',
					   'REMOTE_ADDR') as $key){
			if (array_key_exists($key, $_SERVER) === true){
				foreach (explode(',', $_SERVER[$key]) as $IPaddress){
					$IPaddress = trim($IPaddress); // Just to be safe

					if (filter_var($IPaddress,
								   FILTER_VALIDATE_IP,
								   FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)
						!== false) {

						return $IPaddress;
					}
				}
			}
		}
	}
	public function ARW_get_userlist(){
		$search_string = esc_attr( trim( $_POST['arw_username'] ) );
	/* 	$users = new WP_User_Query( array(
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key'     => 'first_name',
					'value'   => $search_string,
					'compare' => 'LIKE'
				),
				array(
					'key'     => 'nickname',
					'value'   => $search_string,
					'compare' => 'LIKE'
				),
				array(
					'key'     => 'last_name',
					'value'   => $search_string,
					'compare' => 'LIKE'
				)
			)
		) ); */
		$users = new WP_User_Query( array(
					'search'         => '*'.esc_attr( $search_string ).'*',
					'search_columns' => array(
						'user_login',
					),
				) );
		$users_found = $users->get_results();
	//print_r($users_found);
		$html="<span class='select2-container select2-container--default select2-container--open'><span class='select2-dropdown select2-dropdown--below' dir='ltr' style='width: 247px;'><span class='select2-results'><ul class='select2-results__options' role='listbox' >";
		foreach($users_found as $user_detail){			
			$html= $html."<li role='option' class='select2-results__option user_detail' email='".$user_detail->data->user_email."' user_url='".$user_detail->data->user_url."' user_id='".$user_detail->data->ID."'>".$user_detail->data->user_login."</li>";
		}
		$html= $html."</ul></span></span></span>";
		if($users_found){
			$Response = array('status' =>1, 'html' => $html );
		}else{
			$Response = array('status' =>0, 'html' => "User not found" );
		}
		
		echo json_encode($Response);
		exit();
	}
	public function ARW_admin_enqueue_scripts(){		wp_register_script( 'spi_script', plugins_url('/js/arw_script.js', __FILE__ ), array( 'jquery' ), '', true );		wp_localize_script( 'spi_script', 'ajax_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );		wp_enqueue_script( 'spi_script' );	
		/* wp_enqueue_script('spi_script',  plugins_url('/js/arw_script.js', __FILE__ ) , array('jquery'), '', true);  */
		wp_enqueue_style( 'spi-style', plugins_url('/css/arw-style.css', __FILE__),array(),'1' );
	}
	public function ARW_render_submenu_pages(){		if ( !current_user_can( 'administrator' ) )		   {			  wp_die( 'You are not allowed to be on this page.' );		   }
		session_start();		$dateerror = 0;		$commentdata = $_POST;
		if(isset($_POST['newcomment_author']) && isset($_POST['newcomment_author_email'])){			if( ! preg_match('/^\d+$/', $commentdata['aa']) || ! preg_match('/^\d+$/', $commentdata['mm']) || ! preg_match('/^\d+$/', $commentdata['jj']) || ! preg_match('/^\d+$/', $commentdata['hh']) || ! preg_match('/^\d+$/', $commentdata['mn']) ){				$dateerror=1;			}			if($dateerror!=1){				$date=date_create($commentdata['aa']."-".$commentdata['mm']."-".$commentdata['jj']." ".$commentdata['hh'].":".$commentdata['mn'].":".$commentdata['ss']);				$commentdatatime =  date_format($date,"Y/m/d H:i:s"); 				$commentdatatime = strtotime($commentdatatime); 				$currenttime = strtotime(date("Y/m/d H:i:s"));				if($currenttime<$commentdatatime){					$dateerror=2;				}			}
			$arw_postids = array();
			if($commentdata['arw_posttype']!="" && $commentdata['arw_rating']!="" && $commentdata['arw_product_listing']!="" && $commentdata['newcomment_author_email']!="" && $commentdata['newcomment_author']!="" && $commentdata['content']!="" ){						if($dateerror==0){
			$nonce =  sanitize_text_field($_POST['arw_add_cmnt_admin_review'] );
			   global $wpdb;

					if( wp_verify_nonce($nonce,'arw_add_cmnt_admin_review') ){
						foreach($commentdata['arw_product_listing'] as $arw_product_listing){
							if($commentdata['arw_userid']){
								$arwuserid = $commentdata['arw_userid'];
								$usersql = "SELECT * FROM $wpdb->users WHERE ID ='$arwuserid'";
								$myuser = $wpdb->get_results( $usersql);
								if(empty($myuser)){
									$arwuserid = 0;
								}
							}
							$sql = "SELECT * FROM $wpdb->posts WHERE ID ='$arw_product_listing'";
							$myposts = $wpdb->get_results( $sql);
							if($myposts){
								if (!in_array($arw_product_listing, $arw_postids)) {
									$arw_postids[] = $arw_product_listing;
									$data = array(
										'comment_post_ID' => $arw_product_listing,
										'comment_author' => $commentdata['newcomment_author'],
										'comment_author_email' => $commentdata['newcomment_author_email'],
										'comment_author_url' => $commentdata['newcomment_author_url'],
										'comment_content' => $commentdata['content'],
										'comment_type' => 'By ARW Orem',
										'comment_parent' => 0,
										'user_id' => $arwuserid,
										'comment_author_IP' => $commentdata['client_ip'],
										'comment_agent' => $commentdata['client_agent'],
										'comment_date' => $commentdatatime,
										'comment_approved' => $commentdata['comment_status'],
									);
									$comntid= wp_insert_comment($data);
									$rating = intval( $commentdata['arw_rating'] );
									add_comment_meta( $comntid, 'rating', $rating );
									
									$_SESSION[ 'arw_alert_msgs' ] = __( '<div class="updated notice"><p>Comment Added Successfully!!</p></div>' );
								}
							}else{
								$_SESSION[ 'arw_invalid_alert_msgs' ] = __( '<div class="error notice"><p>Invalid requested ID`s!!</p></div>' );
							}
						}
					}else{
						 $_SESSION[ 'arw_alert_msgs' ] = __( '<div class="error notice"><p>Invalid request type!!</p></div>' );
					}
				$url = site_url()."/wp-admin/edit-comments.php?page=admin_reviews-dashboard";
				wp_redirect( $url ); exit;			}else{				if($dateerror==1){					$_SESSION[ 'arw_alert_msgs' ] = __( '<div class="error notice"><p>Invalid date format!!</p></div>' );				}else{					$_SESSION[ 'arw_alert_msgs' ] = __( '<div class="error notice"><p>Future date not allowed!!</p></div>' );				}								$url = site_url()."/wp-admin/edit-comments.php?page=admin_reviews-dashboard";				wp_redirect( $url ); exit; 			}
			}else{
				 $_SESSION[ 'arw_alert_msgs' ] = __( '<div class="error notice"><p>Please fill required fields!!</p></div>' );
				$url = site_url()."/wp-admin/edit-comments.php?page=admin_reviews-dashboard";
				wp_redirect( $url ); exit; 
			}
		}
		include( plugin_dir_path( __FILE__ ) . 'templates/arw_addnew.php');
	}
}
new ARW_admin_reviews();
?>