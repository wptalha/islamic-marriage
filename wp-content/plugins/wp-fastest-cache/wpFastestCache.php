<?php
/*
Plugin Name: WP Fastest Cache
Plugin URI: http://wordpress.org/plugins/wp-fastest-cache/
Description: The simplest and fastest WP Cache system
Version: 0.8.7.8
Author: Emre Vona
Author URI: http://tr.linkedin.com/in/emrevona
Text Domain: wp-fastest-cache
Domain Path: /languages/

Copyright (C)2013 Emre Vona

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/
	//test6
	if (!defined('WPFC_WP_CONTENT_BASENAME')) {
		if (!defined('WPFC_WP_PLUGIN_DIR')) {
			if(preg_match("/(\/trunk\/|\/wp-fastest-cache\/)$/", plugin_dir_path( __FILE__ ))){
				define("WPFC_WP_PLUGIN_DIR", preg_replace("/(\/trunk\/|\/wp-fastest-cache\/)$/", "", plugin_dir_path( __FILE__ )));
			}else if(preg_match("/\\\wp-fastest-cache\/$/", plugin_dir_path( __FILE__ ))){
				//D:\hosting\LINEapp\public_html\wp-content\plugins\wp-fastest-cache/
				define("WPFC_WP_PLUGIN_DIR", preg_replace("/\\\wp-fastest-cache\/$/", "", plugin_dir_path( __FILE__ )));
			}
		}
		define("WPFC_WP_CONTENT_DIR", dirname(WPFC_WP_PLUGIN_DIR));
		define("WPFC_WP_CONTENT_BASENAME", basename(WPFC_WP_CONTENT_DIR));
	}

	if (!defined('WPFC_MAIN_PATH')) {
		define("WPFC_MAIN_PATH", plugin_dir_path( __FILE__ ));
	}

	if(!isset($GLOBALS["wp_fastest_cache_options"])){
		if($wp_fastest_cache_options = get_option("WpFastestCache")){
			$GLOBALS["wp_fastest_cache_options"] = json_decode($wp_fastest_cache_options);
		}else{
			$GLOBALS["wp_fastest_cache_options"] = array();
		}
	}

	function wpfastestcache_activate(){
		if($options = get_option("WpFastestCache")){
			$post = json_decode($options, true);

			include_once('inc/admin.php');
			$wpfc = new WpFastestCacheAdmin();
			$wpfc->modifyHtaccess($post);
		}
	}

	function wpfastestcache_deactivate(){
		$wpfc = new WpFastestCache();

		$path = ABSPATH;
		
		if($wpfc->is_subdirectory_install()){
			$path = $wpfc->getABSPATH();
		}

		if(is_file($path.".htaccess") && is_writable($path.".htaccess")){
			$htaccess = file_get_contents($path.".htaccess");
			$htaccess = preg_replace("/#\s?BEGIN\s?WpFastestCache.*?#\s?END\s?WpFastestCache/s", "", $htaccess);
			$htaccess = preg_replace("/#\s?BEGIN\s?GzipWpFastestCache.*?#\s?END\s?GzipWpFastestCache/s", "", $htaccess);
			$htaccess = preg_replace("/#\s?BEGIN\s?LBCWpFastestCache.*?#\s?END\s?LBCWpFastestCache/s", "", $htaccess);
			$htaccess = preg_replace("/#\s?BEGIN\s?WEBPWpFastestCache.*?#\s?END\s?WEBPWpFastestCache/s", "", $htaccess);
			@file_put_contents($path.".htaccess", $htaccess);
		}

		$wpfc->deleteCache();
	}

	register_activation_hook( __FILE__, "wpfastestcache_activate");
	register_deactivation_hook( __FILE__, "wpfastestcache_deactivate");

	class WpFastestCache{
		private $systemMessage = "";
		private $options = array();
		public $noscript = "";

		public function __construct(){
			$optimize_image_ajax_requests = array("wpfc_revert_image_ajax_request", 
												  "wpfc_statics_ajax_request",
												  "wpfc_optimize_image_ajax_request",
												  "wpfc_update_image_list_ajax_request"
												  );

			add_action('wp_ajax_wpfc_delete_cache', array($this, "deleteCacheToolbar"));
			add_action('wp_ajax_wpfc_delete_cache_and_minified', array($this, "deleteCssAndJsCacheToolbar"));
			add_action('wp_ajax_wpfc_delete_current_page_cache', array($this, "delete_current_page_cache"));
			add_action( 'wp_ajax_wpfc_save_timeout_pages', array($this, 'wpfc_save_timeout_pages_callback'));
			add_action( 'wp_ajax_wpfc_save_exclude_pages', array($this, 'wpfc_save_exclude_pages_callback'));
			add_action( 'wp_ajax_wpfc_cdn_options', array($this, 'wpfc_cdn_options_ajax_request_callback'));
			add_action( 'wp_ajax_wpfc_remove_cdn_integration', array($this, 'wpfc_remove_cdn_integration_ajax_request_callback'));
			add_action( 'wp_ajax_wpfc_save_cdn_integration', array($this, 'wpfc_save_cdn_integration_ajax_request_callback'));
			add_action( 'wp_ajax_wpfc_cdn_template', array($this, 'wpfc_cdn_template_ajax_request_callback'));
			add_action( 'wp_ajax_wpfc_check_url', array($this, 'wpfc_check_url_ajax_request_callback'));
			add_action( 'wp_ajax_wpfc_cache_statics_get', array($this, 'wpfc_cache_statics_get_callback'));
			add_action( 'wp_ajax_wpfc_db_statics', array($this, 'wpfc_db_statics_callback'));
			add_action( 'wp_ajax_wpfc_db_fix', array($this, 'wpfc_db_fix_callback'));
			add_action( 'rate_post', array($this, 'wp_postratings_clear_fastest_cache'), 10, 2);
			add_action( 'user_register', array($this, 'modify_htaccess_for_new_user'), 10, 1);
			add_action( 'profile_update', array($this, 'modify_htaccess_for_new_user'), 10, 1);
			add_action( 'edit_terms', array($this, 'delete_cache_of_term'), 10, 1);

			// to check nonce is timeout or not
			//add_action('init', array($this, "nonce_timeout"));

			// to clear cache after new Woocommerce orders
			add_action( 'woocommerce_checkout_order_processed', array($this, 'clear_cache_after_woocommerce_checkout_order_processed'), 1, 1);

			// kk Star Ratings: to clear the cache of the post after voting
			add_action( 'kksr_rate', array($this, 'clear_cache_on_kksr_rate'));

			// to clear cache after ajax request by other plugins
			if(isset($_POST["action"])){
				// All In One Schema.org Rich Snippets
				if(preg_match("/bsf_(update|submit)_rating/i", $_POST["action"])){
					if(isset($_POST["post_id"])){
						$this->singleDeleteCache(false, $_POST["post_id"]);
					}
				}

				// Yet Another Stars Rating
				if($_POST["action"] == "yasr_send_visitor_rating"){
					if(isset($_POST["post_id"])){
						// to need call like that because get_permalink() does not work if we call singleDeleteCache() directly
						add_action('init', array($this, "singleDeleteCache"));
					}
				}
			}

			// to clear /tmpWpfc folder
			if(is_dir($this->getWpContentDir()."/cache/tmpWpfc")){
				$this->rm_folder_recursively($this->getWpContentDir()."/cache/tmpWpfc");
			}

			if($this->isPluginActive('wp-polls/wp-polls.php')){
					//for WP-Polls 
					require_once "inc/wp-polls.php";
					$wp_polls = new WpPollsForWpFc();
					$wp_polls->hook();
			}

			if(isset($_GET) && isset($_GET["action"]) && in_array($_GET["action"], $optimize_image_ajax_requests)){
				if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
					include_once $this->get_premium_path("image.php");
					$img = new WpFastestCacheImageOptimisation();
					$img->hook();
				}
			}else if(isset($_GET) && isset($_GET["action"])  && $_GET["action"] == "wpfastestcache"){
				if(isset($_GET) && isset($_GET["type"])  && $_GET["type"] == "preload"){
					// /?action=wpfastestcache&type=preload
					
					add_action('init', array($this, "create_preload_cache"), 11);
				}
			}else{
				$this->setCustomInterval();

				$this->options = $this->getOptions();

				add_action('transition_post_status',  array($this, 'on_all_status_transitions'), 10, 3 );

				$this->commentHooks();

				$this->checkCronTime();

				if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
					include_once $this->get_premium_path("mobile-cache.php");

					if(file_exists(WPFC_WP_PLUGIN_DIR."/wp-fastest-cache-premium/pro/library/statics.php")){
						include_once $this->get_premium_path("statics.php");
					}

					if(!defined('DOING_AJAX')){
						include_once $this->get_premium_path("powerful-html.php");
					}
				}

				if(is_admin()){
					add_action('wp_loaded', array($this, "load_column"));
					
					if(defined('DOING_AJAX') && DOING_AJAX){
						//do nothing
					}else{
						// to avoid loading menu and optionPage() twice
						if(!class_exists("WpFastestCacheAdmin")){
							//for wp-panel
							
							if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
								include_once $this->get_premium_path("image.php");
							}

							if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
								include_once $this->get_premium_path("logs.php");
							}

							add_action('plugins_loaded', array($this, 'wpfc_load_plugin_textdomain'));
							add_action('wp_loaded', array($this, "load_admin_toolbar"));

							$this->admin();
						}
					}
				}else{
					if(preg_match("/wpfc-minified\/([^\/]+)\/([^\/]+)/", $this->current_url(), $path)){
						if($sources = @scandir(WPFC_WP_CONTENT_DIR."/cache/wpfc-minified/".$path[1], 1)){
							if(isset($sources[0])){
								// $exist_url = str_replace($path[2], $sources[0], $this->current_url());
								// header('Location: ' . $exist_url, true, 301);
								// exit;

								if(preg_match("/\.css/", $this->current_url())){
									header('Content-type: text/css');
								}else if(preg_match("/\.js/", $this->current_url())){
									header('Content-type: text/js');
								}

								echo file_get_contents(WPFC_WP_CONTENT_DIR."/cache/wpfc-minified/".$path[1]."/".$sources[0]);
								exit;
							}
						}

						//for non-exists files
						if(preg_match("/\.css/", $this->current_url())){
							header('Content-type: text/css');
							die("/* File not found */");
						}else if(preg_match("/\.js/", $this->current_url())){
							header('Content-type: text/js');
							die("//File not found");
						}
					}else{
						// to show if the user is logged-in
						add_action('wp_loaded', array($this, "load_admin_toolbar"));

						//for cache
						$this->cache();
					}
				}
			}
		}

		public function set_content_url(){
			$content_url = content_url();

			// Hide My WP
			if($this->isPluginActive('hide_my_wp/hide-my-wp.php')){
				$hide_my_wp = get_option("hide_my_wp");

				if(isset($hide_my_wp["new_content_path"]) && $hide_my_wp["new_content_path"]){
					$hide_my_wp["new_content_path"] = trim($hide_my_wp["new_content_path"], "/");
					$content_url = str_replace(basename(WPFC_WP_CONTENT_DIR), $hide_my_wp["new_content_path"], $content_url);
				}
			}

			if (!defined('WPFC_WP_CONTENT_URL')) {
				define("WPFC_WP_CONTENT_URL", $content_url);
			}
		}

		public function clear_cache_on_kksr_rate($id){
			$this->singleDeleteCache(false, $id);
		}

		public function nonce_timeout(){
			if(!is_user_logged_in()){
				$run = false;
				$list = array(
							  "caldera-forms/caldera-core.php",
							  "contact-form-7/wp-contact-form-7.php",
							  "js_composer/js_composer.php",
							  "kk-star-ratings/index.php",
							  "ninja-forms/ninja-forms.php",
							  "yet-another-stars-rating/yet-another-stars-rating.php"
							  );

				foreach ($list as $key => $value) {
					if($this->isPluginActive($value)){
						$run = true;
					}
				}

				if($run){
					include_once('inc/nonce-timeout.php');
					
					$wpfc_nonce = new WPFC_NONCE_TIMEOUT(WPFC_WP_CONTENT_DIR."/cache/all");
					
					if(!$wpfc_nonce->verify_nonce()){
						$this->deleteCache();
					}
				}
			}
		}

		public function clear_cache_after_woocommerce_checkout_order_processed($order_id = false){
			if(function_exists("wc_get_order")){
				if($order_id){
					$order = wc_get_order($order_id);

					if($order){
						foreach($order->get_items() as $item_key => $item_values ){
							if(method_exists($item_values, 'get_product_id')){
								$this->singleDeleteCache(false, $item_values->get_product_id());
							}
						}
					}
				}
			}
		}

		public function wpfc_db_fix_callback(){
			if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
				include_once $this->get_premium_path("db.php");

				if(class_exists("WpFastestCacheDatabaseCleanup")){
					WpFastestCacheDatabaseCleanup::clean($_GET["type"]);
				}else{
					die(json_encode(array("success" => false, "showupdatewarning" => true, "message" => "Only available in Premium version")));
				}

			}else{
				die(json_encode(array("success" => false, "message" => "Only available in Premium version")));
			}
		}

		public function wpfc_db_statics_callback(){
			global $wpdb;

            $statics = array("all_warnings" => 0,
                             "post_revisions" => 0,
                             "trashed_contents" => 0,
                             "trashed_spam_comments" => 0,
                             "trackback_pingback" => 0,
                             "transient_options" => 0
                            );


            $statics["post_revisions"] = $wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE post_type = 'revision';");
            $statics["all_warnings"] = $statics["all_warnings"] + $statics["post_revisions"];

            $statics["trashed_contents"] = $wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts` WHERE post_status = 'trash';");
            $statics["all_warnings"] = $statics["all_warnings"] + $statics["trashed_contents"];

            $statics["trashed_spam_comments"] = $wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->comments` WHERE comment_approved = 'spam' OR comment_approved = 'trash' ;");
            $statics["all_warnings"] = $statics["all_warnings"] + $statics["trashed_spam_comments"];

            $statics["trackback_pingback"] = $wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->comments` WHERE comment_type = 'trackback' OR comment_type = 'pingback' ;");
            $statics["all_warnings"] = $statics["all_warnings"] + $statics["trackback_pingback"];

            $element = "SELECT COUNT(*) FROM `$wpdb->options` WHERE option_name LIKE '%\_transient\_%' ;";
            $statics["transient_options"] = $wpdb->get_var( $element ) > 20 ? $wpdb->get_var( $element ) : 0;
            $statics["all_warnings"] = $statics["all_warnings"] + $statics["transient_options"];

            die(json_encode($statics));
		}

		public function is_trailing_slash(){
			// no need to check if Custom Permalinks plugin is active (https://tr.wordpress.org/plugins/custom-permalinks/)
			if($this->isPluginActive("custom-permalinks/custom-permalinks.php")){
				return false;
			}

			if($permalink_structure = get_option('permalink_structure')){
				if(preg_match("/\/$/", $permalink_structure)){
					return true;
				}
			}

			return false;
		}

		public function wpfc_cache_statics_get_callback(){
			if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
				if(file_exists(WPFC_WP_PLUGIN_DIR."/wp-fastest-cache-premium/pro/library/statics.php")){
					include_once $this->get_premium_path("statics.php");
					
					$cache_statics = new WpFastestCacheStatics();
					$res = $cache_statics->get();
					echo json_encode($res);
					exit;
				}
			}
		}

		public function wpfc_check_url_ajax_request_callback(){
			if(current_user_can('manage_options')){
				if(preg_match("/wp\.com/", $_GET["url"]) || $_GET["url"] == "random"){
					wp_send_json(array("success" => true));
				}

				$host = str_replace("www.", "", $_SERVER["HTTP_HOST"]);
				$_GET["url"] = esc_url_raw($_GET["url"]);				
				
				if(!preg_match("/^http/", $_GET["url"])){
					$_GET["url"] = "http://".$_GET["url"];
				}
				
				$response = wp_remote_get($_GET["url"], array('timeout' => 20 ) );

				$header = wp_remote_retrieve_headers($response);

				if ( !$response || is_wp_error( $response ) ) {
					$res = array("success" => false, "error_message" => $response->get_error_message());
					
					if($response->get_error_code() == "http_request_failed"){
						if($response->get_error_message() == "Failure when receiving data from the peer"){
							$res = array("success" => true);
						}else if(preg_match("/cURL\serror\s6/i", $response->get_error_message())){
							//cURL error 6: Couldn't resolve host
							if(preg_match("/".preg_quote($host, "/")."/i", $_GET["url"])){
								$res = array("success" => true);
							}
						}
					}
				}else{
					$response_code = wp_remote_retrieve_response_code( $response );
					if($response_code == 200){
						$res = array("success" => true);
					}else{
						if(method_exists($response, "get_error_message")){
							$res = array("success" => false, "error_message" => $response->get_error_message());
						}else{
							$res = array("success" => false, "error_message" => wp_remote_retrieve_response_message($response));
						}

						if(isset($header["server"]) && preg_match("/squid/i", $header["server"])){
							$res = array("success" => true);
						}

						if(($response_code == 401) && (preg_match("/res\.cloudinary\.com/i", $_GET["url"]))){
							$res = array("success" => true);
						}

						if(($response_code == 403) && (preg_match("/stackpathdns\.com/i", $_GET["url"]))){
							$res = array("success" => true);
						}
					}
				}
				
				wp_send_json($res);
			}else{
				wp_die("Must be admin");
			}
		}

		public function wpfc_cdn_template_ajax_request_callback(){
			if(current_user_can('manage_options')){
				if($_POST["id"] == "maxcdn"){
					$path = WPFC_MAIN_PATH."templates/cdn/maxcdn.php";
				}else if($_POST["id"] == "other"){
					$path = WPFC_MAIN_PATH."templates/cdn/other.php";
				}else if($_POST["id"] == "photon"){
					$path = WPFC_MAIN_PATH."templates/cdn/photon.php";
				}else{
					die("Wrong cdn");
				}


				ob_start();
				include_once($path);
				$content = ob_get_contents();
				ob_end_clean();

				$res = array("success" => false, "content" => "");

				if($data = @file_get_contents($path)){
					$res["success"] = true;
					$res["content"] = $content;
				}

				echo json_encode($res);
				exit;
			}else{
				wp_die("Must be admin");
			}
		}

		public function wpfc_save_cdn_integration_ajax_request_callback(){
			if(current_user_can('manage_options')){
				if($data = get_option("WpFastestCacheCDN")){
					$cdn_exist = false;
					$arr = json_decode($data);

					if(is_array($arr)){
						foreach ($arr as $cdn_key => &$cdn_value) {
							if($cdn_value->id == $_POST["values"]["id"]){
								$cdn_value = $_POST["values"];
								$cdn_exist = true;
							}
						}

						if(!$cdn_exist){
							array_push($arr, $_POST["values"]);	
						}

						update_option("WpFastestCacheCDN", json_encode($arr));
					}else{
						$tmp_arr = array();
						
						if($arr->id == $_POST["values"]["id"]){
							array_push($tmp_arr, $_POST["values"]);
						}else{
							array_push($tmp_arr, $arr);
							array_push($tmp_arr, $_POST["values"]);
						}

						update_option("WpFastestCacheCDN", json_encode($tmp_arr));
					}
				}else{
					$arr = array();
					array_push($arr, $_POST["values"]);

					add_option("WpFastestCacheCDN", json_encode($arr), null, "yes");
				}
				echo json_encode(array("success" => true));
				exit;
			}else{
				wp_die("Must be admin");
			}
		}

		public function wpfc_remove_cdn_integration_ajax_request_callback(){
			if(current_user_can('manage_options')){
    			$cdn_values = get_option("WpFastestCacheCDN");

    			if($cdn_values){
    				$std_obj = json_decode($cdn_values);
    				$cdn_values_arr = array();

    				if(is_array($std_obj)){
						$cdn_values_arr = $std_obj;
					}else{
						array_push($cdn_values_arr, $std_obj);
					}

    				foreach ($cdn_values_arr as $cdn_key => $cdn_value) {
	    				if($cdn_value->id == "amazonaws" || $cdn_value->id == "keycdn" || $cdn_value->id == "cdn77"){
	    					$cdn_value->id = "other";
	    				}

	    				if($cdn_value->id == $_POST["id"]){
	    					unset($cdn_values_arr[$cdn_key]);
	    				}
    				}

    				$cdn_values_arr = array_values($cdn_values_arr);
    			}

    			if(count($cdn_values_arr) > 0){
    				update_option("WpFastestCacheCDN", json_encode($cdn_values_arr));
    			}else{
					delete_option("WpFastestCacheCDN");
    			}

				echo json_encode(array("success" => true));
				exit;
			}else{
				wp_die("Must be admin");
			}
		}

		public function wpfc_cdn_options_ajax_request_callback(){
			if(current_user_can('manage_options')){
				$cdn_values = get_option("WpFastestCacheCDN");
				if($cdn_values){
					echo $cdn_values;
				}else{
					echo json_encode(array("success" => false)); 
				}
				exit;
			}else{
				wp_die("Must be admin");
			}
		}

		public function wpfc_save_exclude_pages_callback(){
			if(!wp_verify_nonce($_POST["security"], 'wpfc-save-exclude-ajax-nonce')){
				die( 'Security check' );
			}
			
			if(current_user_can('manage_options')){
				if(isset($_POST["rules"])){
					foreach ($_POST["rules"] as $key => &$value) {
						$value["prefix"] = strip_tags($value["prefix"]);
						$value["content"] = strip_tags($value["content"]);

						$value["prefix"] = preg_replace("/\'|\"/", "", $value["prefix"]);
						$value["content"] = preg_replace("/\'|\"/", "", $value["content"]);

						$value["content"] = trim($value["content"], "/");

						$value["content"] = preg_replace("/(\#|\s|\(|\)|\*)/", "", $value["content"]);

						if($value["prefix"] == "homepage"){
							$this->deleteHomePageCache(false);
						}
					}

					$data = json_encode($_POST["rules"]);

					if(get_option("WpFastestCacheExclude")){
						update_option("WpFastestCacheExclude", $data);
					}else{
						add_option("WpFastestCacheExclude", $data, null, "yes");
					}
				}else{
					delete_option("WpFastestCacheExclude");
				}

				$this->modify_htaccess_for_exclude();

				echo json_encode(array("success" => true));
				exit;
			}else{
				wp_die("Must be admin");
			}
		}

		public function modify_htaccess_for_exclude(){
			$path = ABSPATH;

			if($this->is_subdirectory_install()){
				$path = $this->getABSPATH();
			}

			$htaccess = @file_get_contents($path.".htaccess");

			if(preg_match("/\#\s?Start\sWPFC\sExclude/", $htaccess)){
				$exclude_rules = $this->excludeRules();

				$htaccess = preg_replace("/\#\s?Start\sWPFC\sExclude[^\#]*\#\s?End\sWPFC\sExclude\s+/", $exclude_rules, $htaccess);
			}

			@file_put_contents($path.".htaccess", $htaccess);
		}

		public function wpfc_save_timeout_pages_callback(){
			if(!wp_verify_nonce($_POST["security"], 'wpfc-save-timeout-ajax-nonce')){
				die( 'Security check' );
			}

			if(current_user_can('manage_options')){
				$this->setCustomInterval();
			
		    	$crons = _get_cron_array();

		    	foreach ($crons as $cron_key => $cron_value) {
		    		foreach ( (array) $cron_value as $hook => $events ) {
		    			if(preg_match("/^wp\_fastest\_cache(.*)/", $hook, $id)){
		    				if(!$id[1] || preg_match("/^\_(\d+)$/", $id[1])){
		    					foreach ( (array) $events as $event_key => $event ) {
			    					if($id[1]){
			    						wp_clear_scheduled_hook("wp_fastest_cache".$id[1], $event["args"]);
			    					}else{
			    						wp_clear_scheduled_hook("wp_fastest_cache", $event["args"]);
			    					}
		    					}
		    				}
		    			}
		    		}
		    	}

				if(isset($_POST["rules"]) && count($_POST["rules"]) > 0){
					$i = 0;

					foreach ($_POST["rules"] as $key => $value) {
						if(preg_match("/^(daily|onceaday)$/i", $value["schedule"]) && isset($value["hour"]) && isset($value["minute"]) && strlen($value["hour"]) > 0 && strlen($value["minute"]) > 0){
							$args = array("prefix" => $value["prefix"], "content" => $value["content"], "hour" => $value["hour"], "minute" => $value["minute"]);

							$timestamp = mktime($value["hour"],$value["minute"],0,date("m"),date("d"),date("Y"));

							$timestamp = $timestamp > time() ? $timestamp : $timestamp + 60*60*24;
						}else{
							$args = array("prefix" => $value["prefix"], "content" => $value["content"]);
							$timestamp = time();
						}

						wp_schedule_event($timestamp, $value["schedule"], "wp_fastest_cache_".$i, array(json_encode($args)));
						$i = $i + 1;
					}
				}

				echo json_encode(array("success" => true));
				exit;
			}else{
				wp_die("Must be admin");
			}
		}

		public function wp_postratings_clear_fastest_cache($rate_userid, $post_id){
			// to remove cache if vote is from homepage or category page or tag
			if(isset($_SERVER["HTTP_REFERER"]) && $_SERVER["HTTP_REFERER"]){
				$url =  parse_url($_SERVER["HTTP_REFERER"]);

				$url["path"] = isset($url["path"]) ? $url["path"] : "/index.html";

				if(isset($url["path"])){
					if($url["path"] == "/"){
						$this->rm_folder_recursively($this->getWpContentDir()."/cache/all/index.html");
					}else{
						$this->rm_folder_recursively($this->getWpContentDir()."/cache/all".$url["path"]);
					}
				}
			}

			if($post_id){
				$this->singleDeleteCache(false, $post_id);
			}
		}

		private function admin(){			
			if(isset($_GET["page"]) && $_GET["page"] == "wpfastestcacheoptions"){
				include_once('inc/admin.php');
				$wpfc = new WpFastestCacheAdmin();
				$wpfc->addMenuPage();
			}else{
				add_action('admin_menu', array($this, 'register_my_custom_menu_page'));
			}
		}

		public function load_column(){
			if(!defined('WPFC_HIDE_CLEAR_CACHE_BUTTON') || (defined('WPFC_HIDE_CLEAR_CACHE_BUTTON') && !WPFC_HIDE_CLEAR_CACHE_BUTTON)){
				include_once plugin_dir_path(__FILE__)."inc/column.php";

				$column = new WpFastestCacheColumn();
				$column->add();
			}
		}

		public function load_admin_toolbar(){
			if(!defined('WPFC_HIDE_TOOLBAR') || (defined('WPFC_HIDE_TOOLBAR') && !WPFC_HIDE_TOOLBAR)){
				$show = false;

				// Admin
				$show = (current_user_can( 'manage_options' ) || current_user_can('edit_others_pages')) ? true : false;

				// Author
				if(defined('WPFC_TOOLBAR_FOR_AUTHOR') && WPFC_TOOLBAR_FOR_AUTHOR){
					if(current_user_can( 'delete_published_posts' ) || current_user_can('edit_published_posts')) {
						$show = true;
					}
				}
				
				if($show){
					include_once plugin_dir_path(__FILE__)."inc/admin-toolbar.php";

					$toolbar = new WpFastestCacheAdminToolbar();
					$toolbar->add();
				}

			}
		}

		public function register_my_custom_menu_page(){
			if(function_exists('add_menu_page')){ 
				add_menu_page("WP Fastest Cache Settings", "WP Fastest Cache", 'manage_options', "wpfastestcacheoptions", array($this, 'optionsPage'), plugins_url("wp-fastest-cache/images/icon-32x32.png"));
				wp_enqueue_style("wp-fastest-cache", plugins_url("wp-fastest-cache/css/style.css"), array(), time(), "all");
			}
						
			if(isset($_GET["page"]) && $_GET["page"] == "wpfastestcacheoptions"){
				wp_enqueue_style("wp-fastest-cache-buycredit", plugins_url("wp-fastest-cache/css/buycredit.css"), array(), time(), "all");
				wp_enqueue_style("wp-fastest-cache-flaticon", plugins_url("wp-fastest-cache/css/flaticon.css"), array(), time(), "all");
				wp_enqueue_style("wp-fastest-cache-dialog", plugins_url("wp-fastest-cache/css/dialog.css"), array(), time(), "all");
			}
		}

		public function deleteCacheToolbar(){
			$this->deleteCache();
		}

		public function deleteCssAndJsCacheToolbar(){
			$this->deleteCache(true);
		}

		public function delete_current_page_cache(){
			if(isset($_GET["path"])){
				if($_GET["path"]){
					if($_GET["path"] == "/"){
						$_GET["path"] = $_GET["path"]."index.html";
					}
				}else{
					$_GET["path"] = "/index.html";
				}

				$_GET["path"] = esc_url_raw($_GET["path"]);

				$paths = array();

				array_push($paths, $this->getWpContentDir()."/cache/all".$_GET["path"]);

				if(class_exists("WpFcMobileCache")){
					$wpfc_mobile = new WpFcMobileCache();
					array_push($paths, $this->getWpContentDir()."/cache/".$wpfc_mobile->get_folder_name()."".$_GET["path"]);
				}

				foreach ($paths as $key => $value){
					if(file_exists($value)){
						if(preg_match("/\/(all|wpfc-mobile-cache)\/index\.html$/i", $value)){
							@unlink($value);
						}else{
							$this->rm_folder_recursively($value);
						}
					}
				}

				die(json_encode(array("The cache of page has been cleared","success")));
			}else{
				die(json_encode(array("Path has NOT been defined", "error", "alert")));
			}

			exit;
		}

		private function cache(){
			include_once('inc/cache.php');
			$wpfc = new WpFastestCacheCreateCache();
			$wpfc->createCache();
		}

		protected function slug(){
			return "wp_fastest_cache";
		}

		protected function getWpContentDir(){
			return WPFC_WP_CONTENT_DIR;
		}

		protected function getOptions(){
			return $GLOBALS["wp_fastest_cache_options"];
		}

		protected function getSystemMessage(){
			return $this->systemMessage;
		}

		protected function get_excluded_useragent(){
			return "facebookexternalhit|WhatsApp|Mediatoolkitbot";
		}

		// protected function detectNewPost(){
		// 	if(isset($this->options->wpFastestCacheNewPost) && isset($this->options->wpFastestCacheStatus)){
		// 		add_filter ('save_post', array($this, 'deleteCache'));
		// 	}
		// }

		public function deleteWidgetCache(){
			$widget_cache_path = $this->getWpContentDir()."/cache/wpfc-widget-cache";
			
			if(is_dir($widget_cache_path)){
				if(!is_dir($this->getWpContentDir()."/cache/tmpWpfc")){
					if(@mkdir($this->getWpContentDir()."/cache/tmpWpfc", 0755, true)){
						//tmpWpfc has been created
					}
				}

				if(@rename($widget_cache_path, $this->getWpContentDir()."/cache/tmpWpfc/w".time())){
					//DONE
				}
			}
		}

		public function on_all_status_transitions($new_status, $old_status, $post) {
			if ( ! wp_is_post_revision($post->ID) ){
				if(isset($this->options->wpFastestCacheNewPost) && isset($this->options->wpFastestCacheStatus)){
					if($new_status == "publish" && $old_status != "publish"){
						if(isset($this->options->wpFastestCacheNewPost_type) && $this->options->wpFastestCacheNewPost_type){
							if($this->options->wpFastestCacheNewPost_type == "all"){
								$this->deleteCache();
							}else if($this->options->wpFastestCacheNewPost_type == "homepage"){
								$this->deleteHomePageCache();

								//to clear category cache and tag cache
								$this->singleDeleteCache(false, $post->ID);

								//to clear widget cache
								$this->deleteWidgetCache();
							}
						}else{
							$this->deleteCache();
						}
					}
				}

				if($new_status == "publish" && $old_status == "publish"){
					if(isset($this->options->wpFastestCacheUpdatePost) && isset($this->options->wpFastestCacheStatus)){

						if($this->options->wpFastestCacheUpdatePost_type == "post"){
							$this->singleDeleteCache(false, $post->ID);
						}else if($this->options->wpFastestCacheUpdatePost_type == "all"){
							$this->deleteCache();
						}
						
					}
				}

				if($new_status == "trash" && $old_status == "publish"){
					$this->singleDeleteCache(false, $post->ID);
				}else if(($new_status == "draft" || $new_status == "pending" || $new_status == "private") && $old_status == "publish"){
					$this->deleteCache();
				}
			}
		}

		protected function commentHooks(){
			//it works when the status of a comment changes
			add_filter ('wp_set_comment_status', array($this, 'singleDeleteCache'));

			//it works when a comment is saved in the database
			add_filter ('comment_post', array($this, 'detectNewComment'));
		}

		public function detectNewComment($comment_id){
			if(current_user_can( 'manage_options') || !get_option('comment_moderation')){
				$this->singleDeleteCache($comment_id);
			}
		}

		public function singleDeleteCache($comment_id = false, $post_id = false){
			$to_clear_parents = true;

			// not to clear cache of homepage/cats/tags after ajax request by other plugins
			if(isset($_POST) && isset($_POST["action"])){
				// kk Star Rating
				if($_POST["action"] == "kksr_ajax"){
					$to_clear_parents = false;
				}

				// All In One Schema.org Rich Snippets
				if(preg_match("/bsf_(update|submit)_rating/i", $_POST["action"])){
					$to_clear_parents = false;
				}

				// Yet Another Stars Rating
				if($_POST["action"] == "yasr_send_visitor_rating"){
					$to_clear_parents = false;
					$post_id = $_POST["post_id"];
				}
			}

			if($comment_id){
				$comment_id = intval($comment_id);
				
				$comment = get_comment($comment_id);
				
				if($comment && $comment->comment_post_ID){
					$post_id = $comment->comment_post_ID;
				}
			}

			if($post_id){
				$post_id = intval($post_id);

				$permalink = get_permalink($post_id);

				$permalink = urldecode(get_permalink($post_id));

				//for trash contents
				$permalink = rtrim($permalink, "/");
				$permalink = preg_replace("/__trashed$/", "", $permalink);

				if(preg_match("/https?:\/\/[^\/]+\/(.+)/", $permalink, $out)){

					//WPML language switch
					//https://wpml.org/forums/topic/wpml-language-switch-wp-fastest-cache-issue/
					if($this->isPluginActive('sitepress-multilingual-cms/sitepress.php')){
						$current_language = apply_filters('wpml_current_language', false);

						$path = $this->getWpContentDir()."/cache/all/".$current_language."/".$out[1];
						$mobile_path = $this->getWpContentDir()."/cache/wpfc-mobile-cache/".$current_language."/".$out[1];
					}else{
						$path = $this->getWpContentDir()."/cache/all/".$out[1];
						$mobile_path = $this->getWpContentDir()."/cache/wpfc-mobile-cache/".$out[1];
					}

					if(is_dir($path)){
						if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
							include_once $this->get_premium_path("logs.php");
							$log = new WpFastestCacheLogs("delete");
							$log->action();
						}

						$this->rm_folder_recursively($path);
					}

					if(is_dir($mobile_path)){
						$this->rm_folder_recursively($mobile_path);
					}
				}

				if($to_clear_parents){
					// to clear cache of homepage
					$this->deleteHomePageCache();

					// to clear cache of cats and  tags which contains the post (only first page)
					global $wpdb;
					$terms = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."term_relationships` WHERE `object_id`=".$post_id, ARRAY_A);

					foreach ($terms as $term_key => $term_val){
						$this->delete_cache_of_term($term_val["term_taxonomy_id"]);
					}
				}
			}
		}

		public function delete_cache_of_term($term_id){
			$term = get_term($term_id);

			if(!$term || is_wp_error($term)){
				return false;
			}

			if(preg_match("/cat|tag/", $term->taxonomy)){
				$url = get_term_link($term->term_id, $term->taxonomy);

				if(preg_match("/^http/", $url)){
					$path = preg_replace("/https?\:\/\/[^\/]+/i", "", $url);
					$path = trim($path, "/");

					// to remove the cache of tag/cat
					@unlink($this->getWpContentDir()."/cache/all/".$path."/index.html");
					@unlink($this->getWpContentDir()."/cache/wpfc-mobile-cache/".$path."/index.html");

					// to remove the cache of the pages
					$this->rm_folder_recursively($this->getWpContentDir()."/cache/all/".$path."/page");
					$this->rm_folder_recursively($this->getWpContentDir()."/cache/wpfc-mobile-cache/".$path."/page");
				}
			}
		}

		public function deleteHomePageCache($log = true){
			$site_url_path = preg_replace("/https?\:\/\/[^\/]+/i", "", site_url());
			$home_url_path = preg_replace("/https?\:\/\/[^\/]+/i", "", home_url());

			if($site_url_path){
				$site_url_path = trim($site_url_path, "/");

				if($site_url_path){
					@unlink($this->getWpContentDir()."/cache/all/".$site_url_path."/index.html");
					@unlink($this->getWpContentDir()."/cache/wpfc-mobile-cache/".$site_url_path."/index.html");
				}
			}

			if($home_url_path){
				$home_url_path = trim($home_url_path, "/");

				if($home_url_path){
					@unlink($this->getWpContentDir()."/cache/all/".$home_url_path."/index.html");
					@unlink($this->getWpContentDir()."/cache/wpfc-mobile-cache/".$home_url_path."/index.html");
				}
			}

			@unlink($this->getWpContentDir()."/cache/all/index.html");
			@unlink($this->getWpContentDir()."/cache/wpfc-mobile-cache/index.html");

			if($log){
				if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
					include_once $this->get_premium_path("logs.php");

					$log = new WpFastestCacheLogs("delete");
					$log->action();
				}
			}
		}

		public function deleteCache($minified = false){
			$this->set_preload();

			$created_tmpWpfc = false;
			$cache_deleted = false;
			$minifed_deleted = false;

			$cache_path = $this->getWpContentDir()."/cache/all";
			$minified_cache_path = $this->getWpContentDir()."/cache/wpfc-minified";

			if(class_exists("WpFcMobileCache")){
				$wpfc_mobile = new WpFcMobileCache();
				$wpfc_mobile->delete_cache($this->getWpContentDir());
			}
			
			if(!is_dir($this->getWpContentDir()."/cache/tmpWpfc")){
				if(@mkdir($this->getWpContentDir()."/cache/tmpWpfc", 0755, true)){
					$created_tmpWpfc = true;
				}else{
					$created_tmpWpfc = false;
					//$this->systemMessage = array("Permission of <strong>/wp-content/cache</strong> must be <strong>755</strong>", "error");
				}
			}else{
				$created_tmpWpfc = true;
			}

			//to clear widget cache path
			$this->deleteWidgetCache();

			if(is_dir($cache_path)){
				if(@rename($cache_path, $this->getWpContentDir()."/cache/tmpWpfc/".time())){
					delete_option("WpFastestCacheHTML");
					delete_option("WpFastestCacheHTMLSIZE");
					delete_option("WpFastestCacheMOBILE");
					delete_option("WpFastestCacheMOBILESIZE");

					$cache_deleted = true;
				}
			}else{
				$cache_deleted = true;
			}

			if($minified){
				if(is_dir($minified_cache_path)){
					if(@rename($minified_cache_path, $this->getWpContentDir()."/cache/tmpWpfc/m".time())){
						delete_option("WpFastestCacheCSS");
						delete_option("WpFastestCacheCSSSIZE");
						delete_option("WpFastestCacheJS");
						delete_option("WpFastestCacheJSSIZE");

						$minifed_deleted = true;
					}
				}else{
					$minifed_deleted = true;
				}
			}else{
				$minifed_deleted = true;
			}

			if($created_tmpWpfc && $cache_deleted && $minifed_deleted){
				$this->systemMessage = array("All cache files have been deleted","success");

				if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
					include_once $this->get_premium_path("logs.php");

					$log = new WpFastestCacheLogs("delete");
					$log->action();
				}
			}else{
				$this->systemMessage = array("Permissions Problem: <a href='http://www.wpfastestcache.com/warnings/delete-cache-problem-related-to-permission/' target='_blank'>Read More</a>", "error", array("light_box" => "delete_cache_permission_error"));
			}

			// for ajax request
			if(isset($_GET["action"]) && in_array($_GET["action"], array("wpfc_delete_cache", "wpfc_delete_cache_and_minified"))){
				die(json_encode($this->systemMessage));
			}
		}

		public function checkCronTime(){
			$crons = _get_cron_array();

	    	foreach ((array)$crons as $cron_key => $cron_value) {
	    		foreach ( (array) $cron_value as $hook => $events ) {
	    			if(preg_match("/^wp\_fastest\_cache(.*)/", $hook, $id)){
	    				if(!$id[1] || preg_match("/^\_(\d+)$/", $id[1])){
		    				foreach ( (array) $events as $event_key => $event ) {
		    					add_action("wp_fastest_cache".$id[1],  array($this, 'setSchedule'));
		    				}
		    			}
		    		}
		    	}
		    }

		    add_action($this->slug()."_Preload",  array($this, 'create_preload_cache'), 11);
		}

		public function set_preload(){
			$preload_arr = array();

			if(!empty($_POST) && isset($_POST["wpFastestCachePreload"])){
				foreach ($_POST as $key => $value) {
					$key = esc_attr($key);
					$value = esc_attr($value);
					
					preg_match("/wpFastestCachePreload_(.+)/", $key, $type);

					if(!empty($type)){
						if($type[1] == "restart"){
							//to need to remove "restart" value
						}else if($type[1] == "number"){
							$preload_arr[$type[1]] = $value; 
						}else{
							$preload_arr[$type[1]] = 0; 
						}
					}
				}
			}

			if($data = get_option("WpFastestCachePreLoad")){
				$preload_std = json_decode($data);

				if(!empty($preload_arr)){
					foreach ($preload_arr as $key => &$value) {
						if(!empty($preload_std->$key)){
							if($key != "number"){
								$value = $preload_std->$key;
							}
						}
					}

					$preload_std = $preload_arr;
				}else{
					foreach ($preload_std as $key => &$value) {
						if($key != "number"){
							$value = 0;
						}
					}
				}

				update_option("WpFastestCachePreLoad", json_encode($preload_std));

				if(!wp_next_scheduled($this->slug()."_Preload")){
					wp_schedule_event(time() + 5, 'everyfiveminute', $this->slug()."_Preload");
				}
			}else{
				if(!empty($preload_arr)){
					add_option("WpFastestCachePreLoad", json_encode($preload_arr), null, "yes");

					if(!wp_next_scheduled($this->slug()."_Preload")){
						wp_schedule_event(time() + 5, 'everyfiveminute', $this->slug()."_Preload");
					}
				}else{
					//toDO
				}
			}
		}

		public function create_preload_cache(){
			if($data = get_option("WpFastestCachePreLoad")){
				$count_posts = wp_count_posts("post");
				$count_pages = wp_count_posts('page');

				$this->options = $this->getOptions();

				$pre_load = json_decode($data);
				$number = $pre_load->number;
				
				$urls_limit = isset($this->options->wpFastestCachePreload_number) ? $this->options->wpFastestCachePreload_number : 4; // must be even
				$urls = array();

				if(isset($this->options->wpFastestCacheMobileTheme) && $this->options->wpFastestCacheMobileTheme){
					$mobile_theme = true;
					$number = $number/2;
				}else{
					$mobile_theme = false;
				}
				

				// HOME
				if(isset($pre_load->homepage) && $pre_load->homepage > -1){
					if($mobile_theme){
						array_push($urls, array("url" => get_option("home"), "user-agent" => "mobile"));
						$number--;
					}

					array_push($urls, array("url" => get_option("home"), "user-agent" => "desktop"));
					$number--;
					
					$pre_load->homepage = -1;
				}

				// POST
				if($number > 0 && isset($pre_load->post) && $pre_load->post > -1){
		    		// $recent_posts = wp_get_recent_posts(array(
								// 			'numberposts' => $number,
								// 		    'offset' => $pre_load->post,
								// 		    'orderby' => 'ID',
								// 		    'order' => 'DESC',
								// 		    'post_type' => 'post',
								// 		    'post_status' => 'publish',
								// 		    'suppress_filters' => true
								// 		    ), ARRAY_A);
		    		global $wpdb;
		    		$recent_posts = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS  ".$wpdb->prefix."posts.ID FROM ".$wpdb->prefix."posts  WHERE 1=1  AND (".$wpdb->prefix."posts.post_type = 'post' OR ".$wpdb->prefix."posts.post_type = 'product') AND ((".$wpdb->prefix."posts.post_status = 'publish'))  ORDER BY ".$wpdb->prefix."posts.ID DESC LIMIT ".$pre_load->post.", ".$number, ARRAY_A);


		    		if(count($recent_posts) > 0){
		    			foreach ($recent_posts as $key => $post) {
		    				if($mobile_theme){
		    					array_push($urls, array("url" => get_permalink($post["ID"]), "user-agent" => "mobile"));
		    					$number--;
		    				}

	    					array_push($urls, array("url" => get_permalink($post["ID"]), "user-agent" => "desktop"));
	    					$number--;

		    				$pre_load->post = $pre_load->post + 1;
		    			}
		    		}else{
		    			$pre_load->post = -1;
		    		}
				}

				// ATTACHMENT
				if($number > 0 && isset($pre_load->attachment) && $pre_load->attachment > -1){
					global $wpdb;
		    		$recent_attachments = $wpdb->get_results("SELECT SQL_CALC_FOUND_ROWS  ".$wpdb->prefix."posts.ID FROM ".$wpdb->prefix."posts  WHERE 1=1  AND (".$wpdb->prefix."posts.post_type = 'attachment') ORDER BY ".$wpdb->prefix."posts.ID DESC LIMIT ".$pre_load->attachment.", ".$number, ARRAY_A);

		    		if(count($recent_attachments) > 0){
		    			foreach ($recent_attachments as $key => $attachment) {
		    				if($mobile_theme){
		    					array_push($urls, array("url" => get_permalink($attachment["ID"]), "user-agent" => "mobile"));
		    					$number--;
		    				}

	    					array_push($urls, array("url" => get_permalink($attachment["ID"]), "user-agent" => "desktop"));
	    					$number--;

		    				$pre_load->attachment = $pre_load->attachment + 1;
		    			}
		    		}else{
		    			$pre_load->attachment = -1;
		    		}
				}

				// PAGE
				if($number > 0 && isset($pre_load->page) && $pre_load->page > -1){
					$pages = get_pages(array(
							'sort_order' => 'DESC',
							'sort_column' => 'ID',
							'parent' => -1,
							'hierarchical' => 0,
							'number' => $number,
							'offset' => $pre_load->page,
							'post_type' => 'page',
							'post_status' => 'publish'
					));

					if(count($pages) > 0){
						foreach ($pages as $key => $page) {
							$page_url = get_option("home")."/".get_page_uri($page->ID);

		    				if($mobile_theme){
		    					array_push($urls, array("url" => $page_url, "user-agent" => "mobile"));
		    					$number--;
		    				}

	    					array_push($urls, array("url" => $page_url, "user-agent" => "desktop"));
	    					$number--;

		    				$pre_load->page = $pre_load->page + 1;
						}
					}else{
						$pre_load->page = -1;
					}
				}

				// CATEGORY
				if($number > 0 && isset($pre_load->category) && $pre_load->category > -1){
					// $categories = get_terms(array(
					// 							'taxonomy'          => array('category', 'product_cat'),
					// 						    'orderby'           => 'id', 
					// 						    'order'             => 'DESC',
					// 						    'hide_empty'        => false, 
					// 						    'number'            => $number, 
					// 						    'fields'            => 'all', 
					// 						    'pad_counts'        => false, 
					// 						    'offset'            => $pre_load->category
					// 						));

					global $wpdb;
		    		$categories = $wpdb->get_results("SELECT  t.*, tt.* FROM ".$wpdb->prefix."terms AS t  INNER JOIN ".$wpdb->prefix."term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ('category', 'product_cat', 'hersteller', 'anschlussart', 'typ') ORDER BY t.term_id ASC LIMIT ".$pre_load->category.", ".$number, ARRAY_A);

					if(count($categories) > 0){
						foreach ($categories as $key => $category) {
							if($mobile_theme){
								array_push($urls, array("url" => get_term_link($category["slug"], $category["taxonomy"]), "user-agent" => "mobile"));
								$number--;
							}

							array_push($urls, array("url" => get_term_link($category["slug"], $category["taxonomy"]), "user-agent" => "desktop"));
							$number--;

							$pre_load->category = $pre_load->category + 1;

						}
					}else{
						$pre_load->category = -1;
					}
				}

				// TAG
				if($number > 0 && isset($pre_load->tag) && $pre_load->tag > -1){
					// $tags = get_terms(array(
					// 							'taxonomy'          => array('post_tag', 'product_tag'),
					// 						    'orderby'           => 'id', 
					// 						    'order'             => 'DESC',
					// 						    'hide_empty'        => false, 
					// 						    'number'            => $number, 
					// 						    'fields'            => 'all', 
					// 						    'pad_counts'        => false, 
					// 						    'offset'            => $pre_load->tag
					// 						));

					global $wpdb;
		    		$tags = $wpdb->get_results("SELECT  t.*, tt.* FROM ".$wpdb->prefix."terms AS t  INNER JOIN ".$wpdb->prefix."term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ('post_tag', 'product_tag') ORDER BY t.term_id ASC LIMIT ".$pre_load->tag.", ".$number, ARRAY_A);


					if(count($tags) > 0){
						foreach ($tags as $key => $tag) {
							if($mobile_theme){
								array_push($urls, array("url" => get_term_link($tag["slug"], $tag["taxonomy"]), "user-agent" => "mobile"));
								$number--;
							}

							array_push($urls, array("url" => get_term_link($tag["slug"], $tag["taxonomy"]), "user-agent" => "desktop"));
							$number--;

							$pre_load->tag = $pre_load->tag + 1;

						}
					}else{
						$pre_load->tag = -1;
					}
				}






				if(count($urls) > 0){
					foreach ($urls as $key => $arr) {
						$user_agent = "";

						if($arr["user-agent"] == "desktop"){
							$user_agent = "WP Fastest Cache Preload Bot";
						}else if($arr["user-agent"] == "mobile"){
							$user_agent = "WP Fastest Cache Preload iPhone Mobile Bot";
						}

						if($this->wpfc_remote_get($arr["url"], $user_agent)){
							$status = "<strong style=\"color:lightgreen;\">OK</strong>";
						}else{
							$status = "<strong style=\"color:red;\">ERROR</strong>";
						}

						echo $status." ".$arr["url"]." (".$arr["user-agent"].")<br>";
					}
					echo "<br>";
					echo count($urls)." page have been cached";

		    		update_option("WpFastestCachePreLoad", json_encode($pre_load));

		    		echo "<br><br>";

		    		// if(isset($pre_load->homepage)){
		    		// 	if($pre_load->homepage == -1){
		    		// 		echo "Homepage: 1/1"."<br>";
		    		// 	}
		    		// }

		    		// if(isset($pre_load->post)){
			    	// 	if($pre_load->post > -1){
			    	// 		echo "Posts: ".$pre_load->post."/".$count_posts->publish."<br>";
			    	// 	}else{
			    	// 		echo "Posts: ".$count_posts->publish."/".$count_posts->publish."<br>";
			    	// 	} 
		    		// }

		    		// if(isset($pre_load->page)){
		    		// 	if($pre_load->page > -1){
		    		// 		echo "Pages: ".$pre_load->page."/".$count_pages->publish."<br>";
		    		// 	}else{
		    		// 		echo "Pages: ".$count_pages->publish."/".$count_pages->publish."<br>";
		    		// 	}
		    		// }
				}else{
					if(isset($this->options->wpFastestCachePreload_restart)){
						foreach ($pre_load as $pre_load_key => &$pre_load_value) {
							if($pre_load_key != "number"){
								$pre_load_value = 0;
							}
						}

						update_option("WpFastestCachePreLoad", json_encode($pre_load));

						echo "Preload Restarted";
					}else{
						echo "Completed";
						
						wp_clear_scheduled_hook("wp_fastest_cache_Preload");
					}
				}
			}

			if(isset($_GET) && isset($_GET["type"])  && $_GET["type"] == "preload"){
				die();
			}
		}

		public function wpfc_remote_get($url, $user_agent){
			//$response = wp_remote_get($url, array('timeout' => 10, 'sslverify' => false, 'headers' => array("cache-control" => array("no-store, no-cache, must-revalidate", "post-check=0, pre-check=0"),'user-agent' => $user_agent)));
			$response = wp_remote_get($url, array('user-agent' => $user_agent, 'timeout' => 10, 'sslverify' => false, 'headers' => array("cache-control" => "no-store, no-cache, must-revalidate, post-check=0, pre-check=0")));

			if (!$response || is_wp_error($response)){
				echo $response->get_error_message()." - ";

				return false;
			}else{
				if(wp_remote_retrieve_response_code($response) != 200){
					return false;
				}
			}

			return true;
		}

		public function setSchedule($args = ""){
			if($args){
				$rule = json_decode($args);

				if($rule->prefix == "all"){
					$this->deleteCache();
				}else if($rule->prefix == "homepage"){
					@unlink($this->getWpContentDir()."/cache/all/index.html");
					@unlink($this->getWpContentDir()."/cache/wpfc-mobile-cache/index.html");

					if(isset($this->options->wpFastestCachePreload_homepage) && $this->options->wpFastestCachePreload_homepage){
						$this->wpfc_remote_get(get_option("home"), "WP Fastest Cache Preload Bot - After Cache Timeout");
						$this->wpfc_remote_get(get_option("home"), "WP Fastest Cache Preload iPhone Mobile Bot - After Cache Timeout");
					}
				}else if($rule->prefix == "startwith"){
						if(!is_dir($this->getWpContentDir()."/cache/tmpWpfc")){
							if(@mkdir($this->getWpContentDir()."/cache/tmpWpfc", 0755, true)){}
						}

						$rule->content = trim($rule->content, "/");

						$files = glob($this->getWpContentDir()."/cache/all/".$rule->content."*");

						foreach ((array)$files as $file) {
							$mobile_file = str_replace("/cache/all/", "/cache/wpfc-mobile-cache/", $file);
							
							@rename($file, $this->getWpContentDir()."/cache/tmpWpfc/".time());
							@rename($mobile_file, $this->getWpContentDir()."/cache/tmpWpfc/mobile_".time());
						}
				}else if($rule->prefix == "exact"){
					$rule->content = trim($rule->content, "/");

					@unlink($this->getWpContentDir()."/cache/all/".$rule->content."/index.html");
					@unlink($this->getWpContentDir()."/cache/wpfc-mobile-cache/".$rule->content."/index.html");
				}

				if($rule->prefix != "all"){
					if($this->isPluginActive("wp-fastest-cache-premium/wpFastestCachePremium.php")){
						include_once $this->get_premium_path("logs.php");
						$log = new WpFastestCacheLogs("delete");
						$log->action($rule);
					}
				}
			}else{
				//for old cron job
				$this->deleteCache();
			}
		}

		public function modify_htaccess_for_new_user($user_id){
			$path = ABSPATH;

			if($this->is_subdirectory_install()){
				$path = $this->getABSPATH();
			}

			$htaccess = @file_get_contents($path.".htaccess");

			if(preg_match("/\#\s?Start_WPFC_Exclude_Admin_Cookie/", $htaccess)){
				$rules = $this->excludeAdminCookie();

				$htaccess = preg_replace("/\#\s?Start_WPFC_Exclude_Admin_Cookie[^\#]*\#\s?End_WPFC_Exclude_Admin_Cookie\s+/", $rules, $htaccess);
			}

			@file_put_contents($path.".htaccess", $htaccess);
		}

		public function excludeAdminCookie(){
			$rules = "";
			$users_groups = array_chunk(get_users(array("role" => "administrator", "fields" => array("user_login"))), 5);

			foreach ($users_groups as $group_key => $group) {
				$tmp_users = "";
				$tmp_rule = "";

				foreach ($group as $key => $value) {
					if($tmp_users){
						$tmp_users = $tmp_users."|".sanitize_user(wp_unslash($value->user_login), true);
					}else{
						$tmp_users = sanitize_user(wp_unslash($value->user_login), true);
					}

					// to replace spaces with \s
					$tmp_users = preg_replace("/\s/", "\s", $tmp_users);

					if(!next($group)){
						$tmp_rule = "RewriteCond %{HTTP:Cookie} !wordpress_logged_in_[^\=]+\=".$tmp_users;
					}
				}

				if($rules){
					$rules = $rules."\n".$tmp_rule;
				}else{
					$rules = $tmp_rule;
				}
			}

			return "# Start_WPFC_Exclude_Admin_Cookie\n".$rules."\n# End_WPFC_Exclude_Admin_Cookie\n";
		}

		public function excludeRules(){
			$htaccess_page_rules = "";
			$htaccess_page_useragent = "";
			$htaccess_page_cookie = "";

			if($rules_json = get_option("WpFastestCacheExclude")){
				if($rules_json != "null"){
					$rules_std = json_decode($rules_json);

					foreach ($rules_std as $key => $value) {
						$value->type = isset($value->type) ? $value->type : "page";

						// escape the chars
						$value->content = str_replace("?", "\?", $value->content);

						if($value->type == "page"){
							if($value->prefix == "startwith"){
								$htaccess_page_rules = $htaccess_page_rules."RewriteCond %{REQUEST_URI} !^/".$value->content." [NC]\n";
							}

							if($value->prefix == "contain"){
								$htaccess_page_rules = $htaccess_page_rules."RewriteCond %{REQUEST_URI} !".$value->content." [NC]\n";
							}

							if($value->prefix == "exact"){
								$htaccess_page_rules = $htaccess_page_rules."RewriteCond %{REQUEST_URI} !\/".$value->content." [NC]\n";
							}
						}else if($value->type == "useragent"){
							$htaccess_page_useragent = $htaccess_page_useragent."RewriteCond %{HTTP_USER_AGENT} !".$value->content." [NC]\n";
						}else if($value->type == "cookie"){
							$htaccess_page_cookie = $htaccess_page_cookie."RewriteCond %{HTTP:Cookie} !".$value->content." [NC]\n";
						}
					}
				}
			}

			return "# Start WPFC Exclude\n".$htaccess_page_rules.$htaccess_page_useragent.$htaccess_page_cookie."# End WPFC Exclude\n";
		}

		public function getABSPATH(){
			$path = ABSPATH;
			$siteUrl = site_url();
			$homeUrl = home_url();
			$diff = str_replace($homeUrl, "", $siteUrl);
			$diff = trim($diff,"/");

		    $pos = strrpos($path, $diff);

		    if($pos !== false){
		    	$path = substr_replace($path, "", $pos, strlen($diff));
		    	$path = trim($path,"/");
		    	$path = "/".$path."/";
		    }
		    return $path;
		}

		public function rm_folder_recursively($dir, $i = 1) {
			$files = @scandir($dir);
		    foreach((array)$files as $file) {
		    	if($i > 50 && !preg_match("/wp-fastest-cache-premium/i", $dir)){
		    		return true;
		    	}else{
		    		$i++;
		    	}
		        if ('.' === $file || '..' === $file) continue;
		        if (is_dir("$dir/$file")){
		        	$this->rm_folder_recursively("$dir/$file", $i);
		        }else{
		        	if(file_exists("$dir/$file")){
		        		@unlink("$dir/$file");
		        	}
		        }
		    }
		    
		    $files_tmp = @scandir($dir);
		    
		    if(is_dir($dir) && !isset($files_tmp[2])){
		    	@rmdir($dir);
		    }

		    return true;
		}

		public function is_subdirectory_install(){
			if(strlen(site_url()) > strlen(home_url())){
				return true;
			}
			return false;
		}

		protected function getMobileUserAgents(){
			return implode("|", $this->get_mobile_browsers())."|".implode("|", $this->get_operating_systems());
		}

		public function get_premium_path($name){
			return WPFC_WP_PLUGIN_DIR."/wp-fastest-cache-premium/pro/library/".$name;
		}

		public function cron_add_minute( $schedules ) {
			$schedules['everyminute'] = array(
			    'interval' => 60*1,
			    'display' => __( 'Once Every 1 Minute' ),
			    'wpfc' => false
		    );

			$schedules['everyfiveminute'] = array(
			    'interval' => 60*5,
			    'display' => __( 'Once Every 5 Minutes' ),
			    'wpfc' => false
		    );

		   	$schedules['everyfifteenminute'] = array(
			    'interval' => 60*15,
			    'display' => __( 'Once Every 15 Minutes' ),
			    'wpfc' => true
		    );

		    $schedules['twiceanhour'] = array(
			    'interval' => 60*30,
			    'display' => __( 'Twice an Hour' ),
			    'wpfc' => true
		    );

		    $schedules['onceanhour'] = array(
			    'interval' => 60*60,
			    'display' => __( 'Once an Hour' ),
			    'wpfc' => true
		    );

		    $schedules['everytwohours'] = array(
			    'interval' => 60*60*2,
			    'display' => __( 'Once Every 2 Hours' ),
			    'wpfc' => true
		    );

		    $schedules['everythreehours'] = array(
			    'interval' => 60*60*3,
			    'display' => __( 'Once Every 3 Hours' ),
			    'wpfc' => true
		    );

		    $schedules['everyfourhours'] = array(
			    'interval' => 60*60*4,
			    'display' => __( 'Once Every 4 Hours' ),
			    'wpfc' => true
		    );

		    $schedules['everyfivehours'] = array(
			    'interval' => 60*60*5,
			    'display' => __( 'Once Every 5 Hours' ),
			    'wpfc' => true
		    );

		    $schedules['everysixhours'] = array(
			    'interval' => 60*60*6,
			    'display' => __( 'Once Every 6 Hours' ),
			    'wpfc' => true
		    );

		    $schedules['everysevenhours'] = array(
			    'interval' => 60*60*7,
			    'display' => __( 'Once Every 7 Hours' ),
			    'wpfc' => true
		    );

		    $schedules['everyeighthours'] = array(
			    'interval' => 60*60*8,
			    'display' => __( 'Once Every 8 Hours' ),
			    'wpfc' => true
		    );

		    $schedules['everyninehours'] = array(
			    'interval' => 60*60*9,
			    'display' => __( 'Once Every 9 Hours' ),
			    'wpfc' => true
		    );

		    $schedules['everytenhours'] = array(
			    'interval' => 60*60*10,
			    'display' => __( 'Once Every 10 Hours' ),
			    'wpfc' => true
		    );

		    $schedules['onceaday'] = array(
			    'interval' => 60*60*24,
			    'display' => __( 'Once a Day' ),
			    'wpfc' => true
		    );

		    $schedules['everythreedays'] = array(
			    'interval' => 60*60*24*3,
			    'display' => __( 'Once Every 3 Days' ),
			    'wpfc' => true
		    );

		    $schedules['weekly'] = array(
			    'interval' => 60*60*24*7,
			    'display' => __( 'Once a Week' ),
			    'wpfc' => true
		    );

		    $schedules['everytendays'] = array(
			    'interval' => 60*60*24*10,
			    'display' => __( 'Once Every 10 Days' ),
			    'wpfc' => true
		    );

		    $schedules['montly'] = array(
			    'interval' => 60*60*24*30,
			    'display' => __( 'Once a Month' ),
			    'wpfc' => true
		    );

		    $schedules['yearly'] = array(
			    'interval' => 60*60*24*30*12,
			    'display' => __( 'Once a Year' ),
			    'wpfc' => true
		    );

		    return $schedules;
		}

		public function setCustomInterval(){
			add_filter( 'cron_schedules', array($this, 'cron_add_minute'));
		}

		public function isPluginActive( $plugin ) {
			return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || $this->isPluginActiveForNetwork( $plugin );
		}
		
		public function isPluginActiveForNetwork( $plugin ) {
			if ( !is_multisite() )
				return false;

			$plugins = get_site_option( 'active_sitewide_plugins');
			if ( isset($plugins[$plugin]) )
				return true;

			return false;
		}

		public function current_url(){
			if(defined('WP_CLI')){
				$_SERVER["SERVER_NAME"] = isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : "";
				$_SERVER["SERVER_PORT"] = isset($_SERVER["SERVER_PORT"]) ? $_SERVER["SERVER_PORT"] : 80;
			}
			
		    $pageURL = 'http';
		 
		    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
		        $pageURL .= 's';
		    }
		 
		    $pageURL .= '://';
		 
		    if($_SERVER['SERVER_PORT'] != '80'){
		        $pageURL .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
		    }else{
		        $pageURL .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		    }
		 
		    return $pageURL;
		}

		public function wpfc_load_plugin_textdomain(){
			load_plugin_textdomain('wp-fastest-cache', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
		}

		public function cdn_replace_urls($matches){
			if(count($this->cdn) > 0){
				foreach ($this->cdn as $key => $cdn) {
					if(preg_match("/manifest\.json\.php/i", $matches[0])){
						return $matches[0];
					}

					if(preg_match("/^\/\/random/", $cdn->cdnurl) || preg_match("/\/\/i\d\.wp\.com/", $cdn->cdnurl)){
						if(preg_match("/^\/\/random/", $cdn->cdnurl)){
							$cdnurl = "//i".rand(0,3).".wp.com/".str_replace("www.", "", $_SERVER["HTTP_HOST"]);
							$cdnurl = preg_replace("/\/\/i\d\.wp\.com/", "//i".rand(0,3).".wp.com", $cdnurl);
						}else{
							$cdnurl = $cdn->cdnurl;
						}

						//to add www. if exists
						if(preg_match("/\/\/www\./", $matches[0])){
							$cdnurl = preg_replace("/(\/\/i\d\.wp\.com\/)(www\.)?/", "$1www.", $cdnurl);
						}
					}else{
						$cdnurl = $cdn->cdnurl;
					}

					$cdn->file_types = str_replace(",", "|", $cdn->file_types);

					if(!preg_match("/\.(".$cdn->file_types.")/i", $matches[0])){
						continue;
					}

					if($cdn->keywords){
						$cdn->keywords = str_replace(",", "|", $cdn->keywords);

						if(!preg_match("/".preg_quote($cdn->keywords, "/")."/i", $matches[0])){
							continue;
						}
					}

					if(preg_match("/\{\"concatemoji\"\:\"[^\"]+\"\}/i", $matches[0])){
						$matches[0] = preg_replace("/(http(s?)\:)?".preg_quote("\/\/", "/")."(www\.)?/i", "", $matches[0]);
						$matches[0] = preg_replace("/".preg_quote($cdn->originurl, "/")."/i", $cdnurl, $matches[0]);
					}else if(isset($matches[2]) && preg_match("/".preg_quote($cdn->originurl, "/")."/", $matches[2])){
						$matches[0] = preg_replace("/(http(s?)\:)?\/\/(www\.)?".preg_quote($cdn->originurl, "/")."/i", $cdnurl, $matches[0]);
					}else if(isset($matches[2]) && preg_match("/^(\/?)(wp-includes|wp-content)/", $matches[2])){
						$matches[0] = preg_replace("/(\/?)(wp-includes|wp-content)/i", $cdnurl."/"."$2", $matches[0]);
					}else if(preg_match("/[\"\']https?\:\\\\\/\\\\\/[^\"\']+[\"\']/i", $matches[0])){
						if(preg_match("/^(logo|url|image)$/i", $matches[1])){
							//If the url is called with "//", it causes an error on https://search.google.com/structured-data/testing-tool/u/0/
							//<script type="application/ld+json">"logo":{"@type":"ImageObject","url":"\/\/cdn.site.com\/image.png"}</script>
							//<script type="application/ld+json">{"logo":"\/\/cdn.site.com\/image.png"}</script>
							//<script type="application/ld+json">{"image":"\/\/cdn.site.com\/image.jpg"}</script>
						}else{
							//<script>var loaderRandomImages=["https:\/\/www.site.com\/wp-content\/uploads\/2016\/12\/image.jpg"];</script>
							$matches[0] = preg_replace("/\\\\\//", "/", $matches[0]);
							
							if(preg_match("/".preg_quote($cdn->originurl, "/")."/", $matches[0])){
								$matches[0] = preg_replace("/(http(s?)\:)?\/\/(www\.)?".preg_quote($cdn->originurl, "/")."/i", $cdnurl, $matches[0]);
								$matches[0] = preg_replace("/\//", "\/", $matches[0]);
							}
						}
					}
				}
			}

			return $matches[0];
		}

		public function read_file($url){
			if(!preg_match("/\.php/", $url)){
				$url = preg_replace("/\?.*/", "", $url);
				$path = preg_replace("/.+\/wp-content\/(.+)/", WPFC_WP_CONTENT_DIR."/"."$1", $url);

				if(file_exists($path)){
					$filesize = filesize($path);

					if($filesize > 0){
						$myfile = fopen($path, "r") or die("Unable to open file!");
						$data = fread($myfile, $filesize);
						fclose($myfile);

						return $data;
					}else{
						return false;
					}
				}
			}

			return false;
		}

		public function get_operating_systems(){
			$operating_systems  = array(
									'Android',
									'blackberry|\bBB10\b|rim\stablet\sos',
									'PalmOS|avantgo|blazer|elaine|hiptop|palm|plucker|xiino',
									'Symbian|SymbOS|Series60|Series40|SYB-[0-9]+|\bS60\b',
									'Windows\sCE.*(PPC|Smartphone|Mobile|[0-9]{3}x[0-9]{3})|Window\sMobile|Windows\sPhone\s[0-9.]+|WCE;',
									'Windows\sPhone\s10.0|Windows\sPhone\s8.1|Windows\sPhone\s8.0|Windows\sPhone\sOS|XBLWP7|ZuneWP7|Windows\sNT\s6\.[23]\;\sARM\;',
									'\biPhone.*Mobile|\biPod|\biPad',
									'Apple-iPhone7C2',
									'MeeGo',
									'Maemo',
									'J2ME\/|\bMIDP\b|\bCLDC\b', // '|Java/' produces bug #135
									'webOS|hpwOS',
									'\bBada\b',
									'BREW'
							    );
			return $operating_systems;
		}

		public function get_mobile_browsers(){
			$mobile_browsers  = array(
								'\bCrMo\b|CriOS|Android.*Chrome\/[.0-9]*\s(Mobile)?',
								'\bDolfin\b',
								'Opera.*Mini|Opera.*Mobi|Android.*Opera|Mobile.*OPR\/[0-9.]+|Coast\/[0-9.]+',
								'Skyfire',
								'Mobile\sSafari\/[.0-9]*\sEdge',
								'IEMobile|MSIEMobile', // |Trident/[.0-9]+
								'fennec|firefox.*maemo|(Mobile|Tablet).*Firefox|Firefox.*Mobile|FxiOS',
								'bolt',
								'teashark',
								'Blazer',
								'Version.*Mobile.*Safari|Safari.*Mobile|MobileSafari',
								'Tizen',
								'UC.*Browser|UCWEB',
								'baiduboxapp',
								'baidubrowser',
								'DiigoBrowser',
								'Puffin',
								'\bMercury\b',
								'Obigo',
								'NF-Browser',
								'NokiaBrowser|OviBrowser|OneBrowser|TwonkyBeamBrowser|SEMC.*Browser|FlyFlow|Minimo|NetFront|Novarra-Vision|MQQBrowser|MicroMessenger',
								'Android.*PaleMoon|Mobile.*PaleMoon'
							    );
			return $mobile_browsers;
		}


	}

	$GLOBALS["wp_fastest_cache"] = new WpFastestCache();
?>