<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 * 
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); }

		$event_id = get_the_ID();
		$type_event = get_meta_option('events_type_meta_box');
		$time_format = get_option( 'time_format', TribeDateUtils::TIMEFORMAT );
		$time_range_separator = tribe_get_option('timeRangeSeparator', ' - ');

		$start_datetime = tribe_get_start_date();
		$start_date = tribe_get_start_date( null, false, 'M d, Y' );
		$start_time = tribe_get_start_date( null, false, $time_format );
		$start_ts = tribe_get_start_date( null, false, TribeDateUtils::DBDATEFORMAT );

		$end_datetime = tribe_get_end_date();
		$end_date = tribe_get_end_date( null, false, 'M d, Y' );
		$end_time = tribe_get_end_date( null, false,  $time_format );
		$end_ts = tribe_get_end_date( null, false, TribeDateUtils::DBDATEFORMAT );
		
		$address = tribe_address_exists() ? '' . tribe_get_full_address() . '' : '';

		$cost = tribe_get_formatted_cost();
		$phone = tribe_get_organizer_phone();
		$email = tribe_get_organizer_email();
		$website = tribe_get_organizer_website_link();


		
	$venue_details = array();

	

	if ($venue_address = tribe_get_meta( 'tribe_event_venue_address' ) ) {
		$venue_details[] = $venue_address;	
	}
	// Venue microformats
	$has_venue_address = ( $venue_address ) ? ' location': '';

	// Organizer
	$organizer = tribe_get_organizer();


	

if( $type_event == 'style1' || $type_event == 'style12' ) {
$thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-blog'); 	

?>

	<!-- Notices -->
	<?php tribe_events_the_notices() ?>

	<?php while ( have_posts() ) :  the_post(); ?>
	<!-- Event Single -->
	<div id="post-<?php the_ID(); ?>" <?php post_class('event-single event-type1'); ?> >
		
		<div class="row">
			
			<div class="col-lg-9 col-md-9 col-sm-8 animate-onscroll">
				
				<div class="event-image">
					<img src="<?php  echo $thumb_image_url[0];  ?>" alt="">
				</div>
				
				<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
				
				<h6><?php _e( 'Description', THEMENAME ) ?></h6>
				
				<?php the_content(); ?>
				
				
				
				
				
				<!-- .tribe-events-single-event-description -->
					<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
				<!-- Event meta -->
				<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			
				<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
				
				
				
				
				<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
				
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-4">
				
				<!-- Event Meta -->
				<div class="event-meta">
					
					<div class="event-meta-block animate-onscroll">
						
						<i class="icons icon-calendar"></i>
						<p class="title"><?php _e( 'Start Date - End Date', THEMENAME ) ?></p>
						<p><?php echo $start_date;  ?> - <?php echo $end_date;  ?></p>
						
					</div>
					
					<div class="event-meta-block animate-onscroll">
						
						<i class="icons icon-clock"></i>
						<p class="title"><?php _e( 'Start Time - End Time', THEMENAME ) ?></p>
						<p><?php esc_html_e( $start_time . $time_range_separator . $end_time, 'tribe-events-calendar' ); ?></p>
						
					</div>
					
					
					<?php if( $address != '' ) { ?>
					<div class="event-meta-block animate-onscroll">
						
						<i class="icons icon-location"></i>
						<p class="title"><?php _e( 'Event Location', THEMENAME ) ?></p>
						<p><?php echo $address; ?></p>
						
					</div>
					<?php } ?>
					
					
					<?php if ( ! empty( $cost ) ): ?>
					<div class="event-meta-block animate-onscroll">
						
						<i class="icons icon-ticket"></i>
						<p class="title"><?php _e( 'Cost', THEMENAME ) ?></p>
						<p><?php esc_html_e( tribe_get_formatted_cost(), 'tribe-events-calendar' ) ?></p>
						
					</div>
					<?php endif ?>
					
					
					<?php if ( candidat_tribe_get_event_categories1( get_the_id() ) != '' ) { ?>
					<div class="event-meta-block animate-onscroll">
						<i class="icons icon-folder-open"></i>
						<?php
						echo candidat_tribe_get_event_categories1( get_the_id(),array(
							'before' => '',
							'sep' => ', ',
							'after' => '',
							'label' => __( 'Category', THEMENAME ), // An appropriate plural/singular label will be provided
							'label_before' => '<p class="title">',
							'label_after' => '</p>',
							'wrap_before' => '<dd class="tribe-events-event-categories">',
							'wrap_after' => '</dd>'
						) );
						?>
					</div>
					<?php } ?>
					
					
					<?php if ( tribe_meta_event_tags('', '', false) != '' ) { ?>
					<div class="event-meta-block animate-onscroll">
						<i class="icons icon-tags"></i>
						<?php echo candidat_tribe_meta_event_tags1( __( 'Tags', THEMENAME ), ', ', false ) ?>
					</div>
					<?php } ?>
					
					
					<?php if ( tribe_get_organizer() != '' ) { ?>
					<div class="event-meta-block animate-onscroll">
						
						<i class="icons icon-user"></i>
						<p class="title"><?php _e( 'Organizer', THEMENAME ) ?></p>
						<p><?php echo tribe_get_organizer() ?></p>
						
					</div>
					<?php } ?>
					
					
					
					<?php if ( ! empty( $phone ) ): ?>
					<div class="event-meta-block animate-onscroll">
						
						<i class="icons icon-phone"></i>
						<p class="title"><?php _e( 'Phone', THEMENAME ) ?></p>
						<p><?php echo $phone ?></p>
						
					</div>
					<?php endif ?>
					
					<?php if ( ! empty( $email ) ): ?>
					<div class="event-meta-block animate-onscroll">
						
						<i class="icons icon-mail-alt"></i>
						<p class="title"><?php _e( 'Email', THEMENAME ) ?></p>
						<p><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></p>
						
					</div>
					<?php endif ?>
					
					<?php if ( ! empty( $website ) ): ?>
					<div class="event-meta-block animate-onscroll">
						
						<i class="icons icon-mail-alt"></i>
						<p class="title"><?php _e( 'Website', THEMENAME ) ?></p>
						<p><?php echo $website ?></p>
						
					</div>
					<?php endif ?>
					
					<div class="event-meta-block animate-onscroll">
						
						<i class="icons icon-share"></i>
						<p class="title"><?php _e( 'Share This', THEMENAME ) ?></p>
						<ul class="social-share">
							<li class="facebook"><a href="#" class="tooltip-ontop" title="Facebook"><i class="icons icon-facebook"></i></a></li>
							<li class="twitter"><a href="#" class="tooltip-ontop" title="Twitter"><i class="icons icon-twitter"></i></a></li>
							<li class="google"><a href="#" class="tooltip-ontop" title="Google Plus"><i class="icons icon-gplus"></i></a></li>
							<li class="pinterest"><a href="#" class="tooltip-ontop" title="Pinterest"><i class="icons icon-pinterest-3"></i></a></li>
							<li class="email"><a href="#" class="tooltip-ontop" title="Email"><i class="icons icon-mail"></i></a></li>
						</ul>
						
					</div>
					
					
				</div>
				<!-- /Event Meta -->
				
			</div>
			
		</div>
	
	</div>
	<!-- /Event Single -->
	<?php endwhile; ?>
<?php } else { ?>

			<!-- Event Single2 -->
			<div class="event-single">
				
				<div class="row">
					
					<div class="col-lg-12 col-md-12 col-sm-12">
						
						<!-- Event Meta -->
						<div class="event-meta horizontal">
							
							<div class="event-meta-block col-lg-3 col-md-3 col-sm-6 animate-onscroll">
								
								<i class="icons icon-calendar"></i>
								<p class="title"><?php _e( 'Start Date - End Date', THEMENAME ) ?></p>
								<p><?php echo $start_date;  ?> - <?php echo $end_date;  ?></p>
								
								
							</div>
							
							<div class="event-meta-block col-lg-3 col-md-3 col-sm-6 animate-onscroll">
								
								<i class="icons icon-clock"></i>
								<p class="title"><?php _e( 'Start Time - End Time', THEMENAME ) ?></p>
								<p><?php esc_html_e( $start_time . $time_range_separator . $end_time ); ?></p>
								
							</div>
							
							<div class="event-meta-block col-lg-3 col-md-3 col-sm-6 animate-onscroll">
								
								<i class="icons icon-location"></i>
								<p class="title"><?php _e( 'Event Location', THEMENAME ) ?></p>
								<p><?php echo $address; ?></p>
								
							</div>
							
							<div class="event-meta-block col-lg-3 col-md-3 col-sm-6 animate-onscroll">
								
								<i class="icons icon-ticket"></i>
								<p class="title"><?php _e( 'Cost', THEMENAME ) ?></p>
								<p><?php esc_html_e( tribe_get_formatted_cost() ) ?></p>
								
							</div>
							
						</div>
						<!-- /Event Meta -->
						
						<div class="event-image animate-onscroll">
						
						<?php if( tribe_embed_google_map( get_the_ID() ) ) : ?>
						<?php if( tribe_address_exists( get_the_ID() ) ) { echo tribe_get_embedded_map(get_the_ID()); } ?>
						<?php endif; ?>
					
							
						</div>
						
						<!-- Event Meta -->
						<div class="event-meta horizontal">
							
							<div class="event-meta-block col-lg-3 col-md-3 col-sm-6 animate-onscroll">
								
								<i class="icons icon-user"></i>
								<p class="title"><?php _e( 'Organizer', THEMENAME ) ?></p>
								<p><?php echo $organizer; ?></p>
								
							</div>
							
							<div class="event-meta-block col-lg-3 col-md-3 col-sm-6 animate-onscroll">
								
								<i class="icons icon-phone"></i>
								<p class="title"><?php _e( 'Phone', THEMENAME ) ?></p>
								<p><?php echo $phone ?></p>
								
							</div>
							
							<div class="event-meta-block col-lg-3 col-md-3 col-sm-6 animate-onscroll">
								
								<i class="icons icon-mail-alt"></i>
								<p class="title"><?php _e( 'Email', THEMENAME ) ?></p>
								<p><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></p>
								
							</div>
							
							<div class="event-meta-block col-lg-3 col-md-3 col-sm-6 animate-onscroll">
								
								<i class="icons icon-globe"></i>
								<p class="title"><?php _e( 'Website', THEMENAME ) ?></p>
								<p><?php echo $website ?></p>
								
							</div>
							
						</div>
						<!-- /Event Meta -->
						
						
						<div class="row event-details">
							
							<div class="col-lg-4 col-md-4 col-sm-6 animate-onscroll">
								
								<h6><?php _e( 'Event Details', THEMENAME ) ?></h6>
								
								<table class="project-details">
							
									<tr>
									<?php
									echo candidat_tribe_get_event_categories1( get_the_id(),array(
										'before' => '',
										'sep' => ', ',
										'after' => '',
										'label' => __( 'Category:', THEMENAME ), 
										'label_before' => '<td>',
										'label_after' => '</td>',
										'wrap_before' => '<td>',
										'wrap_after' => '</td>'
									) );
									?>
									</tr>
									
									<tr>
										<?php echo candidat_tribe_meta_event_tags2( __( 'Tags:', THEMENAME ), ', ', false ) ?>
									</tr>
									
									<tr>
										<td><?php _e( 'Share this', THEMENAME ) ?>:</td>
										<td>
											<ul class="social-share">
												<li class="facebook"><a href="#" class="tooltip-ontop" title="Facebook"><i class="icons icon-facebook"></i></a></li>
												<li class="twitter"><a href="#" class="tooltip-ontop" title="Twitter"><i class="icons icon-twitter"></i></a></li>
												<li class="google"><a href="#" class="tooltip-ontop" title="Google Plus"><i class="icons icon-gplus"></i></a></li>
												<li class="pinterest"><a href="#" class="tooltip-ontop" title="Pinterest"><i class="icons icon-pinterest-3"></i></a></li>
												<li class="email"><a href="#" class="tooltip-ontop" title="Email"><i class="icons icon-mail"></i></a></li>
											</ul>
										</td>
									</tr>
									
								</table>
								
							</div>
							
							<div class="col-lg-8 col-md-8 col-sm-6 animate-onscroll">
								
								<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
								
								<h6><?php _e( 'Description', THEMENAME ) ?></h6>
						
								<?php the_content(); ?>
								
								
							
							
							<!-- .tribe-events-single-event-description -->
								<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
							<!-- Event meta -->
							<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
											
							<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
							
							<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
							
							</div>
							
							
							
							
							
							
							
						</div>
						
						
					</div>
					
				</div>
			
			</div>
			<!-- /Event Single2 -->

<?php } ?>





	<div class="row event-pagination">
						
		<div class="col-lg-4 col-md-4 col-sm-4 align-left animate-onscroll">
			<?php tribe_the_prev_event_link( 'Prev event' ) ?>
		</div>
		
		<div class="col-lg-4 col-md-4 col-sm-4 align-center animate-onscroll">
			<a href="<?php echo tribe_get_events_link() ?>" class="button big"><?php _e( 'All events', THEMENAME ) ?></a>
		</div>
		
		<div class="col-lg-4 col-md-4 col-sm-4 align-right animate-onscroll">
			<?php tribe_the_next_event_link( 'Next event' ) ?>
		</div>
	
	</div>




