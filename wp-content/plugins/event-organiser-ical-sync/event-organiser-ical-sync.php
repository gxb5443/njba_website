<?php
/*
Plugin Name: Event Organiser ICAL Sync
Plugin URI: http://www.wp-event-organiser.com
Version: 2.0.1
Description: Automatically import ICAL feeds from other sites / Google
Author: Stephen Harris
Author URI: http://www.stephenharris.info
*/
/*  Copyright 2013 Stephen Harris (contact@stephenharris.info)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

//Initiates the plug-in
add_action( 'plugins_loaded', array( 'EO_Sync_Ical', 'init' ) );

/**
 * @ignore
 * @author stephen
 */
class EO_Sync_Ical{

	/**
	 * Instance of the class
	 * @static
	 * @access protected
	 * @var object
	 */
	protected static $instance;
	
	static $version = '2.0.1';
	
	/**
	 * Instantiates the class
	 * @return object $instance
	 */
	public static function init() {
		is_null( self :: $instance ) AND self :: $instance = new self;
		return self :: $instance;
	}

	/**
	 * Constructor.
	 * @return \Post_Type_Archive_Links
	 */
	public function __construct() {

		if ( defined( 'EVENT_ORGANISER_VER' ) ){
			//Load ical functions
			require_once( plugin_dir_path( __FILE__ ) . 'ical-functions.php' );

			if ( version_compare( '2.7', EVENT_ORGANISER_VER ) <= 0 ){
				require_once( plugin_dir_path( __FILE__ ) . 'addon.php' );
			}

			//Load hooks
			$this->hooks();
		}

	}

	function hooks(){

		add_action( 'after_setup_theme', array( $this, 'setup_constants' ) );

		add_action( 'init', array( $this, 'register_feed_posttype' ) );

		add_action( 'eventorganiser_event_settings_imexport', array( $this, 'display_feeds' ), 5 );

		add_action( 'wp_ajax_add-eo-feed', array( $this, 'ajax_add_feed' ) );
		add_action( 'wp_ajax_delete-eo-feed', array( $this, 'ajax_delete_feed' ) );
		add_action( 'wp_ajax_fetch-eo-feed', array( $this, 'ajax_fetch_feed' ) );

		add_action( 'load-settings_page_event-settings', array( $this, 'update_feed_settings' ) );

	}
	
	function register_feed_posttype(){
		
		$labels = array(
			'name'                => _x( 'Feeds', 'Post Type General Name', 'eventorganiserical' ),
			'singular_name'       => _x( 'Feed', 'Post Type Singular Name', 'eventorganiserical' ),
			'view_item'           => __( 'View feeds', 'eventorganiserical' ),
			'add_new_item'        => __( 'Add New Feed', 'eventorganiserical' ),
			'add_new'             => __( 'Add Feed', 'eventorganiserical' ),
			'edit_item'           => __( 'Edit Feed', 'eventorganiserical' ),
			'update_item'         => __( 'Update Feed', 'eventorganiserical' ),
		);

		$args = array(
			'description'         => __( 'ICAL Feed', 'eventorganiserical' ),
			'labels'              => $labels,
			'supports'            => array( 'title' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => false,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'capability_type'     => 'post',
		);

		register_post_type( 'eo_icalfeed', $args );
		
	}
	
	function setup_constants(){
		define( 'EVENT_ORGANISER_ICAL_SYNC_URL', plugin_dir_url(__FILE__ ) );
	}
	
	
	function display_feeds(){
		 
		$ext = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_enqueue_script( 'eo-sync-ical', EVENT_ORGANISER_ICAL_SYNC_URL . "js/eo-sync-ical{$ext}.js", array( 'jquery', 'wp-lists' ), self::$version );
		?>
		<style>
			#feed-list #last-updated{ width: 20% }
			#feed-list #feed-events{ width: 10% }
			#feed-list td .eo-feed-error p {color: #c00;margin:2px;}
			#feed-list .inline-edit-row fieldset label span.title { width: 9em }
			#feed-list .inline-edit-row fieldset label span.input-text-wrap { margin-left: 9em; }
			#feed-list tr.feed-row td{ border-bottom: none; }
			#feed-list tr.feed-errors td{ border-top: none; }
			#feed-list tr.feed-row .row-actions{ padding: 0px; line-height:10px; }
			#feed-list tr.feed-row .row-actions span{ padding: 0px; margin:0px; }
			#feed-list tr .feed-alert{ margin: 5px;padding: 3px 5px; border: 1px solid;-webkit-border-radius: 3px;border-radius: 3px; }
			#feed-list tr .feed-warning{ background-color: #FFFBE4;border-color: #DFDFDF; }
			#feed-list tr .feed-error{ background-color: #ffebe8;border-color: #c00; }

		</style>
		
		<h3><?php esc_html_e( 'ICAL Feeds', 'eventorganiserical' ); ?></h3>
	
		<?php  $feeds = eo_get_feeds(); ?>		
		<div id="col-container">
			<div id="col-right">
					
			<table class="wp-list-table widefat fixed tags" id="feed-list" cellspacing="0" data-wp-lists="list:eo-feed">
				<thead>
					<tr>
						<th scope="col" id="name" class="" style="">
							<?php esc_html_e( 'Name', 'eventorganiserical' ); ?>
						</th>
						
						<th scope="col" id="url" class="" style="">
							<?php esc_html_e( 'Source', 'eventorganiserical' ); ?>
						</th>
						
						<th scope="col" id="last-updated" class="" style="">
							<?php esc_html_e( 'Last Fetched', 'eventorganiserical' ); ?>
						</th>
						<th scope="col" id="feed-events" class="" style="">
							<?php esc_html_e( 'Events', 'eventorganiser' ); ?>
						</th>
					</tr>
				</thead>
							
				<?php  
					if( $feeds ):
						foreach( $feeds as $feed ):
							$class = ( empty( $class ) ? 'class="alternate"' : ''  );
							$this->display_feed_row( $feed );
						endforeach; 
					endif; ?>
					<tr id="eo-feed-no-feeds" <?php if( $feeds ) echo 'style="display:none"';?>>
						<td colspan="4"> <?php esc_html_e( 'No feeds', 'eventorganiserical' ); ?></td>
					</tr>
				
			</table>
			<div class="form-wrap">	
				<form id="eo-feed-settings" method="post" class="validate">
					<input type="hidden" name="action" value="eventorganier-update-feed-settings" />

					<div class="form-required">
						<label for="sync-schedule"> 
						<?php 
							echo esc_html__( 'Sync schedule:', 'eventorganiserical') . ' '; 
							eventorganiser_select_field( array(
								'id' => 'sync-schedule',
								'options' => eo_get_feed_sync_schedules(),
								'selected' => get_option( 'eventorganiser_feed_schedule' ),
								'name' => 'eventorganiser_feed_schedule',								
							));
							
							wp_nonce_field( 'eventorganier-update-feed-settings' );
						
							submit_button( 
								__( 'Update feed settings', 'eventorganiserical' ), 'secondary', 'submit', false, 
								array(
									'id' => 'feed-settings-submit',
								));
						?>
						</label>
						<?php 
						if( $timestamp = wp_next_scheduled( 'eventorganiser_ical_feed_sync' ) ){
							$timestamp = (int) $timestamp;
							$date_obj = new DateTime( '@'.$timestamp );
							$date_obj->setTimezone( eo_get_blog_timezone() );
							printf(
								esc_html__( 'Next feed sync is scheduled for %s', 'eventorganiserical'),
								eo_format_datetime( $date_obj, get_option( 'date_format' ) . ' ' .  get_option( 'time_format' ) )
							);
						}
						?>
					</div>				
				</form>
			</div>
									
			</div>
			
			<div id="col-left">
				<div class="col-wrap">
				
					<div class="form-wrap">
						<h4> <?php esc_html_e( 'Add New Feed', 'eventorganiserical'); ?></h4>
						
						<form id="add-eo-feed" method="post" class="validate">

							<div class="form-field form-required">
								<label for="feed-name"> <?php esc_html_e( 'Name', 'eventorganiserical'); ?> </label>
								<input name="feed-name" id="feed-name" type="text" value="" size="40" aria-required="true">
							</div>

							<div class="form-field form-required">
								<label for="feed-source">Source</label>
								<input name="feed-source" id="feed-source" type="text" value="" size="40" aria-required="true">
							</div>

							<p class="hide-if-no-js">
								<a href="#" class="eo-advanced-feed-options-toggle eo-show-advanced-option">
									<?php _e( 'Show advanced options', 'eventorganiserical' ); ?>
								</a>
								<a href="#" class="eo-advanced-feed-options-toggle eo-hide-advanced-option hide-if-js">
									<?php _e( 'Hide advanced options', 'eventorganiserical' ); ?>
								</a>
							</p>
							
							<div id="eo-advanced-feed-options-wrap" class="hide-if-js">
								<div class="form-field">
									<label for="feed-organiser"><?php _e( 'Assign events to', 'eventorganiserical' ); ?></label>
									<?php wp_dropdown_users( array(
										'id'=> 'feed-organiser',
										'name' => 'feed-organiser',
										'selected' => get_current_user_id(),
									)); ?>
								</div>
							
								<div class="form-field">
									<label for="feed-category"><?php _e( 'Assign events to category', 'eventorganiserical' ); ?></label>
									<?php wp_dropdown_categories( array(
											'show_option_none' => __( 'Use category specified in feed', 'eventorganiserical' ),
											'orderby' => 'name', 
											'hide_empty' => 0, 
											'hierarchical' => 1,
											'name' => 'feed-category',
											'id' => 'feed-category',
											'taxonomy' => 'event-category',
									)); ?>
								</div>
								<div class="form-field">
									<label for="feed-status"><?php _e( 'Event status', 'eventorganiserical' ); ?></label>
									<?php 
									eventorganiser_select_field(array(
										'name' => 'feed-status',
										'id' => 'feed-status',
										'options' => array_merge( 
														array( '0' => __( 'Use status specified in feed', 'eventorganiserical' ) ), 
														get_post_statuses() 
													),
									)); ?>
								</div>
							</div>
							
							<?php 
								$nonce = wp_create_nonce( 'add-eo-feed-0' );
								submit_button( 
									__( 'Add new feed', 'eventorganiserical' ), 'primary', 'submit', true, 
									array(
										'data-wp-lists' => 'add:feed-list:add-eo-feed::_ajax_nonce=' . $nonce,
										'id' => 'add-eo-feed-submit',
									));
							?>
						</form>
					</div>
				</div>
			</div>
			
		</div>
	<?php 
	}
	
	function display_feed_row( $feed ){
		$del_nonce = wp_create_nonce( 'delete-eo-feed-' . $feed->ID );
		$upd_nonce = wp_create_nonce( 'add-eo-feed-' . $feed->ID );
		$fetch_nonce = wp_create_nonce( 'fetch-eo-feed-' . $feed->ID );
		$source = get_post_meta( $feed->ID, '_eventorganiser_feed_source', true );
		$error = maybe_unserialize( get_post_meta( $feed->ID, '_eventorganiser_feed_log', true ) );
		$warnings = get_post_meta( $feed->ID, '_eventorganiser_feed_warnings' );
		
		$user_id = get_post_meta( $feed->ID, '_eventorganiser_feed_organiser', true );
		$status = get_post_meta( $feed->ID, '_eventorganiser_feed_status', true );
		$category = get_post_meta( $feed->ID, '_eventorganiser_feed_category', true );
		
		?>
		<tbody id="eo-feed-<?php echo $feed->ID;?>" <?php //echo $class; ?>>
				
		<tr class="feed-row">		
			<td class="name">
				<strong> <?php echo esc_html( $feed->post_title ); ?></strong>
								
				<div class="row-actions">
					<span class="edit"><a href="#">Edit Feed </a> |</span>
					<span class="delete">
						<a class="delete-feed" data-wp-lists="delete:feed-list:eo-feed-<?php echo $feed->ID;?>::_ajax_nonce=<?php echo $del_nonce; ?>" href="#">
							<?php esc_html_e( 'Delete', 'eventorganiserical' ); ?>
						</a> 
					| </span>
					<span class="fetch"> 
						<a class="fetch-feed" data-wp-lists="dim:feed-list:eo-feed-<?php echo $feed->ID;?>:dimclass:::action=fetch-eo-feed&_ajax_nonce=<?php echo $fetch_nonce; ?>" href="#">
							<?php esc_html_e( 'Fetch now', 'eventorganiserical' ); ?>
						</a>
					</span>
					<span class="spinner" style="float: none;display: inline-block;visibility: hidden;"></span>
				</div>

			</td>
							
			<td class="source">
				<?php echo esc_html( $source ); ?> 
			</td>
						
			<td class="last-updated">
			<?php 
				$m_time = $feed->post_modified;
				$time = mysql2date( 'U', $m_time );
				$time_diff = time() - $time;

				if ( $time_diff > 0 && $time_diff < 60 * 60 )
					echo sprintf( __( '%s ago' ), human_time_diff( $time ) );
				else
					echo mysql2date( get_option( 'date_format' )  . '\<\b\r\/\> ' . get_option( 'time_format' ), $m_time );
			?> 
			</td>
			
			<td class="feed-events">
				<?php if( $events= get_post_meta( $feed->ID, '_eventorganiser_feed_events_parsed', true ) ) echo (int) $events; ?>
			</td>
								
			<td class="edit-column" style="display:none" colspan="3">

				<fieldset>
					<div class="inline-edit-col">
						<h4>Quick Edit</h4>

						<label>
							<span class="title">Name</span>
							<span class="input-text-wrap">
								<input type="text" name="feed-name" class="ptitle" value="<?php echo esc_attr( $feed->post_title ); ?>">
							</span>
						</label>
						<label>
							<span class="title">Slug</span>
							<span class="input-text-wrap">
								<input type="text" name="feed-source" class="ptitle" value="<?php echo esc_attr( $source ); ?>">
							</span>
						</label>
						<label>
							<span class="title"> <?php _e( 'Assign events to', 'eventorganiserical' ); ?></span>
							<span class="input-text-wrap">
								<?php wp_dropdown_users( array(
										'selected' => $user_id,
										'name' => 'feed-organiser',
								)); ?>
							</span>
						</label>
						
						<label>
							<span class="title"> <?php _e( 'Category', 'eventorganiserical' ); ?></span>
							<span class="input-text-wrap">
								<?php wp_dropdown_categories( array(
										'show_option_none' => __( 'Use category specified in feed', 'eventorganiserical' ),
										'orderby' => 'name', 
										'hide_empty' => 0, 
										'hierarchical' => 1,
										'name' => 'feed-category',
										'id' => 'feed-category-' . $feed->ID,
										'taxonomy' => 'event-category',
										'selected' => $category,
								)); ?>
							</span>
						</label>
						
						<label>
							<span class="title"> <?php _e( 'Event Status', 'eventorganiserical' ); ?></span>
							<span class="input-text-wrap">
								<?php 
								eventorganiser_select_field(array(
									'name' => 'feed-status',
									'id' => 'feed-status',
									'selected' => $status,
									'options' => array_merge( 
													array( '0' => __( 'Use status specified in feed', 'eventorganiserical' ) ), 
													get_post_statuses() 
												),
								)); ?>
							</span>
						</label>
					
					</div>		
					
					<input type="hidden" name="id" value="<?php echo esc_attr( $feed->ID ); ?>">
				</fieldset>
	
				<p class="inline-edit-save submit">
					<a accesskey="c" href="#inline-edit" title="Cancel" class="cancel button-secondary alignleft">Cancel</a>
					<a accesskey="s" id="eo-feed-<?php echo $feed->ID;?>-submit" data-wp-lists="add:feed-list:eo-feed-<?php echo $feed->ID;?>::_ajax_nonce=<?php echo $upd_nonce; ?>" href="#" title="Update Feed" class="save button-primary alignright">
						<?php esc_html_e( 'Update Feed', 'eventorganiserical' ); ?>
					</a>
					<span class="spinner"></span>
					<span class="error" style="display:none;"></span>		
					<br class="clear">
				</p>
			</td>
		</tr>
	
		<tr class="feed-errors">
			<td colspan="4">
			<?php if( $error ): ?>
				<div class="feed-error feed-alert"><?php echo esc_html( $error['log'] );?></div>
			<?php endif; ?>
			<?php if( $warnings ): ?> 
				<div class="feed-warning feed-alert">
					<?php 
						$messages = wp_list_pluck( $warnings, 'log' );
						echo implode( '<br/>', $messages );
					?> 
				</div>
			<?php endif; ?>
			</td>
		</tr>
		</tbody>
		<?php 
	}
	
	function ajax_add_feed(){

		$name = $_POST['feed-name'];
		$source = esc_url_raw( $_POST['feed-source'], array( 'http', 'https', 'webcal', 'feed' ) );
		$organiser = isset( $_POST['feed-organiser'] ) ? (int) $_POST['feed-organiser'] : get_current_user_id();
		$status = isset( $_POST['feed-status'] ) ?  $_POST['feed-status'] : false;
		$category = isset( $_POST['feed-category'] ) ? (int) $_POST['feed-category'] : 0;
	
		$old_id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		
		if( !current_user_can( 'manage_options' ) ){
			//Respond
			$x = new WP_Ajax_Response( array(
					'what' => 'eo-feed',
					'id' => new WP_Error( 'failed-update', 'Insufficient permissions' ),
					'old_id' => $old_id,
			));
			$x->send();
			exit();
		}
		
		check_ajax_referer( 'add-eo-feed-' . $old_id );
		
		if( !$old_id ){
			$feed_id = eo_insert_feed( $name, $source );
			update_post_meta( $feed_id, '_eventorganiser_feed_organiser', $organiser );
			update_post_meta( $feed_id, '_eventorganiser_feed_category', $category );
			update_post_meta( $feed_id, '_eventorganiser_feed_status', $status );
		}else{
			$feed_id = eo_update_feed( $old_id, compact( 'name', 'source', 'organiser', 'status', 'category' ) );
		}
		$feed = get_post( $feed_id );
		
		ob_start();
		$this->display_feed_row( $feed );
		$markup = ob_get_contents();
		ob_end_clean();
		
		//Respond
		$x = new WP_Ajax_Response( array(
				'what' => 'eo-feed',
				'id' => $feed_id,
				'old_id' => $old_id,
				'data' =>  $markup,
				'position' => 0,
		));
		$x->send();
		exit();
	}
	
	function ajax_fetch_feed(){

		$feed_id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;
		
		if( !current_user_can( 'manage_options' ) )
			wp_die( -1 );
		
		check_ajax_referer( 'fetch-eo-feed-' . $feed_id );
		
		if( !$feed_id ){
			wp_die( -1 );
		}
		
		set_time_limit( 600 );
		if( eo_fetch_feed( $feed_id ) ){
			
			$feed = get_post( $feed_id );
			$m_time = $feed->post_date;
			$timestamp = get_post_time( 'G', true, $feed );
			$time_diff = time() - $timestamp;
			$events = get_post_meta( $feed_id, '_eventorganiser_feed_events_parsed', true );
			if ( $time_diff > 0 && $time_diff < DAY_IN_SECONDS )
				$last_updated = sprintf( __( '%s ago' ), human_time_diff( $time ) );
			else
				$last_updated = mysql2date( get_option( 'date_format' )  . '\<\b\r\/\> ' . get_option( 'time_format' ), $m_time );
			
			ob_start();
			$this->display_feed_row( $feed );
			$markup = ob_get_contents();
			ob_end_clean();
			
			$warnings = get_post_meta( $feed_id, '_eventorganiser_feed_warnings' );
		
			if( !empty( $warnings ) ){
				//$warnings = array_map( 'unserialize', $warnings );
				$warnings = wp_list_pluck( $warnings, 'log' );
				$warnings = implode( '<br/>', $warnings );
			}else{
				$warnings = false;
			}
			
			//wp_die( 1 );
			//Respond
			$x = new WP_Ajax_Response( array(
					'what' => 'eo-feed',
					'id' => $feed_id,
					'old_id' => $feed_id,
					'data' => $markup,
					'supplemental' => compact( 'last_updated', 'timestamp', 'events', 'warnings' ),
			));
			$x->send();
			
		}
		
		$feed = get_post( $feed_id );
		ob_start();
		$this->display_feed_row( $feed );
		$markup = ob_get_contents();
		ob_end_clean();
	
		$error = maybe_unserialize( get_post_meta( $feed_id, '_eventorganiser_feed_log', true ) );
				
		//Respond
		$x = new WP_Ajax_Response( array(
				'what' => 'eo-feed',
				'id' => new WP_Error( 'failed-fetch', $error['log'] ),
				'old_id' => $feed_id,
				'data' => $markup,
				'supplemental' => compact( 'last_updated', 'timestamp', 'events' ),
				
		));
		$x->send();
		exit();
	}

	function ajax_delete_feed(){
		$feed_id = isset( $_POST['id'] ) ? (int) $_POST['id'] : 0;

		if( !$feed_id ){
			wp_die( -1 );
		}
		
		if( !current_user_can( 'manage_options' ) ){
			//Respond
			$x = new WP_Ajax_Response( array(
					'what' => 'eo-feed',
					'id' => new WP_Error( 'failed-delete', 'Insufficient permissions' ),
					'old_id' => $feed_id,
			));
			$x->send();
			exit();		
		}
		
		check_ajax_referer( 'delete-eo-feed-' . $feed_id );
		
		eo_delete_feed( $feed_id );
		wp_die( 1 );
	
	}
	
	function update_feed_settings(){

		if( !empty( $_POST['action'] ) && 'eventorganier-update-feed-settings' == $_POST['action'] ){
			
			if( !current_user_can( 'manage_options' ) )
				return;
			
			check_admin_referer( 'eventorganier-update-feed-settings' );			

			$schedule =  $_POST['eventorganiser_feed_schedule'];
			update_option( 'eventorganiser_feed_schedule', $schedule );
		
			wp_clear_scheduled_hook( 'eventorganiser_ical_feed_sync' );
			
			if( $schedule ){
				$schedules = wp_get_schedules();
				$timestamp = time() + $schedules[$schedule]['interval'];		
				wp_schedule_event( $timestamp, $schedule, 'eventorganiser_ical_feed_sync' );
			}
			
			wp_redirect( admin_url( 'options-general.php?page=event-settings&tab=imexport&settings-updated=true' ) );
			exit();
		}
	
	}
		
}
?>