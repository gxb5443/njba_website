<?php
// Custom for Composer
$target_arr = array(__("Same window", "js_composer") => "_self", __("New window", "js_composer") => "_blank");
$show_arr = array(__("Show", "js_composer") => "_show", __("Hide", "js_composer") => "_hide");
$btn_size = array(__("Small", "js_composer") => "transparent", __("Middle", "js_composer") => " ", __("Big", "js_composer") => "big");

 
$icon_arr = candidat_custom_fontello_classes();




//////////////////////////////vc_contact_information////////////////////////////////////////////////////////////////////////////////
function vc_contact_information_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'title' => '',
      'map_address' => '',
      'map_markers' => '',
      'image_markers' => '',
      'css_animation' => ''
   ), $atts ) );
 
	$css_class =  '';
	$css_class .= $css_animation;
	
	$img_id = preg_replace('/[^\d]/', '', $image_markers);
    $map_thumbnail = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => 'latest-post', 'class' => '' ));
	$map_thumbnail = $map_thumbnail['p_img_large'][0];  

	
	$id = rand(1, 100);
	$output  = '';
	
	$output .=  '<script src="http://maps.google.com/maps/api/js?v=3.19&sensor=false" type="text/javascript" ></script>
	<script  type="text/javascript" >
		(function($) {

		$(document).ready(function(){
			
		function initialize() {
		  var myLatlng = new google.maps.LatLng('. $map_address .');
		  var myLatlng2 = new google.maps.LatLng('. $map_markers .');
		  var image = "'. $map_thumbnail .'";
		  
		  
		  var mapOptions = {
			zoom: 10,
			center: myLatlng,
			mapTypeControl: false,
			scrollwheel: false,
			navigationControl: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		  };
		  var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

		  var marker = new google.maps.Marker({
			  position: myLatlng2,
			  map: map,
			  icon: image
		  });
		}

		google.maps.event.addDomListener(window, "load", initialize);

		});
		
		})(jQuery);
		
    </script>';
	
	$output  .= '<style type="text/css" >
			  body #map-canvas img {
				max-width: none !important;
			  }
			  #map-canvas {
				height: 400px;
				margin: 0px;
				padding: 0px
			  }
    </style>';
	
	$output  .= '<div class="contact-info'.$id.' '. $css_class .'">
				<h3 class="no-margin-top" >'. $title .'</h3>
		<div class="contact-info-map">
		    <div id="map-canvas" ></div>
		</div></div>';
		
	
	

 
   return $output;
}
add_shortcode('vc_contact_information', 'vc_contact_information_func');

vc_map( array(
   "name" => __("Custom Map", THEMENAME),
   "base" => "vc_contact_information",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Google Map block', 'js_composer'),
   "params" => array(
   
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Our Location","js_composer"),
         "description" => __("Block title.","js_composer")
        ),
		
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Google Map Address (51.451955,-0.055755)", "js_composer"),
         "param_name" => "map_address",
         "value" => "",
         "description" => __("Google Map Address.","js_composer")
        ),
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Google Map Markers", "js_composer"),
         "param_name" => "map_markers",
         "value" => "",
         "description" => ""
        ),
		
		array(
		  "type" => "attach_image",
		  "heading" => __("Marker image", "js_composer"),
		  "param_name" => "image_markers",
		  "value" => "",
		  "description" => __("Select marker image from media library.", "js_composer")
		),

        array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );











//////////////////////////////FlexSlider////////////////////////////////////////////////////////////////////////////////
function flexslider_func( $atts, $content = null ) { // New function parameter $content is added!
   
   extract( shortcode_atts( array(
      'slideshow' => '',
	  'slideshowspeed' => '',
      'css_animation' => ''
   ), $atts ) );
 
    $width_class = '';
	$css_class =  '';
	$css_class .= $css_animation;
	
 if($slideshow != 'true') {
 $slideshow = 'false';
	}
	
	if($slideshowspeed == '') {
 $slideshowspeed = '5000';
	}
	
	
	
	$args = array( 'post_type'=>'slideshow',
				   'orderby' => 'menu_order',
				   'order' => 'ASC',
				   'numberposts' => -1);
				   
	$myposts = get_posts( $args );
	
	$id= rand(1, 100);
	
	$output  = '<div class="flexslider main-flexslider my-flexslider-'. $id .' animate-onscroll  '. $css_class .'">
                        <ul class="slides">';
	$count = 0;
	
	foreach( $myposts as $post ) :  setup_postdata($post);
			$post_id = $post->ID;
			$count++;
			$title = get_the_title();		
			$content = get_the_content();	
			
			$post_thumbnail_id = get_post_thumbnail_id($post->ID);
			$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );

			$position = get_meta_option('slideshow_btn_pos_meta_box', $post->ID);
			$post_url = get_meta_option('slideshow_btn_url_meta_box', $post->ID);
			$post_url_title = get_meta_option('slideshow_btn_meta_box', $post->ID);
			
	$output .=  '<li id="main_flex_'. $count .'" style="background: transparent url(' . $post_thumbnail_url . ') no-repeat;" >
								<div class = "slide ' . $position . '">
									'. $content .'';
									if($post_url != '') {
	$output .=  '<a href="'. $post_url .'" class="button big button-arrow">'. $post_url_title .'</a>';
									}
	$output .=  '</div>
                            </li>';
	
	
	endforeach; 	
	
	$output .=  '</ul>
                    </div>';
 
 
	$output .= '<script type="text/javascript">'."\n";
		$output .= '(function($){'."\n";
		$output .= '$(window).load(function() {'."\n";
		$output .= 'var fslider_'.$id.' = $(".main-flexslider.my-flexslider-'.$id.'");'."\n";
		$output .= 'fslider_'.$id.'.flexslider({'."\n";
		$output .= '		animation: "slide",'."\n";
		$output .= '		slideshow: '.$slideshow.','."\n";                
		$output .= '		slideshowSpeed: '.$slideshowspeed."\n";  
		$output .= '	});'."\n";
		
		$output .= '	});'."\n";
		
		$output .= '	})(jQuery);'."\n";
		$output .= '</script>'."\n";
 
 
   return $output;
}
add_shortcode('vc_flexslider', 'flexslider_func');

vc_map( array(
   "name" => __("Home block of Flexslider", THEMENAME),
   "base" => "vc_flexslider",
    "wrapper_class" => "clearfix",
  "category" => __('Content', 'js_composer'),
  "description" => __('A block of flexslider', 'js_composer'),
   "params" => array(
		array(
            "type" => "dropdown",
            "heading" => __("Slideshow", "js_composer"),
            "param_name" => "slideshow",
            "description" => __('Select slideshow.', 'js_composer'),
            "value" => array(__("Yes", "js_composer") => "true", __("No", "js_composer") => "false")
        ),
   
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Slideshow speed", "js_composer"),
         "param_name" => "slideshowspeed",
         "value" => "5000",
         "description" => __("Enter of slideshow speed.","js_composer")
        ),
      array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)
   )
) );







//////////////////////////////vc_mylatest_news///////////////////////////////////////////////
function vc_mylatest_news_func( $atts, $content = null ) { 
   extract( shortcode_atts( array(
      'title' => '',
      'my_product_cat' => '',
      'author_show' => '',
      'css_animation' => ''
   ), $atts ) );
 
    $width_class = '';
	$css_class =  '';
	$css_class .= $css_animation;
	
	$custom_class = '';
	$my_cat = '';
	$term = get_term( $my_product_cat, 'category' );
	if( !empty($term->slug) ) {
	$my_cat = $term->slug;
	}
	
	
    $args = array(  
    'post_type' => 'post',  
	'category_name' => $my_cat, 
	'orderby' => 'date',
	'order' => 'desc',
    'posts_per_page' => 1 
	);  
		   
	$myposts = get_posts( $args );


	$output  = '<div class="latest_news '. $css_class .'">
					<h3>'. $title .'</h3>';

	
	foreach( $myposts as $post ) :  setup_postdata($post);
			$post_id = $post->ID;
			
			$post_thumbnail_id = get_post_thumbnail_id($post->ID);
			$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
	
	$output .=  '<!-- Blog Post -->
						<div class="blog-post big animate-onscroll">
							
							<div class="post-image"><a href="'. get_permalink($post_id) .'">
								'. get_the_post_thumbnail( $post_id, 'portfolio3' ) .'
							</a></div>
							
							<h4 class="post-title"><a href="'. get_permalink($post_id) .'">'. get_the_title($post_id) .'</a></h4>';
				
				
				if($author_show != '_hide') {
				$output .=  '<div class="post-meta">
								<span>by <a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ) .'">'. get_the_author() .'</a></span>
								<span>'. get_the_time('F j, Y g:i a', $post_id) .'</span>
							</div>';
				}			
							
							
	$output .=  '<p>'. candidat_the_excerpt_max_charlength_text(get_the_excerpt(), 32) .'</p>
							
							<a href="'. get_permalink($post_id) .'" class="button read-more-button big button-arrow">'. __('Read More', 'js_composer') .'</a>
							
						</div>
						<!-- /Blog Post -->';
	
	endforeach; 	
	
	$output .=  '</div>';

   return $output;
}
add_shortcode('vc_mylatest_news', 'vc_mylatest_news_func');

vc_map( array(
   "name" => __("Home block Latest News", THEMENAME),
   "base" => "vc_mylatest_news",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Home block of Latest News', 'js_composer'),
   "params" => array(
   
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Latest news","js_composer"),
         "description" => __("Block title.","js_composer")
        ),
		
		array(
            "type" => "post_category",
            "heading" => __("Select category", "js_composer"),
            "param_name" => "my_product_cat",
            "description" => __("Select category.", "js_composer")
        ),
	   
	    array(
		  "type" => "dropdown",
		  "heading" => __("Author Show", "js_composer"),
		  "param_name" => "author_show",
		  "description" => __("Select show or hide author info.", "js_composer"),
		  'value' => $show_arr
		  
		),
	   
        array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );




//////////////////////////////vc_mylatest_other stories////////////////////////////////////////////////////////////////////////////////
function vc_mylatest_post_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'title' => '',
      'video_thumbnails' => '',
      'my_product_cat' => '',
      'columns_count' => '3',
      'num_items' => '',
      'author_show' => '',
      'css_animation' => ''
   ), $atts ) );
 
    $width_class = '';
	$css_class =  '';
	$css_class .= $css_animation;
	
	$custom_class = '';
	$my_cat = '';
	$term = get_term( $my_product_cat, 'category' );
	if( !empty($term->slug) ) {
	$my_cat = $term->slug;
	}
	
	$num_items =  $num_items + 1;
	
	
	
	
    $args = array(  
    'post_type' => 'post',  
	'category_name' => $my_cat, 
	'orderby' => 'date',
	'order' => 'desc',
    'posts_per_page' => $num_items  
	);  
		   
	$myposts = get_posts( $args );
	
	
	
	
	$id = rand(1, 100);
	
	$slideshow_auto = 'false';
	if ($slideshow_auto == 'true') {
	$slideshow = $slideshow_delay;
	}else{
	$slideshow = 'false';
	}

	
	$output  = '<!-- Owl Carousel -->
						<div class="owl-carousel-container '. $css_class .'">
							
							<div class="owl-header">
								
								<h3 class="animate-onscroll">'. $title .'</h3>';
								
								
				if(count($myposts) > $columns_count) {			
			$output  .= '<div class="carousel-arrows animate-onscroll">
									<span class="left-arrow"><i class="icons icon-left-dir"></i></span>
									<span class="right-arrow"><i class="icons icon-right-dir"></i></span>
								</div>';
					}	
								
								
								
	$output  .= '</div>
	<div class="owl-carousel owl-carousel'.$id.' " data-max-items="'. $columns_count .'">';


	
	
	if(count($myposts) > 0) {
		
	foreach( $myposts as $post ) :  setup_postdata($post);
			$post_id = $post->ID;
			
			$format = 'standard';
			if(get_post_meta($post->ID,'meta_blogposttype',true) && get_post_meta($post->ID,'meta_blogposttype',true) !=''){
			$format = get_post_meta($post->ID,'meta_blogposttype',true); 
			}
			$post_thumbnail_id = get_post_thumbnail_id($post->ID);
			$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );

	
	$output .=  '<!-- Owl Item -->
				<div>
					
					<!-- Blog Post -->
					<div class="blog-post animate-onscroll">';
						
					if ($video_thumbnails == 'yes' && $format == 'video') {	
					
				$output .=  '<div class="post-image">';
						
						
						
					 if( get_post_meta($post->ID,'meta_blogvideoservice',true) == 'html5' ) { 
						$url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "latest-post" ); 
				$output .=  '<video width="100%" height="177"  id="home_video" class="entry-video video-js vjs-default-skin" poster="'. esc_url($url[0]) .'" data-aspect-ratio="2.41" data-setup="{}" controls>
						<source src="'. esc_url(get_post_meta($post->ID,'meta_blogvideourl',true)) .'" type="video/mp4"/>
						<source src="'. esc_url(get_post_meta($post->ID,'meta_blogvideourl',true)) .'" type="video/webm"/>
						<source src="'. esc_url(get_post_meta($post->ID,'meta_blogvideourl',true)) .'" type="video/ogg"/>
						</video>';

					} 


					if( get_post_meta($post->ID,'meta_blogvideoservice',true) == 'vimeo' && ! post_password_required() ) { 
				$output .=  '<iframe src="http://player.vimeo.com/video/'.  get_post_meta($post->ID,'meta_blogvideourl',true) .'?js_api=1&amp;js_onLoad=player'.  get_post_meta($post->ID,'meta_blogvideourl',true) .'_1798970533.player.moogaloopLoaded" width="100%" height="177"  allowFullScreen></iframe>';
					} 


					if( get_post_meta($post->ID,'meta_blogvideoservice',true) == 'youtube' && ! post_password_required() ) {
				$output .=  '<iframe width="100%" height="177" src="http://www.youtube.com/embed/'. get_post_meta($post->ID,'meta_blogvideourl',true) .'" allowfullscreen></iframe>';
					} 	

						
						
						
						
						
						
					$output .=  '</div>';	
						
					} else {
						
				$output .=  '<div class="post-image"><a href="'. get_permalink($post_id) .'">
							'. get_the_post_thumbnail( $post_id, 'latest-post' ) .'
						</a></div>';		
						
					}
	
	$output .=  '<h4 class="post-title"><a href="'. get_permalink($post_id) .'">'. get_the_title($post_id) .'</a></h4>';
						
				if($author_show != '_hide') {		
				$output .=  '<div class="post-meta">
							<span>by <a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ) .'">'. get_the_author() .'</a></span>
							<span>'. get_the_time('F j, Y g:i a', $post_id) .'</span>
						</div>';
				}		
						
						
	$output .=  '<p>'. candidat_the_excerpt_max_charlength_text(get_the_excerpt(), 12) .'</p>
						
						<a href="'. get_permalink($post_id) .'" class="button read-more-button big button-arrow">'. __('Read More', 'js_composer') .'</a>
						
					</div>
					<!-- /Blog Post -->
					
				</div>
				<!-- /Owl Item -->';

	endforeach; 
	}
	
	$output .=  '</div></div>';
 
   return $output;
}
add_shortcode('vc_mylatest_post', 'vc_mylatest_post_func');

vc_map( array(
   "name" => __("Home block Other Stories", THEMENAME),
   "base" => "vc_mylatest_post",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Home block of Other Stories', 'js_composer'),
   "params" => array(
   
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Other Stories","js_composer"),
         "description" => __("Block title.","js_composer")
        ),
		
		array(
            "type" => "post_category",
            "heading" => __("Select category", "js_composer"),
            "param_name" => "my_product_cat",
            "description" => __("Select category.", "js_composer")
        ),
   
		array(
			'type' => 'checkbox',
			'heading' => __( 'Video Thumbnails', 'js_composer' ),
			'param_name' => 'video_thumbnails',
			'description' => __( 'If selected, show Video Thumbnails.', 'js_composer' ),
			'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
		),
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number items", "js_composer"),
         "param_name" => "num_items",
         "value" => "4",
         "description" => __("Number of items in a carousel.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number columns", "js_composer"),
         "param_name" => "columns_count",
         "value" => "3",
         "description" => __("Number columns in a carousel.","js_composer")
        ),
   
		 array(
		  "type" => "dropdown",
		  "heading" => __("Author Show", "js_composer"),
		  "param_name" => "author_show",
		  "description" => __("Select show or hide author info.", "js_composer"),
		  'value' => $show_arr
		  
		),

        array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );





//////////////////////////////vc_mylatest_campaign////////////////////////////////////////////////////////////////////////////////
function vc_mylatest_campaign_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'num_items' => '',
      'css_animation' => ''
   ), $atts ) );
 
    $width_class = '';
	$css_class =  '';
	$css_class .= $css_animation;
	$custom_class = '';
	
    $args = array(  
    'post_type' => 'campaign',  
	'orderby' => 'date',
	'order' => 'desc',
    'posts_per_page' => $num_items  
	);  
		   
	$myposts = get_posts( $args );


	
	$output  = '<!-- Banner Rotator -->
						<div class="banner-rotator '. $css_class .'">
							
							<div class="flexslider banner-rotator-flexslider">
								
								<ul class="slides">';

	$count=0;
	foreach( $myposts as $post ) :  setup_postdata($post);
			$post_id = $post->ID;
			$post_thumbnail_id = get_post_thumbnail_id($post->ID);
			//$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
			$post_thumbnail_url = wp_get_attachment_image_src( $post_thumbnail_id, 'post-full'); 
			
			$title2 = get_meta_option('campaign_text_meta_box', $post->ID);
			
			$btn_title = get_meta_option('campaign_btn_meta_box', $post->ID);
			$btn_url = get_meta_option('campaign_btn_url_meta_box', $post->ID);
			
			$campaign_date = get_meta_option('campaign_date_meta_box', $post->ID);
			
			
			
	$count++;
	$output .=  '<li id="flex_rotator_'. $count .'" style="background: transparent url(' . $post_thumbnail_url[0] . ') center center no-repeat; background-size: cover;" >
					<div class="banner-rotator-content">
						<h5>'. get_the_title($post_id) .'</h5>
						<h2>'.$title2  .'</h2>
						<span class="date campaign-date">'. $campaign_date .'</span>
						<a href="'. $btn_url .'" class="button big button-arrow">'. $btn_title .'</a>
					</div>
				</li>';

	endforeach; 	
	
	$output .=  '</div></div>';
 
   return $output;
}
add_shortcode('vc_mylatest_campaign', 'vc_mylatest_campaign_func');

vc_map( array(
   "name" => __("Home block Campaign", THEMENAME),
   "base" => "vc_mylatest_campaign",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Home block of Campaign', 'js_composer'),
   "params" => array(

		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number items", "js_composer"),
         "param_name" => "num_items",
         "value" => "4",
         "description" => __("Number of items in a carousel.","js_composer")
        ),
   
        array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );






//////////////////////////////vc_banner////////////////////////////////////////////////////////////////////////////////
function vc_banner_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'title' => '',
    'custom_color' => '',
    'background_style' => '',
    'text_banner' => '',
	'custom_link' => '',
	'custom_links_target' => '',
	'icon' => '',
	'my_style' => '',
    'css_animation' => ''
   ), $atts ) );
 
    $width_class = '';
	$css_class =  '';
	$css_class .= $css_animation;
	$custom_class = '';
	
	$custom_color1 = '';
   if($background_style == 'custom') {
	   $custom_color1 = ' style=background:'.$custom_color.' ';
	}

	
	$output  = '<div class="banner-wrapper '. $my_style .' ">
					<a class="banner '. $css_class .'" href="'. $custom_link .'" target="'. $custom_links_target .'"  '. $custom_color1 .' >
						<i class="icons '. $icon .'"></i>
						<h4>'. $title .'</h4>
						<p>'. $text_banner .'</p>
					</a>
				</div>';

   return $output;
}
add_shortcode('vc_banner', 'vc_banner_func');

vc_map( array(
   "name" => __("Home block Banner", THEMENAME),
   "base" => "vc_banner",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Home block of Banner', 'js_composer'),
   "params" => array(
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Title Banner","js_composer"),
         "description" => __("Block title.","js_composer")
        ),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Background Style', 'js_composer' ),
			'param_name' => 'background_style',
			'value' => array(
				__( 'Default', 'js_composer' ) => '',
				__( 'Custom', 'js_composer' ) => 'custom',
			),
			'description' => __( 'Background style.', 'js_composer' )
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Custom Background Color', 'js_composer' ),
			'param_name' => 'custom_color',
			'description' => __( 'Select custom color.', 'js_composer' ),
			'dependency' => array(
				'element' => 'color',
				'value' => 'custom',
			),
		),
		

		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Text Banner", "js_composer"),
         "param_name" => "text_banner",
         "value" => "Text Banner",
         "description" => __("Number of items in a carousel.","js_composer")
        ),
		array(
            "type" => "dropdown",
            "heading" => __("Select Icon", "js_composer"),
            "param_name" => "icon",
            "description" => __('Select Icon.', 'js_composer'),
            'value' => $icon_arr
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("URL Link", "js_composer"),
         "param_name" => "custom_link",
         "value" => "",
         "description" => __("URL Link.","js_composer")
        ),
		array(
            "type" => "dropdown",
            "heading" => __("Target Link", "js_composer"),
            "param_name" => "custom_links_target",
            "description" => __('Select where to open  custom links.', 'js_composer'),
            'value' => $target_arr
        ),
		
		array(
		  "type" => "dropdown",
		  "heading" => __("Style", "js_composer"),
		  "param_name" => "my_style",
		  "admin_label" => true,
		  "value" => array(__("Style1", "js_composer") => "mystyle1", __("Style2", "js_composer") => "mystyle2"),
		  "description" => __("Select style type.", "js_composer")
		),
        array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );




//////////////////////////////vc_donate////////////////////////////////////////////////////////////////////////////////
function vc_banner_donate_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'title' => '',
    'text_amount1' => '',
    'text_amount2' => '',
    'text_amount3' => '',
    'url_amount' => '',
    'org_donate' => '',
    'currency_amount' => '',
    'css_animation' => ''
   ), $atts ) );
 
 

	if ( empty( $currency_amount ) ) {
		$currency_amount = 'USD';
	}
 
 	$currency_code_symbol = homeshop_get_woocommerce_currency_symbol( $currency_amount );	 
 
 
 
    $width_class = '';
	$css_class =  '';
	$css_class .= $css_animation;
	$custom_class = '';
	
   

	
	$output  = '<div class="banner-wrapper">
					<div class="banner donate-banner '. $css_class .'">
					
						<h5>'. $title .'</h5>';
						
						
		$output  .= '<form name="_xclick" id="sd_paypalform"  action="https://www.paypal.com/uk/cgi-bin/webscr" method="post">';
						if($text_amount1 != '') {
							$output  .= '<input value="' . $text_amount1 . '" class="other_amt sd_object sd_usermod sd_radio" id="donate-amount-1" type="radio" name="sd_radio" checked>
							<label for="donate-amount-1">'. $currency_code_symbol .''. $text_amount1 .'</label>';
						}
						if($text_amount2 != '') {
							$output  .= '<input value="' . $text_amount2 . '" class="sd_object sd_usermod sd_radio" id="donate-amount-2" type="radio" name="sd_radio">
							<label for="donate-amount-2">'. $currency_code_symbol .''. $text_amount2 .'</label>';
						}	
						if($text_amount3 != '') {
							$output  .= '<input value="' . $text_amount3 . '" class="sd_object sd_usermod sd_radio" id="donate-amount-3" type="radio" name="sd_radio">
							<label for="donate-amount-3">'. $currency_code_symbol .''. $text_amount3 .'</label>';
						}	
							
							
							
			$output  .= '<input type="hidden" name="cmd" value="_donations" id="cmd"/>
							<input type="hidden" name="no_shipping" value="2"/>
							<input type="hidden" name="no_note" value="1"/>
							<input type="hidden" name="tax" value="0"/>
							<input type="hidden" name="business" value="' . esc_html( $url_amount ) . '" class="sd_object paypal_object" />
							<input type="hidden" name="bn" value="' . esc_html( $org_donate ) . '" class="sd_object paypal_object"/>
							<input type="hidden" name="currency_code" value="' . esc_html( $currency_amount ) . '" class="sd_object paypal_object"/>
							
							
							<input type="submit" name="submit"  value="' . __( "Donate", "Candidat" ) . '" class="sd_object" id="sd_submit"  >
							
							
						</form>';	
						
						
						
	$output  .= '</div>';

	//		Javascript
	$output .= '<script type="text/javascript">';
	$output .= 'jQuery(document).ready(function($){
				
				$("#sd_paypalform #sd_submit").before(\'<input type="hidden" name="amount" value="\' + $(".other_amt").val() + \'" class="sd_object paypal_object" id="paypal_amount" />\');
				
				$(".sd_object.sd_usermod").change(function() {
					$("#sd_paypalform #paypal_amount").val($(this).val()); 
				});';

	$output .= '});
		</script>';			
	
	$output  .= '</div>';

	
   return $output;
}
add_shortcode('vc_banner_donate', 'vc_banner_donate_func');





$homeshop_currency_code_options = homeshop_get_woocommerce_currencies();
foreach ( $homeshop_currency_code_options as $code => $name ) {
	$homeshop_currency_code_options[ $code ] = $name . " (" . $code . ")";
}	
$homeshop_currency_code_options = array_flip($homeshop_currency_code_options);




vc_map( array(
   "name" => __("Home block Banner Donate", THEMENAME),
   "base" => "vc_banner_donate",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Home block of Banner Donate', 'js_composer'),
   "params" => array(
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Make a <strong>quick donation</strong> here","js_composer"),
         "description" => __("Block title.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Text Amount1", "js_composer"),
         "param_name" => "text_amount1",
         "value" => "5",
         "description" => __("Text Amount1.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Text Amount2", "js_composer"),
         "param_name" => "text_amount2",
         "value" => "25",
         "description" => __("Text Amount2.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Text Amount3", "js_composer"),
         "param_name" => "text_amount3",
         "value" => "100",
         "description" => __("Text Amount3.","js_composer")
        ),
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("PayPal Email Address", "js_composer"),
         "param_name" => "url_amount",
         "value" => "",
         "description" => __("PayPal Email Address.","js_composer")
        ),
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Organization", "js_composer"),
         "param_name" => "org_donate",
         "value" => "",
         "description" => __("PayPal Email Address.","js_composer")
        ),
		
		// array(
		  // "type" => "dropdown",
		  // "heading" => __("Currency Amount", "js_composer"),
		  // "param_name" => "currency_amount",
		  // "admin_label" => true,
		  // "value" => array(__("USD", "js_composer") => 'USD', __("CHF", "js_composer") => "CHF", __("SEK", "js_composer") => "SEK", __("SGD", "js_composer") => "SGD", __("GBP", "js_composer") => "GBP", __("PLN", "js_composer") => "PLN", __("NZD", "js_composer") => "NZD", __("NOK", "js_composer") => "NOK", __("JPY", "js_composer") => "JPY", __("HUF", "js_composer") => "HUF", __("EUR", "js_composer") => "EUR", __("DKK", "js_composer") => "DKK", __("CZK", "js_composer") => "CZK", __("CAD", "js_composer") => "CAD", __("AUD", "js_composer") => "AUD"),
		  // "description" => __("Select Currency Amount.", "js_composer")
		// ),
		
		array(
		  "type" => "dropdown",
		  "heading" => __("Currency Amount", "js_composer"),
		  "param_name" => "currency_amount",
		  "admin_label" => true,
		  "value" => $homeshop_currency_code_options,
		  "description" => __("Select Currency Amount.", "js_composer")
		),
		
		
        array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );





//////////////////////////////vc_social_media////////////////////////////////////////////////////////////////////////////////
function vc_social_media1_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'title' => '',
	'custom_link1' => '',
	'custom_link2' => '',
	'custom_link3' => '',
	'custom_link4' => '',
	'custom_link5' => '',
	'custom_link6' => '',
	'custom_link7' => '',
	'social_show' => '',
	'custom_links_target' => '',
    'css_animation' => ''
   ), $atts ) );
 
    $width_class = '';
	$css_class =  '';
	$css_class .= $css_animation;
	$custom_class = '';
	

	$output  = '<div class="social-media '. $css_class .'">
					<span class="small-caption">'. $title .':</span>
					<ul class="social-icons">';
					if($custom_link1 != '' && $custom_link1 != '#' ) {
	$output  .= '<li class="facebook"><a href="'. $custom_link1 .'"  target="'. $custom_links_target .'" class="tooltip-ontop" title="Facebook"><i class="icons icon-facebook"></i></a></li>';
					}	
					if($custom_link2 != '' && $custom_link2 != '#' ) {	
	$output  .= '<li class="twitter"><a href="'. $custom_link2 .'"  target="'. $custom_links_target .'" class="tooltip-ontop" title="Twitter"><i class="icons icon-twitter"></i></a></li>';
					}	
					if($custom_link3 != '' && $custom_link3 != '#' ) {	
	$output  .= '<li class="google"><a href="'. $custom_link3 .'"  target="'. $custom_links_target .'" class="tooltip-ontop" title="Google Plus"><i class="icons icon-gplus"></i></a></li>';
					}	
					if($custom_link4 != '' && $custom_link4 != '#' ) {	
	$output  .= '<li class="youtube"><a href="'. $custom_link4 .'"  target="'. $custom_links_target .'" class="tooltip-ontop" title="Youtube"><i class="icons icon-youtube-1"></i></a></li>';
					}	
					if($custom_link5 != '' && $custom_link5 != '#' ) {	
	$output  .= '<li class="flickr"><a href="'. $custom_link5 .'"  target="'. $custom_links_target .'" class="tooltip-ontop" title="Flickr"><i class="icons icon-flickr-4"></i></a></li>';
					}	
					if($custom_link6 != '' && $custom_link6 != '#' ) {	
	$output  .= '<li class="email"><a href="'. $custom_link6 .'"  target="'. $custom_links_target .'" class="tooltip-ontop" title="Email"><i class="icons icon-mail"></i></a></li>';
					}	
					if($custom_link7 != '' && $custom_link7 != '#' ) {	
	$output  .= '<li class="linkedin"><a href="'. $custom_link7 .'"  target="'. $custom_links_target .'" class="tooltip-ontop" title="LinkedIn"><i class="icons icon-linkedin"></i></a></li>';
					}		
	$output  .= '</ul>';
					
					if($social_show != '_hide' ) {	
	$output  .= '<ul class="social-buttons">
						<li>
							<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35" style="border:none; overflow:hidden; height:21px; padding-top:1px; width:50px;"></iframe>
						</li>
						<li class="facebook-share">
							<div class="fb-share-button" data-href="'. get_permalink() .'" data-type="button_count"></div>
						</li>
						<li class="twitter-share">
							<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
						</li>
					</ul>';
					}
	$output  .= '</div>';
	

   return $output;
}
add_shortcode('vc_social_media1', 'vc_social_media1_func');


vc_map( array(
   "name" => __("Home block Social Media", THEMENAME),
   "base" => "vc_social_media1",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Home block of Social Media', 'js_composer'),
   "params" => array(
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Get connected","js_composer"),
         "description" => __("Block title.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Facebook URL Link", "js_composer"),
         "param_name" => "custom_link1",
         "value" => "",
         "description" => __("URL Link.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Twitter URL Link", "js_composer"),
         "param_name" => "custom_link2",
         "value" => "",
         "description" => __("URL Link.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Google Plus URL Link", "js_composer"),
         "param_name" => "custom_link3",
         "value" => "",
         "description" => __("URL Link.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Youtube URL Link", "js_composer"),
         "param_name" => "custom_link4",
         "value" => "",
         "description" => __("URL Link.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Flickr URL Link", "js_composer"),
         "param_name" => "custom_link5",
         "value" => "",
         "description" => __("URL Link.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Email URL Link", "js_composer"),
         "param_name" => "custom_link6",
         "value" => "",
         "description" => __("URL Link.","js_composer")
        ),

		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("LinkedIn URL Link", "js_composer"),
         "param_name" => "custom_link7",
         "value" => "",
         "description" => __("URL Link.","js_composer")
        ),
		
		
		array(
            "type" => "dropdown",
            "heading" => __("Target Link", "js_composer"),
            "param_name" => "custom_links_target",
            "description" => __('Select where to open  custom links.', 'js_composer'),
            'value' => $target_arr
        ),
        array(
		  "type" => "dropdown",
		  "heading" => __("Social Show", "js_composer"),
		  "param_name" => "social_show",
		  "description" => __("Select show or hide social buttons.", "js_composer"),
		  'value' => $show_arr
		  
		),
		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );








//////////////////////////////vc_featured-video////////////////////////////////////////////////////////////////////////////////
function vc_featured_video_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'title' => '',
	'video_link' => '',
	'custom_link' => '',
	'custom_link_text' => '',
	'custom_links_target' => '',
	'type_video' => '',
    'css_animation' => ''
   ), $atts ) );
 
    $width_class = '';
	$css_class =  '';
	$css_class .= $css_animation;
	$custom_class = '';
	

	$output  = '<!-- Featured Video -->
						<div class="sidebar-box white featured-video '. $css_class .'">
							<h3>'. $title .'</h3>';
							
					if($type_video == 'youtube') {
		$output  .= '<iframe width="560" height="315" src="//www.youtube.com/embed/'. $video_link .'?wmode=transparent" allowfullscreen></iframe>';
					}		
					if($type_video == 'vimeo') {
		$output  .= '<iframe width="560" height="315" src="http://player.vimeo.com/video/'. $video_link .'?js_api=1&amp;js_onLoad=player'. $video_link .'_1798970533.player.moogaloopLoaded" allowfullscreen></iframe>';
					}			
					if($type_video == 'html5') {
		$output  .= '<video width="100%" height="115"  id="home_video_featured" class="entry-video video-js vjs-default-skin" poster="" data-aspect-ratio="2.41" data-setup="{}" controls>
		<source src="'. $video_link .'.mp4" type="video/mp4"/>
	<source src="'. $video_link .'.webm" type="video/webm"/>
	<source src="'. $video_link .'.ogg" type="video/ogg"/></video>';
					}			
							
	$output  .= '<a href="'. $custom_link .'" target="'. $custom_links_target .'" class="button transparent button-arrow">'. $custom_link_text .'</a>
	
						</div>
						<!-- /Featured Video -->';
	

   return $output;
}
add_shortcode('vc_featured_video', 'vc_featured_video_func');


vc_map( array(
   "name" => __("Home block Featured Video", THEMENAME),
   "base" => "vc_featured_video",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Home block of Featured Video', 'js_composer'),
   "params" => array(
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Featured Video","js_composer"),
         "description" => __("Block title.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Video URL ID", "js_composer"),
         "param_name" => "video_link",
         "value" => "",
         "description" => __("URL Video.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("More Videos URL", "js_composer"),
         "param_name" => "custom_link",
         "value" => "",
         "description" => __("URL Link.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("More Videos Text", "js_composer"),
         "param_name" => "custom_link_text",
         "value" => "",
         "description" => __("Text Link.","js_composer")
        ),		
		array(
            "type" => "dropdown",
            "heading" => __("Target Link", "js_composer"),
            "param_name" => "custom_links_target",
            "description" => __('Select where to open  custom links.', 'js_composer'),
            'value' => $target_arr
        ),
		
		array(
            "type" => "dropdown",
            "heading" => __("Type Video", "js_composer"),
            "param_name" => "type_video",
            "description" => __('Select type video.', 'js_composer'),
            "value" => array(__("Youtube", "js_composer") => "youtube", __("Vimeo", "js_composer") => "vimeo", __("HTML5", "js_composer") => "html5")
        ),
		
		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );





//////////////////////////////vc_upcoming_events////////////////////////////////////////////////////////////////////////////////
function vc_upcoming_events_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'title' => '',
    'limit' => '',
	'custom_link' => '',
	'custom_link_text' => '',
	'custom_links_target' => '',
    'css_animation' => ''
   ), $atts ) );
 
    $width_class = '';
	$css_class =  '';
	$css_class .= $css_animation;
	$custom_class = '';
	
	

	$myposts = tribe_get_events(
			apply_filters(
				'tribe_events_list_widget_query_args', array(
					'eventDisplay'   => 'list',
					'posts_per_page' => $limit
				)
			)
		);
	
	
	$output  = '<!-- Upcoming Events -->
						<div class="sidebar-box white '. $css_class .'">
							<h3>'. $title .'</h3>
							<ul class="upcoming-events">';
	
		foreach( $myposts as $post ) :  setup_postdata($post);
			setup_postdata( $post );
			$event_id = $post->ID;
			
			
			
			
			$type_event = get_meta_option('events_type_meta_box');
			$time_format = get_option( 'time_format', TribeDateUtils::TIMEFORMAT );
			$time_range_separator = tribe_get_option('timeRangeSeparator', ' - ');

			$start_date = tribe_get_start_date( $event_id );
			$end_date = tribe_get_end_date( $event_id );
			
			$address = tribe_address_exists($event_id) ? '' . tribe_get_full_address($event_id) . '' : '';
			
			$start_day = tribe_get_start_date( $event_id, false, 'd' );
		    $start_month = tribe_get_start_date( $event_id, false, 'M' );
		
			
			
	$output  .= '<!-- Event -->
								<li>
									<div class="date">
										<span>
											<span class="day">'. $start_day .'</span>
											<span class="month">'. $start_month .'</span>
										</span>
									</div>
									
									<div class="event-content">
										<h6><a href="'. get_permalink($event_id) .'">'. get_the_title($event_id) .'</a></h6>
										<ul class="event-meta">
											<li><i class="icons icon-clock"></i> '. $start_date .'-'. $end_date .'</li>
											<li><i class="icons icon-location"></i> '. $address .'</li>
										</ul>
									</div>
								</li>
								<!-- /Event -->';		
			
	
		endforeach; 	
	
	wp_reset_query();
	
	$output  .= '</ul>
							<a href="'. $custom_link .'" target="'. $custom_links_target .'"  class="button transparent button-arrow">'. $custom_link_text .'</a>
						</div>
						<!-- /Upcoming Events -->';
	
	

   return $output;
}
add_shortcode('vc_upcoming_events', 'vc_upcoming_events_func');


vc_map( array(
   "name" => __("Home block Upcoming Events", THEMENAME),
   "base" => "vc_upcoming_events",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Home block of Upcoming Events', 'js_composer'),
   "params" => array(
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Upcoming Events","js_composer"),
         "description" => __("Block title.","js_composer")
        ),
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Limit", "js_composer"),
         "param_name" => "limit",
         "value" => 2,
         "description" => __("Events limit.","js_composer")
        ),
		
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("More Events URL", "js_composer"),
         "param_name" => "custom_link",
         "value" => "",
         "description" => __("URL Link.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("More Events Text", "js_composer"),
         "param_name" => "custom_link_text",
         "value" => "More Events",
         "description" => __("Text Link.","js_composer")
        ),		
		array(
            "type" => "dropdown",
            "heading" => __("Target Link", "js_composer"),
            "param_name" => "custom_links_target",
            "description" => __('Select where to open  custom links.', 'js_composer'),
            'value' => $target_arr
        ),

		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );








//////////////////////////////vc_main_issues////////////////////////////////////////////////////////////////////////////////
function vc_main_issues_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'title' => '',
	'custom_image' => '',
	'custom_link' => '',
	'custom_link_text' => '',
	'custom_links_target' => '',
    'css_animation' => ''
   ), $atts ) );
 
    $width_class = '';
	$css_class =  '';
	$css_class .= $css_animation;
	$custom_class = '';
	
	$img_id = preg_replace('/[^\d]/', '', $custom_image);
	$img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => '232x137' ));

	
	
	$output  = '<!-- Image Banner -->
				<div class="sidebar-box image-banner '. $css_class .'">
					<a target="'. $custom_links_target .'"  href="'. $custom_link .'">
						'. $img['thumbnail'] .'
						<h3>'. $title .'</h3>
						<span class="button transparent button-arrow">'. $custom_link_text .'</span>
					</a>
				</div>
				<!-- /Image Banner -->';
	

	
	

   return $output;
}
add_shortcode('vc_main_issues', 'vc_main_issues_func');


vc_map( array(
   "name" => __("Home block Main Issues", THEMENAME),
   "base" => "vc_main_issues",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Home block of Main Issues', 'js_composer'),
   "params" => array(
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("The main issues","js_composer"),
         "description" => __("Block title.","js_composer")
        ),
		
		array(
         "type" => "attach_image",
         "holder" => "div",
         "class" => "",
         "heading" => __("Image", "js_composer"),
         "param_name" => "custom_image",
         "description" => __("Select image from media library.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Btn More URL", "js_composer"),
         "param_name" => "custom_link",
         "value" => "",
         "description" => __("URL Link.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Btn More Text", "js_composer"),
         "param_name" => "custom_link_text",
         "value" => "Find out more",
         "description" => __("Text Link.","js_composer")
        ),		
		array(
            "type" => "dropdown",
            "heading" => __("Target Link", "js_composer"),
            "param_name" => "custom_links_target",
            "description" => __('Select where to open  custom links.', 'js_composer'),
            'value' => $target_arr
        ),

		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );







//////////////////////////////vc_widget_popular_news////////////////////////////////////////////////////////////////////////////////
function vc_mypopular_news_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'title' => '',
      'num_items' => '',
      'css_animation' => ''
   ), $atts ) );
 
    $width_class = '';
	$css_class =  '';
	$css_class .= $css_animation;
	$custom_class = '';
	
    $args = array(  
    'post_type' => 'post',  
	'orderby' => 'date',
	'order' => 'desc',
    'posts_per_page' => $num_items  
	);  
		   
	$myposts = get_posts( $args );


	
	$output  = '<!-- Popular News -->
						<div class="sidebar-box white '. $css_class .'">
							<h3>'. $title .'</h3>
							<ul class="popular-news">';


	$count=0;
	foreach( $myposts as $post ) :  setup_postdata($post);
			$post_id = $post->ID;
			$post_thumbnail_id = get_post_thumbnail_id($post->ID);
			//$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
			$post_thumbnail_url = wp_get_attachment_image_src( $post_thumbnail_id, 'th-sidebar'); 

	$count++;
	$output .=  '<li>
					<div class="thumbnail">
						<img src="' . $post_thumbnail_url[0] . '" alt="">
					</div>
					
					<div class="post-content">
						<h6><a href="'. get_permalink($post_id) .'">'. get_the_title($post_id) .'</a></h6>
						<div class="post-meta">
							<span>by <a href="'. get_author_posts_url( get_the_author_meta( 'ID' ) ) .'">'. get_the_author() .'</a></span>
							<span>'. get_the_time('F j, Y g:i a', $post_id) .'</span>
						</div>
					</div>
				</li>';

	endforeach; 	
	
	$output .=  '</ul></div><!-- /Popular News -->';
 
   return $output;
}
add_shortcode('vc_mypopular_news', 'vc_mypopular_news_func');

vc_map( array(
   "name" => __("Popular news", THEMENAME),
   "base" => "vc_mypopular_news",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Block of Popular news', 'js_composer'),
   "params" => array(

		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Popular news","js_composer"),
         "description" => __("Block title.","js_composer")
        ),
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number items", "js_composer"),
         "param_name" => "num_items",
         "value" => "4",
         "description" => __("Number of items in a carousel.","js_composer")
        ),
   
        array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );











//////////////////////////////vc_mybuttons////////////////////////////////////////////////////////////////////////////////
function vc_mybuttons_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'title' => '',
	'custom_link' => '',
	'custom_links_target' => '',
	'btn_arr' => '',
	'btn_size' => '',
	'btn_type' => '',
    'css_animation' => ''
   ), $atts ) );
 
	$css_class =  'mycustom_button button ';
	$css_class .= $css_animation." ";
	$css_class .= $btn_type." ";
	$css_class .= $btn_size." ";
	$css_class .= $btn_arr." ";

	$output  = '<a target="'. $custom_links_target .'" href="'. $custom_link .'" class=" '. $css_class .'">'. $title .'</a>';

   return $output;
}
add_shortcode('vc_mybuttons', 'vc_mybuttons_func');


vc_map( array(
   "name" => __("Custom Buttons", THEMENAME),
   "base" => "vc_mybuttons",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Block of Custom Buttons', 'js_composer'),
   "params" => array(
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Button","js_composer"),
         "description" => __("Block title.","js_composer")
        ),

		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Btn More URL", "js_composer"),
         "param_name" => "custom_link",
         "value" => "",
         "description" => __("URL Link.","js_composer")
        ),
		
		array(
            "type" => "dropdown",
            "heading" => __("Target Link", "js_composer"),
            "param_name" => "custom_links_target",
            "description" => __('Select where to open  custom links.', 'js_composer'),
            'value' => $target_arr
        ),

		array(
		  "type" => "dropdown",
		  "heading" => __("Button Arrow", "js_composer"),
		  "param_name" => "btn_arr",
		  "value" => array(__("No", "js_composer") => '', __("With Arrow", "js_composer") => "button-arrow"),
		  "description" => __("Select arrow.", "js_composer")
		),
		
		array(
		  "type" => "dropdown",
		  "heading" => __("Button Size", "js_composer"),
		  "param_name" => "btn_size",
		   "description" => __("Select button size.", "js_composer"),
		  "value" => $btn_size
		),
		
		array(
		  "type" => "dropdown",
		  "heading" => __("Button Type", "js_composer"),
		  "param_name" => "btn_type",
		  "value" => array(__("Normal", "js_composer") => '', __("Donate", "js_composer") => "donate"),
		  "description" => __("Select button type.", "js_composer")
		),
		
		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );







//////////////////////////////vc_mylists////////////////////////////////////////////////////////////////////////////////
function vc_mylists_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'type_list' => '',
    'custom_links' => '',
    'css_animation' => ''
   ), $atts ) );
 
	$css_class =  'list ';
	$css_class .= $type_list." ";
	$css_class .= $css_animation." ";
	
	$custom_links = explode( ',', $custom_links); 
	
	if($type_list == 'ordered-list') {  
	$output  = '<ol class=" '. $css_class .'">';
	} else {
	$output  = '<ul class=" '. $css_class .'">';
	}
	
	$i = 0;

	
	while ($i<count($custom_links))
	{
		$output  .= '<li>'. $custom_links[$i] .'</li>';
		$i++;
	}
	
	
	if($type_list == 'ordered-list') {  
	$output  .= '</ol>';
	} else {
	$output  .= '</ul>';
	}
	

   return $output;
}
add_shortcode('vc_mylists', 'vc_mylists_func');


vc_map( array(
   "name" => __("Custom Lists", THEMENAME),
   "base" => "vc_mylists",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Block of Custom List', 'js_composer'),
   "params" => array(

		array(
		  "type" => "dropdown",
		  "heading" => __("Type List", "js_composer"),
		  "param_name" => "type_list",
		  "value" => array(__("Arrow List", "js_composer") => "arrow-list", __("Check List", "js_composer") => "check-list", __("Star List", "js_composer") => "star-list", __("Plus List", "js_composer") => "plus-list", __("Finger List", "js_composer") => "finger-list", __("Ordered List", "js_composer") => "ordered-list"),
		  "description" => __("Select Type.", "js_composer")
		),
   
		array(
            "type" => "exploded_textarea",
            "heading" => __("Custom list", "js_composer"),
            "param_name" => "custom_links",
            "description" => __('Enter text for each list. Divide text with linebreaks (,).', 'js_composer')
        ),
		
		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );








//////////////////////////////vc_mybloquotes////////////////////////////////////////////////////////////////////////////////
function vc_mybloquotes_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'type_list' => '',
    'custom_text' => '',
    'css_animation' => ''
   ), $atts ) );
 
	$css_class =  '';
	$css_class .= $type_list." ";
	$css_class .= $css_animation." ";

	$output  = '<blockquote class="'. $css_class .'">"'. $custom_text .'"</blockquote>';

   return $output;
}
add_shortcode('vc_mybloquotes', 'vc_mybloquotes_func');


vc_map( array(
   "name" => __("Custom Bloquotes", THEMENAME),
   "base" => "vc_mybloquotes",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Block of Custom List', 'js_composer'),
   "params" => array(

		array(
		  "type" => "dropdown",
		  "heading" => __("Type Bloquote", "js_composer"),
		  "param_name" => "type_list",
		  "value" => array(__("Type1", "js_composer") => "", __("Type2", "js_composer") => "iconic-quote"),
		  "description" => __("Select Type Bloquote.", "js_composer")
		),
   

		array(  
	        "type" => "textarea",
			"holder" => "div",
			"heading" => __("Text", "js_composer"),
			"param_name" => "custom_text",
			"value" => '',
			"description" => __("Enter your content.", "js_composer")
		),    
		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );









//////////////////////////////vc_widget_mytestimonials////////////////////////////////////////////////////////////////////////////////
function vc_mytestimonials_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
      'num_items' => '',
      'css_animation' => ''
   ), $atts ) );
 
	$css_class =  '';
	$css_class .= $css_animation;
	
    $args = array(  
    'post_type' => 'testimonial',  
	'orderby' => 'post_date',
	'order' => 'DESC',
    'posts_per_page' => $num_items,
	'post_status'     => 'publish'	
	);  
		   
	$myposts = get_posts( $args );


	
	$output  = '<!-- Owl Carousel -->
						<div class="owl-carousel-container testimonial-carousel '. $css_class .'">
							<div class="owl-carousel" data-max-items="1">';
	
		$count=0;
		foreach( $myposts as $post ) :  setup_postdata($post);
				$des = get_the_content();
				$address = get_meta_option('address_testimonial_meta_box', $post->ID);
				$title1 = get_the_title($post->ID);
				$thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'th-sidebar'); 
				$count++;
	
			$output  .= '<!-- Owl Item -->
								<div>
									
									<!-- Testimonial -->
									<div class="testimonial">
							
										<div class="testimonial-content">
											<p>'. $des .'</p>
										</div>
										
										<div class="testimonial-author">
											<img src="'. $thumb_image_url[0] .'" alt="">
											<div class="author-meta">
												<span class="name">'. $title1 .',</span>
												<span class="location">'. $address .'</span>
											</div>
										</div>
										
									</div>
									<!-- /Testimonial -->
								</div>';
		
		
		endforeach; 	
	
	$output  .= '</div>';
		if($num_items != '1') {					
	$output  .= '<div class="owl-header">
								
								<div class="carousel-arrows">
									<span class="left-arrow"><i class="icons icon-left-dir"></i></span>
									<span class="right-arrow"><i class="icons icon-right-dir"></i></span>
								</div>
								
							</div>';
			}		
	$output  .= '</div>
						<!-- /Owl Carousel -->';
	
	
 
   return $output;
}
add_shortcode('vc_mytestimonials', 'vc_mytestimonials_func');

vc_map( array(
   "name" => __("Testimonials", THEMENAME),
   "base" => "vc_mytestimonials",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Block of Testimonials', 'js_composer'),
   "params" => array(

		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number items", "js_composer"),
         "param_name" => "num_items",
         "value" => "4",
         "description" => __("Number of items in a carousel.","js_composer")
        ),
   
        array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );







//////////////////////////////vc_myalertbox////////////////////////////////////////////////////////////////////////////////
function vc_myalertbox_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'type_list' => '',
    'custom_text' => '',
    'css_animation' => ''
   ), $atts ) );
 
	$css_class =  '';
	$css_class .= $type_list." ";
	$css_class .= $css_animation." ";

	$output  = '<div class="alert-box '. $css_class .'">
							<p>'. $custom_text .'</p>
							<i class="icons icon-cancel-circle-1"></i>
						</div>';

   return $output;
}
add_shortcode('vc_myalertbox', 'vc_myalertbox_func');


vc_map( array(
   "name" => __("Custom Alert", THEMENAME),
   "base" => "vc_myalertbox",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Block of Custom Alert', 'js_composer'),
   "params" => array(

		array(
		  "type" => "dropdown",
		  "heading" => __("Type Alert", "js_composer"),
		  "param_name" => "type_list",
		  "value" => array(__("Warning", "js_composer") => "warning", __("Error", "js_composer") => "error", __("Success", "js_composer") => "success", __("Info", "js_composer") => "info"),
		  "description" => __("Select Type Alert.", "js_composer")
		),
   

		array(  
	        "type" => "textarea",
			"holder" => "div",
			"heading" => __("Text", "js_composer"),
			"param_name" => "custom_text",
			"value" => '',
			"description" => __("Enter your content.", "js_composer")
		),    
		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );





//////////////////////////////vc_mypagination////////////////////////////////////////////////////////////////////////////////
function vc_mypagination_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'type_list' => '',
    'css_animation' => ''
   ), $atts ) );
 
	$css_class =  '';
	$css_class .= $css_animation." ";

	
	if($type_list == 'numeric') {
	$output  = '<div class="numeric-pagination '. $css_class .'">
							<a href="#" class="button"><i class="icons icon-left-dir"></i></a>
							<a href="#" class="button">1</a>
							<a href="#" class="button">2</a>
							<a href="#" class="button">3</a>
							<a href="#" class="button"><i class="icons icon-right-dir"></i></a>
						</div>';
	} else {
	$output  = '<div class="button-pagination '. $css_class .'">
							<a href="#" class="button big previous">Prev post</a>
							<a href="#" class="button big next">Next post</a>
						</div>';
	}
	

   return $output;
}
add_shortcode('vc_mypagination', 'vc_mypagination_func');


vc_map( array(
   "name" => __("Custom Pagination", THEMENAME),
   "base" => "vc_mypagination",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Block of Custom Pagination', 'js_composer'),
   "params" => array(

		array(
		  "type" => "dropdown",
		  "heading" => __("Type Pagination", "js_composer"),
		  "param_name" => "type_list",
		  "value" => array(__("Numeric", "js_composer") => "numeric", __("Button", "js_composer") => "button"),
		  "description" => __("Select Type Pagination.", "js_composer")
		),
   
		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );







//////////////////////////////vc_mydropcaps////////////////////////////////////////////////////////////////////////////////
function vc_mydropcaps_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'type_dropcaps' => '',
    'custom_text' => '',
    'css_animation' => ''
   ), $atts ) );
 
	$css_class =  '';
	$css_class .= $type_dropcaps." ";
	$css_class .= $css_animation." ";

	$output  = '<span class="dropcap  '. $css_class .'">'. $custom_text .'</span>';

   return $output;
}
add_shortcode('vc_mydropcaps', 'vc_mydropcaps_func');


vc_map( array(
   "name" => __("Custom Dropcaps", THEMENAME),
   "base" => "vc_mydropcaps",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Block of Custom Dropcaps', 'js_composer'),
   "params" => array(

		array(
		  "type" => "dropdown",
		  "heading" => __("Type Dropcaps", "js_composer"),
		  "param_name" => "type_dropcaps",
		  "value" => array(__("Normal", "js_composer") => "", __("Blue", "js_composer") => "blue", __("Squared", "js_composer") => "squared", __("Squared Blue", "js_composer") => "squared blue"),
		  "description" => __("Select Type Dropcaps.", "js_composer")
		),
   

		array(  
	        "type" => "textarea",
			"holder" => "div",
			"heading" => __("Text", "js_composer"),
			"param_name" => "custom_text",
			"value" => '',
			"description" => __("Enter your content.", "js_composer")
		),    
		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );





//////////////////////////////vc_mytooltip////////////////////////////////////////////////////////////////////////////////
function vc_mytooltip_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'title' => '',
    'type_tooltip' => '',
    'custom_text' => '',
    'css_animation' => ''
   ), $atts ) );
 
	$css_class =  '';
	$css_class .= $type_tooltip." ";
	$css_class .= $css_animation." ";

	$output  = '<a href="#" title="'. $custom_text .'" class="mytooltip '. $css_class .'"  style="float: left;" >'. $title .'</a>';

   return $output;
}
add_shortcode('vc_mytooltip', 'vc_mytooltip_func');


vc_map( array(
   "name" => __("Custom Tooltip", THEMENAME),
   "base" => "vc_mytooltip",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Block of Custom Tooltip', 'js_composer'),
   "params" => array(

		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Tooltip","js_composer"),
         "description" => __("Block title.","js_composer")
        ),
		
		array(
		  "type" => "dropdown",
		  "heading" => __("Type Tooltip", "js_composer"),
		  "param_name" => "type_tooltip",
		  "value" => array(__("Top", "js_composer") => "tooltip-ontop", __("Bottom", "js_composer") => "tooltip-onbottom", __("Left", "js_composer") => "tooltip-onleft", __("Right", "js_composer") => "tooltip-onright"),
		  "description" => __("Select Type Tooltip.", "js_composer")
		),
   

		array(  
	        "type" => "textarea",
			"holder" => "div",
			"heading" => __("Text", "js_composer"),
			"param_name" => "custom_text",
			"value" => 'Text Tooltip',
			"description" => __("Enter your content.", "js_composer")
		),    
		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );






//////////////////////////////vc_myaudio////////////////////////////////////////////////////////////////////////////////
function vc_myaudio_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'title' => '',
    'custom_text' => '',
    'css_animation' => ''
   ), $atts ) );
 
	$css_class =  '';
	$css_class .= $css_animation." ";

	$output  = '<audio class="volume-on custom_audio '. $css_class .'">
							<source src="'. $custom_text .'" type="audio/mpeg">
							<source src="'. $custom_text .'" type="audio/ogg">
							Your browser does not support the audio element.
						</audio><h6>'. $title .'</h6>';

   return $output;
}
add_shortcode('vc_myaudio', 'vc_myaudio_func');


vc_map( array(
   "name" => __("Custom Audio", THEMENAME),
   "base" => "vc_myaudio",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Block of Custom Audio', 'js_composer'),
   "params" => array(

		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Audio","js_composer"),
         "description" => __("Block title.","js_composer")
        ),

		array(  
	        "type" => "textfield",
			"holder" => "div",
			 "class" => "",
			"heading" => __("URL Audio", "js_composer"),
			"param_name" => "custom_text",
			"value" => '',
			"description" => __("Enter your URL Audio.", "js_composer")
		),    
		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );







//////////////////////////////vc_mylightbox////////////////////////////////////////////////////////////////////////////////
function vc_mylightbox_func( $atts, $content = null ) { // New function parameter $content is added!
	$output = $image = $img_size = $title = $title_url = $css_animation = '';
   extract( shortcode_atts( array(
    'title' => '',
    'title_url' => '',
	'image' => $image,
    'css_animation' => ''
   ), $atts ) );
 
	$css_class =  '';
	$css_class .= $css_animation." ";

	$img_id = preg_replace( '/[^\d]/', '', $image );
	$img = wpb_getImageBySize( array( 'attach_id' => $img_id, 'thumb_size' => 'thumbnail', 'class' => '' ) );
	if ( $img == NULL ) $img['thumbnail'] = '<img class="" src="' . vc_asset_url( 'vc/no_image.png' ) . '" />'; 
	
	$link_to_img = wp_get_attachment_image_src( $img_id, 'latest-post' );
	$link_to_img = $link_to_img[0];
	
	$link_to = wp_get_attachment_image_src( $img_id, 'large' );
	$link_to = $link_to[0];
	
	$output  = '<div class="media-item gallery-item no-margin-bottom  '. $css_class .'">
									<img src="' . $link_to_img . '" alt="">
									<div class="media-hover">
										<div class="media-icons">
											<a href="' . $link_to . '" data-group="media-jackbox" class="jackbox media-icon"><i class="icons icon-eye"></i></a>
											<a href="'. $title_url .'" class="media-icon"><i class="icons icon-link"></i></a>
										</div>
									</div>
								</div><h6>'. $title .'</h6>';

   return $output;
}
add_shortcode('vc_mylightbox', 'vc_mylightbox_func');


vc_map( array(
   "name" => __("Custom LightBox", THEMENAME),
   "base" => "vc_mylightbox",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Block of Custom LightBox', 'js_composer'),
   "params" => array(

		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("LightBox","js_composer"),
         "description" => __("Block title.","js_composer")
        ),

		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("URL", "js_composer"),
         "param_name" => "title_url",
         "value" => "",
         "description" => __("Block URL.","js_composer")
        ),
		
		array(
			'type' => 'attach_image',
			'heading' => __( 'Image', 'js_composer' ),
			'param_name' => 'image',
			'value' => '',
			'description' => __( 'Select image from media library.', 'js_composer' )
		),
		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );



//////////////////////////////vc_toptitle////////////////////////////////////////////////////////////////////////////////
function vc_toptitle_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'title' => '',
    'css_animation' => ''
   ), $atts ) );
 
	$css_class =  '';
	$css_class .= $css_animation;

	$output  = '<h3 class="no-margin-top '. $css_class .'" >'. $title .'</h3>';

   return $output;
}
add_shortcode('vc_toptitle', 'vc_toptitle_func');


vc_map( array(
   "name" => __("Custom Top Title", THEMENAME),
   "base" => "vc_toptitle",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Block of Custom Top Title', 'js_composer'),
   "params" => array(

		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => __("Title","js_composer"),
         "description" => __("Block title.","js_composer")
        ),
		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );





//////////////////////////////vc_type_issues////////////////////////////////////////////////////////////////////////////////
function vc_type_issues_func( $atts, $content = null ) { // New function parameter $content is added!
   extract( shortcode_atts( array(
    'title' => '',
	'icon' => '',
	'number' => '',
    'css_animation' => ''
   ), $atts ) );
 
	$css_class =  '';
	$css_class .= $css_animation;

	global $post;
	$tmp_post = $post;
	
	$args = array('numberposts'=> $number, 'post_type'=>'issues');
	$myposts = get_posts($args);
	$output = '';
	$output .= '<div class="row">';
		
	$setting1 = array();
	$setting1['options'] = candidat_custom_fontello_classes();
		
		foreach( $myposts as $post ) : setup_postdata($post);
			global $post;
			$des = get_the_excerpt();
			$des = candidat_the_excerpt_max_charlength_text($des, 17);
			$ico = get_meta_option('issues_icon_meta_box');
			$ico = $setting1['options'][$ico];
			
		
		
		$output .= '<div class="col-lg-4 col-md-4 col-sm-12 '. $css_class .'">
								
				<div class="issue-block">';
		if($icon == 'true') {			
		$output .= '<div class="issue-icon">
						<i class="icons '. $ico .'"></i>
					</div>';
		} else {			
		$output .= '<div class="issue-image">';
		$output .=	get_the_post_thumbnail($post->ID, 'post-blog');	
		$output .= '</div>';
		}		
		$output .= '<div class="issue-content">
					
						<h4>'. get_the_title($post->ID) .' </h4>
						<p>'. $des .'</p>
						
						<a class="button big button-arrow" href="'. get_permalink() .'">'. __('Read more', THEMENAME) .'</a>
					
					</div>
					
				</div>
				
			</div>';

				endforeach; 
		$output .= '</div>';
	
	
	
	$post = $tmp_post; 
	return $output;	

}
add_shortcode('vc_type_issues', 'vc_type_issues_func');


vc_map( array(
   "name" => __("Custom block Issues", THEMENAME),
   "base" => "vc_type_issues",
    "wrapper_class" => "clearfix",
	"category" => __('Content', THEMENAME),
	"description" => __('Custom block of Issues', 'js_composer'),
   "params" => array(
		
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title", "js_composer"),
         "param_name" => "title",
         "value" => "",
         "description" => __("Block title.","js_composer")
        ),
		array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Number items", "js_composer"),
         "param_name" => "number",
         "value" => "3",
         "description" => __("Number items.","js_composer")
        ),
		array(
            "type" => "dropdown",
            "heading" => __("Type", "js_composer"),
            "param_name" => "icon",
            "description" => __('Select type.', 'js_composer'),
            'value' => array(__("Icon", "js_composer") => 'true', __("Image", "js_composer") => "false")
        ),

		array(
		  "type" => "dropdown",
		  "heading" => __("CSS Animation", "js_composer"),
		  "param_name" => "css_animation",
		  "admin_label" => true,
		  "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
		  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
		)

   )
) );
















//////////////custom param///////////////////////////////////////////////////////////////////////
function homeshop_post_category_settings_field($param, $param_value) {
   $dependency = vc_generate_dependencies_attributes($param);
   

				$entries = get_categories('title_li=&orderby=name&hide_empty=0&taxonomy=category');
				$param_line = '';
				$param_line .= '<select name="'.$param['param_name'].'" class="wpb_vc_param_value dropdown wpb-input wpb-select '.$param['param_name'].' '.$param['type'].'">';
                
				foreach($entries as $key => $entry) {
                    $selected = '';
                    if ( $entry->term_id == $param_value ) $selected = ' selected="selected"';
                    $sidebar_name = $entry->name;
                    $param_line .= '<option value="'.$entry->term_id.'"'.$selected.'>'.$sidebar_name.'</option>';
                }
                $param_line .= '</select>';
        
   
    return $param_line;
}
add_shortcode_param('post_category', 'homeshop_post_category_settings_field');

function homeshop_category_settings_field($param, $param_value) {
   $dependency = vc_generate_dependencies_attributes($param);
   

				$entries = get_categories('title_li=&orderby=name&hide_empty=0&taxonomy=product_cat');
				$param_line = '';
				$param_line .= '<select name="'.$param['param_name'].'" class="wpb_vc_param_value dropdown wpb-input wpb-select '.$param['param_name'].' '.$param['type'].'">';
                
				foreach($entries as $key => $entry) {
                    $selected = '';
                    if ( $entry->term_id == $param_value ) $selected = ' selected="selected"';
                    $sidebar_name = $entry->name;
                    $param_line .= '<option value="'.$entry->term_id.'"'.$selected.'>'.$sidebar_name.'</option>';
                }
                $param_line .= '</select>';
        
   
    return $param_line;
}
add_shortcode_param('my_category', 'homeshop_category_settings_field');




function homeshop_contact_form_field($param, $param_value) {
    $dependency = vc_generate_dependencies_attributes($param);
   
    $param_line = '';
	$param_line .= '<div class="cf_wrapper">';
	$param_line .= '<input name="'.$param['param_name'].'" class="val wpb_vc_param_value wpb-textinput '.$param['param_name'].' '.$param['type'].'" type="hidden" value="'.$param_value.'"/>';
	$param_line .= '<ul class="contact_fields"></ul>
					<div class="form">
						<label for="lb" style="width: 60px;float: left;">Label</label> <input id="lb" type="text" class="label" style="width: 200px; margin-bottom: 4px;" /><br>
						<label for="nm" style="width: 60px;float: left;">Name</label> <input id="nm" type="text" class="name" style="width: 200px; margin-bottom: 4px;" />
						<input type="button" class="add_cf_row" value="add new field"/>
					 </div>';
	$param_line .=  '<script> var builder = new cf_builder({"container": ".cf_wrapper"}); builder.init('.$param_value.');</script>';
	$param_line .= '</div>';
   

    return $param_line;
}
add_shortcode_param('contact_form', 'homeshop_contact_form_field');










/* remove
---------------------------------------------------------- */
vc_remove_element("vc_toggle");
vc_remove_element("vc_gallery");
vc_remove_element("vc_teaser_grid");
vc_remove_element("vc_posts_slider");
vc_remove_element("vc_pie");








 ?>