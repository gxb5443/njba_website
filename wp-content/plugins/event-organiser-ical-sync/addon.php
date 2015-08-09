<?php 
class EO_Extension_Ical extends EO_Extension{

	public $slug 		= 'event-organiser-ical-sync/event-organiser-ical-sync.php';
	public $public_url 	= 'http://wp-event-organiser.com/downloads/event-organiser-ical-sync/';
	public $label 		= 'iCal Sync';
	public $id 			= 'eventorganiser_ical_sync';

	public $dependencies = array(
		'event-organiser/event-organiser.php' => array(
			'name' 			=> 'Event Organiser',
			'version' 		=> '2.7.0',
			'install_slug' 	=> 'event-organiser',
			'url'			=> 'http://wordpress.org/plugins/event-organiser',
		),
	);
}

$ical = new EO_Extension_Ical();