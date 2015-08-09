<?php


/*-----------------------------------------------------------------------------------*/
/*Add scripts and styles to backend
/*-----------------------------------------------------------------------------------*/

function candidat_options_scripts($hook) {
	$template_url = get_template_directory_uri();

	wp_register_script( 'candidate-upload', $template_url . '/admin/js/upload_media.js', array( 'jquery', 'media-upload', 'thickbox' ), '', true );

 
  
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
	
	wp_enqueue_style( 'wp-color-picker');
    wp_enqueue_script( 'wp-color-picker');
	
	
	
	
	
	
	if ($hook == 'appearance_page_siteoptions' ) {
		wp_enqueue_script( 'thickbox', '', array( 'jquery' ), '', true );
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_script( 'media-upload', '', array( 'jquery' ), '', true );
		wp_enqueue_script( 'candidate-upload', '', array( 'jquery' ), '', true );
		wp_localize_script( 'candidate-upload', 'candidate', array( 'template_url'=> $template_url));
		wp_enqueue_script( 'admin-js', $template_url . '/admin/js/admin.js', array( 'jquery',  'jquery-ui-dialog' ), '', true);
		wp_enqueue_script( 'jquery_cookie', $template_url . '/js/jquery.cookie.js', array( 'jquery' ), '1.0', true );
		
		wp_enqueue_style( 'admin', $template_url . '/admin/css/admin_options.css' );
		wp_enqueue_style( 'modal', $template_url . '/admin/css/jquery-ui.css' );
		wp_enqueue_script( 'blogscripts-js', $template_url . '/admin/js/blog_scripts.js', array( 'jquery' ), '', true);
	}
	
	wp_enqueue_style( 'admin-custom', $template_url . '/admin/admin_style.css' );
   
	if ($hook == 'edit-tags.php') {
	wp_enqueue_script( 'jquery-ui-widget', '', array( 'jquery' ), '', true );
	}
		
    wp_enqueue_script( 'jquery-ui-core', '', array( 'jquery' ), '', true);
    wp_enqueue_script( 'jquery-ui-sortable', '', array( 'jquery' ), '', true );
	wp_enqueue_script( 'modernizr', $template_url . '/admin/js/modernizr.custom.js', array( 'jquery', '', true ));

	if ($hook == 'post.php' ) {
	wp_enqueue_script( 'blogscripts-js', $template_url . '/admin/js/blog_scripts.js', array( 'jquery' ), '', true);
	}
}

add_action( 'admin_enqueue_scripts', 'candidat_options_scripts' );

if ( !function_exists( 'candidat_is_login_page' ) ) {

	function candidat_is_login_page() {
		return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
	}
}


//load fonts
function candidate_fonts() {
    $protocol = is_ssl() ? 'https' : 'http';

    wp_enqueue_style( 'OpenSans', $protocol . '://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,300,400,600,700,800' );
    wp_enqueue_style( 'GreatVibes', $protocol . '://fonts.googleapis.com/css?family=Great+Vibes' );

   
   
	if(get_option('sense_logo_font_family') != '' && get_option('sense_logo_font_family') != 'Open Sans') {
			wp_enqueue_style( 'candidat-logofonts', "$protocol://fonts.googleapis.com/css?family=".get_option('sense_logo_font_family')."" );
		}
		
	if(get_option('sense_menu_font') != '' && get_option('sense_menu_font') != 'Open Sans') {
			wp_enqueue_style( 'candidat-menu', "$protocol://fonts.googleapis.com/css?family=".get_option('sense_menu_font')."" );
		}	
	if(get_option('sense_page_title_font') != '' && get_option('sense_page_title_font') != 'Open Sans') {
			wp_enqueue_style( 'candidat-pagetitle', "$protocol://fonts.googleapis.com/css?family=".get_option('sense_page_title_font')."" );
		}	
	if(get_option('sense_h1_font') != '' && get_option('sense_h1_font') != 'Open Sans') {
			wp_enqueue_style( 'candidat-h1', "$protocol://fonts.googleapis.com/css?family=".get_option('sense_h1_font')."" );
		}	
	if(get_option('sense_h2_font') != '' && get_option('sense_h2_font') != 'Open Sans') {
			wp_enqueue_style( 'candidat-h2', "$protocol://fonts.googleapis.com/css?family=".get_option('sense_h2_font')."" );
		}	
	if(get_option('sense_h3_font') != '' && get_option('sense_h3_font') != 'Open Sans') {
			wp_enqueue_style( 'candidat-h3', "$protocol://fonts.googleapis.com/css?family=".get_option('sense_h3_font')."" );
		}	
	if(get_option('sense_h4_font') != '' && get_option('sense_h4_font') != 'Open Sans') {
			wp_enqueue_style( 'candidat-h4', "$protocol://fonts.googleapis.com/css?family=".get_option('sense_h4_font')."" );
		}	
	if(get_option('sense_h5_font') != '' && get_option('sense_h5_font') != 'Open Sans') {
			wp_enqueue_style( 'candidat-h5', "$protocol://fonts.googleapis.com/css?family=".get_option('sense_h5_font')."" );
		}	
	if(get_option('sense_h6_font') != '' && get_option('sense_h6_font') != 'Open Sans') {
			wp_enqueue_style( 'candidat-h6', "$protocol://fonts.googleapis.com/css?family=".get_option('sense_h6_font')."" );
		}		
}
add_action( 'wp_enqueue_scripts', 'candidate_fonts' );


//ENQUEUE JQUERY & CUSTOM SCRIPTS
function candidate_load_scripts() {
	if(get_option('sense_site_icon') != ''):
		printf("<link rel='shortcut icon' href='%s'/>\r\n", trim(get_option('sense_site_icon')));
		printf("<link rel='icon' href='%s'/>\r\n", trim(get_option('sense_site_icon')));
	else:
		$favicon = '<link rel="shortcut icon" href="'.get_template_directory_uri().'/fav.ico"/>
		<link rel="icon" href="'.get_template_directory_uri().'/fav.ico"/>';
		echo $favicon;
	endif;

	if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );


	
	if ( !is_admin() && !candidat_is_login_page() ) {
		?> <script type="text/javascript"> 
			 window.paththeme = "<?php echo get_template_directory_uri(); ?>";
			 window.owner_email = "<?php echo get_option('admin_email'); ?>";
			 window.color_loader = "<?php echo get_option('sense_accent1_color'); ?>";
			 window.content_animation = "<?php echo get_option('sense_settings_animate'); ?>";
			 window.sticky_header = "<?php echo get_option('sense_show_sticky_header'); ?>";

			 window.added_text = "<?php echo get_option('sense_added_text_newsletter'); ?>";
			 window.added_text2 = "<?php echo get_option('sense_added_text_newsletter2'); ?>";
			 
			 
		</script> <?php
		wp_enqueue_style( 'style', get_stylesheet_uri() );
		
		
		
		wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css');
		wp_enqueue_style( 'fontello-css', get_template_directory_uri() . '/css/fontello.css');
		wp_enqueue_style( 'flexslider-css', get_template_directory_uri() . '/css/flexslider.css');
		wp_enqueue_style( 'owl-carousel-css', get_template_directory_uri() . '/css/owl.carousel.css');
		
		wp_enqueue_style( 'responsive-calendar-css', get_template_directory_uri() . '/css/responsive-calendar.css');
		
		wp_enqueue_style( 'chosen-css', get_template_directory_uri() . '/css/chosen.css');
		wp_enqueue_style( 'jackbox-css', get_template_directory_uri() . '/jackbox/css/jackbox.min.css');
		wp_enqueue_style( 'cloud-zoom-css', get_template_directory_uri() . '/css/cloud-zoom.css');
		
		wp_enqueue_style( 'colorpicker-css', get_template_directory_uri() . '/css/colorpicker.css');
		wp_enqueue_style( 'video-js-css', get_template_directory_uri() . '/video-js/video-js.css');
		wp_enqueue_style( 'style1-css', get_template_directory_uri() . '/css/style1.css');
		
		
       //load theme custom style css
	   candidate_css_loader();
	   
	if ( function_exists( 'tribe_is_event' ) ) {   
		if ( ! tribe_is_event()  ) { 
		wp_enqueue_script('jquery');
		}
	} else {
		wp_enqueue_script('jquery');
	}

	
	wp_enqueue_script('jquery-form');
	wp_enqueue_script( 'jquery-ui', get_template_directory_uri() . '/js/jquery-ui-1.10.4.min.js', array('jquery'), '1.10.4' );

	wp_enqueue_script( 'jquery_queryloader2', get_template_directory_uri() . '/js/jquery.queryloader2.min.js', array('jquery'), '' );

	$ajaxurl = admin_url('admin-ajax.php');
	$ajax_nonce = wp_create_nonce('MailChimp');
	wp_localize_script( 'jquery', 'ajaxVars', array( 'ajaxurl' => $ajaxurl, 'ajax_nonce' => $ajax_nonce )); 
	
	
	
	
	
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '', true);
    
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', false, '', true );
	
	wp_enqueue_script( 'masonry-3.2.1', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array('jquery'), '', true);
	
	
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), '', true);
    wp_enqueue_script( 'owl_carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), '', true);
    
	wp_enqueue_script( 'responsive_calendar', get_template_directory_uri() . '/js/responsive-calendar.min.js', array('jquery'), '', true);
	
	wp_enqueue_script( 'jquery_raty', get_template_directory_uri() . '/js/jquery.raty.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'chosen', get_template_directory_uri() . '/js/chosen.jquery.min.js', array('jquery'), '', true);
	wp_enqueue_script( 'instafeed', get_template_directory_uri() . '/js/instafeed.min.js', array('jquery'), '', true);
	wp_enqueue_script( 'jquery.mixitup', get_template_directory_uri() . '/js/jquery.mixitup.js', array('jquery'), '', true);
	
	
	if ( function_exists( 'tribe_is_event' )  ) {  
		if ( ! tribe_is_event()  ) {  
		wp_enqueue_script( 'jackbox', get_template_directory_uri() . '/jackbox/js/jackbox-packed.min.js', array('jquery'), '', true);
		}
	} else {
	wp_enqueue_script( 'jackbox', get_template_directory_uri() . '/jackbox/js/jackbox-packed.min.js', array('jquery'), '', true);
	}
	
	wp_enqueue_script( 'jflickrfeed', get_template_directory_uri() . '/js/jflickrfeed.min.js', array('jquery'), '', true);

	wp_enqueue_script( 'zoomsl-3.0', get_template_directory_uri() . '/js/zoomsl-3.0.min.js', array('jquery'), '', true);
	
	wp_enqueue_script( 'colorpicker1', get_template_directory_uri() . '/js/colorpicker.js', array('jquery'), '', true);
	
	
	wp_enqueue_script( 'main-script', get_template_directory_uri() . '/js/main-script.js', array('jquery', 'colorpicker1'), '', true);
	
	wp_enqueue_script( 'video_js', get_template_directory_uri() . '/video-js/video.js', array('jquery'), '', true);
	
	}
}
add_action('wp_enqueue_scripts', 'candidate_load_scripts', 1);




//option css load/////////////////////////////////////////////////////////////////////////////////////////	
function candidate_css_loader() {
	
	echo '<style type="text/css">' . PHP_EOL;

	echo "#logo h1 a.logo  {  font-size: " . get_option('sense_logo_size_loft') . "px !important; color: " . get_option('sense_logo_color') . " !important; font-family: " . get_option('sense_logo_font_family') . " !important;}";
	
	echo "#main-header { background: " . get_option('sense_bg_main_header_color') . "  !important; }";
	echo "#newsletter { background: " . get_option('sense_bg_form_header_color') . "  !important; }";
	
	echo ".currentpledgegoal, .audio-progress-bar, html body .dhvc-form-submit:hover, html body .dhvc-form-submit:active, html body .dhvc-form-submit:focus, body .section.full-width-bg .accordion-active .accordion-header, body .section.full-width-bg .accordion-header:hover, body .issue-block:hover a.button, body .filter-dropdown>li>span:hover, body .filter-dropdown.opened>li>span, body #tribe-events-content .tribe-events-calendar td:hover, body .active-sort>button, body .media-item:hover .media-format>div, body .audio-volume-progress, body input[type='submit']:hover, body input[type='reset']:hover, body .tab-header li.active-tab, body .tab-header li:hover, body .product-single-tabs .tab-header li.active-tab, body .product-single-tabs .tab-header li:hover { background: " . get_option('sense_accent1_color') . " !important; }";
	echo ".newsletter-form .newsletter-submit:hover .icons, .newsletter-form .newsletter-submit:hover input, body .image-banner:hover a  { background: " . get_option('sense_submit_newsletter_hover_color') . " !important; }";
	
	echo "body .increase-button, body .decrease-button, body .post-side-meta .post-format, body .banner, body a.button, body button,  body .owl-header .carousel-arrows span, body .banner-rotator-flexslider .flex-control-nav li a.flex-active, body #button-to-top, body .issue-block:hover, body .filter-dropdown>li>span, body #tribe-events-content .tribe-events-calendar th, body .event-meta-block, body .media-format>div, body input[type='submit'], body input[type='reset'], body .tab-header li, body .accordion-header, body .dropcap.squared, body .cart-button, body input.minus, body input.plus, body a.tag { background: " . get_option('sense_accent5_color') . "; }";
	echo "body #bbpress-forums ul.chosen-results li.highlighted, body .increase-button:hover, body .decrease-button:hover, body .numeric-pagination span, body .event-item:hover .date>span, body .banner:hover, body .owl-header .carousel-arrows span:hover, body a.button:hover, body button:hover, body a.button.active-button, body button.active-button, body .banner-rotator-content, body .image-banner a, body .flex-direction-nav a:hover, body #button-to-top:hover, body .post-side-meta .post-format:hover, body .issue-icon, body .chosen-container .chosen-results li.highlighted, body .dropcap.squared.blue, body #content .section.full-width-bg .most-popular .pricing-header, body .shopping-cart:hover .cart-button, body .shop-product-gallery .fullscreen-icon:hover, body input.minus:hover, body input.plus:hover, body .upcoming-events>li:hover .date>span, body a.tag:hover { background: " . get_option('sense_accent1_color') . "; }";
	echo "body .banner.donate-banner  { background: " . get_option('sense_bg_banner_donate_color') . "; }";
	
	echo "body .banner.donate-banner h5, body .section.full-width-bg .banner.donate-banner h5  { color: " . get_option('sense_text_banner_donate_color') . " !important; }";
	
	echo "body input.minus:hover, body input.plus:hover, body .increase-button:hover, body .decrease-button:hover   { border-color: " . get_option('sense_accent1_color') . " !important; }";
	
	echo "body #main-footer p, body .twitter-widget li { color: " . get_option('sense_footer_text_color') . "; }";
	echo "body footer .widget a, body .twitter-widget a { color: " . get_option('sense_footer_text_color_link') . "; }";
	echo "body footer a:hover { color: " . get_option('sense_footer_text_color_link_hover') . " !important; }";
	
	
	
	echo "body #lower-header #menu-button>span  { color: " . get_option('sense_mobile_text_color') . "; }";
	echo "body #lower-header #menu-button>div>span  { background: " . get_option('sense_mobile_icon_color') . "; }";
	echo "body #menu-button:hover>span { color: " . get_option('sense_mobile_icon_color_hover') . " !important; }";
	echo "body #menu-button:hover>div>span { background: " . get_option('sense_mobile_icon_color_hover') . "!important; }";
	echo "body #menu-button:hover { background: " . get_option('sense_accent1_color') . "; }";
	
	
	echo "body .newsletter-form .newsletter-submit .icons, body .newsletter-form .newsletter-submit input { background: " . get_option('sense_submit_newsletter_color') . "; }";
	echo "body .newsletter-form .newsletter-submit .icons { color: " . get_option('sense_submit_newsletter_color_icon') . "; }";
	
	echo "body .price ins .amount, body .pledgemaincontainer span:first-child small:first-child, 
	body.single-product .pledgemaincontainer span:first-child{ color: " . get_option('sense_price_color') . " !important; }";
	
	echo "body.single-product .pledgemaincontainer span:first-child small, body a.button.twitter-button:hover{ color: " . get_option('sense_accent3_color') . " !important; }";
	
	
	echo "body .banner .icons, body .event-meta-block>.icons { color: " . get_option('sense_banner_icon_color') . "; }";
	echo "body .banner:hover .icons { color: " . get_option('sense_banner_icon_hover_color') . "; }";
	
	echo "body .banner:hover h4, body .section.full-width-bg .banner:hover h4, body .banner-wrapper.mystyle2 .banner:hover h4 { color: " . get_option('sense_banner_title_hover_color') . " !important; }";
	echo "body .banner:hover p, body .section.full-width-bg .banner:hover p { color: " . get_option('sense_banner_text_hover_color') . " !important; }";
	
	
	echo "body .banner.donate-banner input[type='submit'], body #navigation li.donate-button, body a.button.donate, body button.donate, body #payment input[type='submit'], body input[type='submit'].button.donate  { background: " . get_option('sense_accent2_color') . "; }";
	
	echo "body a.button.add-to-cart-button, body a.added_to_cart.wc-forward  { color: " . get_option('sense_accent2_color') . " !important; }";
	
	echo "body a.button.add-to-cart-button:after  { color: " . get_option('sense_add_cart_icon_color') . " ; }";
	echo "body a.button.add-to-cart-button:hover, body a.button.add-to-cart-button:hover:after  { color: " . get_option('sense_add_cart_icon_color') . " !important; }";
	
	
	echo "body .banner.donate-banner input[type='submit'], body a.button.donate, body button.donate, body #payment input[type='submit'], body input[type='submit'].button.donate  { border-top-color: " . get_option('sense_donate_border_top_color') . "; }";
	echo "body .banner.donate-banner input[type='submit'], body a.button.donate, body button.donate, body #payment input[type='submit'], body input[type='submit'].button.donate  { border-bottom-color: " . get_option('sense_donate_border_bottom_color') . "; }";
	echo "body .banner.donate-banner input[type='radio']+label  { box-shadow:0 0 1px " . get_option('sense_accent2_color') . "; }";
	echo "body #navigation li.donate-button>a  { border-top-color: " . get_option('sense_donate_border_top_color') . "; }";
	echo "body #navigation li.donate-button>a  { border-bottom-color: " . get_option('sense_donate_border_bottom_color') . "; }";
	
	
	
	echo "body a.button.donate:hover, body button.donate:hover, body #navigation li.donate-button>a:hover, body .banner.donate-banner input[type='submit']:hover  { border-top-color: " . get_option('sense_hover_donate_border_top_color') . " !important; }";
	echo "body a.button.donate:hover, body button.donate:hover, body #navigation li.donate-button>a:hover, body .banner.donate-banner input[type='submit']:hover  { border-bottom-color: " . get_option('sense_hover_donate_border_bottom_color') . " !important; }";
	
	echo "body .post-side-meta .date { background: " . get_option('sense_blog_date_color') . " ; }";
	echo "body .post-side-meta .post-comments { background: " . get_option('sense_accent4_color') . " ; }";
	
	
	echo "body .highlight  { color: " . get_option('sense_highlight_color') . " ; }";
	echo "body .highlight { background: " . get_option('sense_highlight_color_bg') . " ; }";
	
	echo "::selection { color: " . get_option('sense_highlight_color') . " !important; }";
	echo "*::-moz-selection { color: " . get_option('sense_highlight_color') . " !important; }";
	echo "::selection { background: " . get_option('sense_highlight_color_bg') . " !important; }";
	echo "*::-moz-selection { background: " . get_option('sense_highlight_color_bg') . " !important; }";
	
	
	echo "body .banner-rotator-content a.button:hover  { background: " . get_option('sense_banner_campaign_hover_color') . "; }";
	
	
	echo "body .image-banner img  { border-bottom-color: " . get_option('sense_image_banner_border_top_color') . "; }";
	echo "body .image-banner a   { border-bottom-color: " . get_option('sense_image_banner_border_bottom_color') . "; }";
	
	echo "body .image-banner:hover img { border-bottom-color: " . get_option('sense_image_banner_border_top_color_hover') . "; }";
	echo "body .image-banner:hover a   { border-bottom-color: " . get_option('sense_image_banner_border_bottom_color_hover') . "; }";
	
	echo "body .sidebar-box.image-banner h3, body .image-banner .button, body .image-banner .button.button-arrow:after   { color: " . get_option('sense_image_banner_title_color') . " !important; }";
	
	
	echo "body .banner-rotator-content h5  { color: " . get_option('sense_title_top_button_rotator_color') . " !important; }";
	echo "body .banner-rotator-content h2, body .banner-rotator-content span.date  { color: " . get_option('sense_title_button_rotator_color') . " !important; }";
	
	
	
	
	echo "body .dhvc-form-flat .dhvc-form-radio input + i:after  { background-color: " . get_option('sense_form_text_color') . " !important; }";
	
	echo "body .chosen-container-single .chosen-single, .universe_funder_contribution, input.input-text.qty, body input[type='text'], body input[type='email'], body input[type='password'], select, textarea,
	body .dhvc-form-flat .chosen-container-multi .chosen-choices, body .dhvc-form-flat .dhvc-form-checkbox input + i:after, body .dhvc-form-flat .chosen-container .chosen-drop, body .dhvc-form-flat .chosen-container-single .chosen-single, body .dhvc-form-flat .dhvc-form-input input, body .dhvc-form-flat .dhvc-form-file input[type=text], body .dhvc-form-flat .dhvc-form-captcha input, body .dhvc-form-flat .dhvc-form-select select, body .dhvc-form-flat .dhvc-form-textarea textarea  { color: " . get_option('sense_form_text_color') . " !important; }";
	echo "body #bbpress-forums li.bbp-header,
	body .chosen-container-single .chosen-single, .universe_funder_contribution, input.input-text.qty, body input[type='text'], body input[type='email'], body input[type='password'], select, textarea,
	body .dhvc-form-flat .chosen-container-multi .chosen-choices, body .dhvc-form-flat .dhvc-form-radio i, body .dhvc-form-flat .dhvc-form-checkbox i, body .dhvc-form-flat .chosen-container .chosen-drop, body .dhvc-form-flat .chosen-container-single .chosen-single, body .dhvc-form-flat .dhvc-form-input input, body .dhvc-form-flat .dhvc-form-file input[type=text], body .dhvc-form-flat .dhvc-form-captcha input, body .dhvc-form-flat .dhvc-form-select select, body .dhvc-form-flat .dhvc-form-textarea textarea  { background-color: " . get_option('sense_form_bg_color') . " !important; }";
	echo "body #bbpress-forums ul.bbp-lead-topic, body #bbpress-forums ul.bbp-topics, body #bbpress-forums ul.bbp-forums, body #bbpress-forums ul.bbp-replies, body #bbpress-forums ul.bbp-search-results
	body .quicktags-toolbar, body #bbpress-forums li.bbp-header, body #bbpress-forums li.bbp-footer, body #bbpress-forums li.bbp-body ul.forum, body #bbpress-forums li.bbp-body ul.topic,   
	body .chosen-container-single .chosen-single, .universe_funder_contribution, .increase-button, .decrease-button, input.input-text.qty, body input[type='text'], body input[type='email'], body input[type='password'], select, textarea,
	body .dhvc-form-flat .chosen-container-multi .chosen-choices, body .dhvc-form-flat .dhvc-form-radio i, body .dhvc-form-flat .dhvc-form-checkbox i, body .dhvc-form-flat .chosen-container-single .chosen-single, body .dhvc-form-flat .chosen-container .chosen-results, body .dhvc-form-flat .dhvc-form-input input, body .dhvc-form-flat .dhvc-form-file input[type=text], body .dhvc-form-flat .dhvc-form-captcha input, body .dhvc-form-flat .dhvc-form-select select, body .dhvc-form-flat .dhvc-form-textarea textarea  { border-color: " . get_option('sense_form_border_color') . " !important; }";
	
	echo "#bbpress-forums li.bbp-body ul.forum, #bbpress-forums li.bbp-body ul.topic { border-top: 1px solid " . get_option('sense_form_border_color') . " !important; }";
	
	echo "body .checkout-coupon-form input[type='submit'], #comment-form input[type='submit'], .tribe-events-list .tribe-events-event-cost span, html body button.dhvc-form-submit { border-top-color: " . get_option('sense_button_border_top_color') . " !important; }";
	echo "body .checkout-coupon-form input[type='submit'], #comment-form input[type='submit'], .tribe-events-list .tribe-events-event-cost span, html body button.dhvc-form-submit { border-bottom-color: " . get_option('sense_button_border_bottom_color') . " !important; }";
	
	echo "body .checkout-coupon-form input[type='submit']:hover, #comment-form input[type='submit']:hover, html body .dhvc-form-submit:hover, html body .dhvc-form-submit:active, html body .dhvc-form-submit:focus { border-top-color: " . get_option('sense_hover_button_border_top_color') . " !important; }";
	echo "body .checkout-coupon-form input[type='submit']:hover, #comment-form input[type='submit']:hover, html body .dhvc-form-submit:hover, html body .dhvc-form-submit:active, html body .dhvc-form-submit:focus { border-bottom-color: " . get_option('sense_hover_button_border_bottom_color') . " !important; }";
	
	
	echo "body .newsletter-form .newsletter-submit:hover .icons, body .newsletter-form input[type='submit'] { border-bottom-color: " . get_option('sense_hover_topform_border_bottom_color') . " !important; }";
	echo "body .newsletter-form .newsletter-submit .icons { border-bottom-color: " . get_option('sense_topform_border_bottom_color') . "; }";
	
	
	echo "body input[type='submit'], body .shopping-cart-table input[type='submit'], body .cart-button, body .owl-header .carousel-arrows span, body .tab-header li, body a.button, body button, body #button-to-top, body .accordion-header, body .filter-dropdown>li>span, body .product-single-tabs .tab-header li.active-tab, body .product-single-tabs .tab-header li:hover { border-top-color: " . get_option('sense_button_border_top_color') . "; }";
	echo "body input[type='submit'], body .shopping-cart-table input[type='submit'], body .cart-button, body .owl-header .carousel-arrows span, body .tab-header li, body a.button, body button, body #button-to-top, body .accordion-header, body .filter-dropdown>li>span, body .product-single-tabs .tab-header li.active-tab, body .product-single-tabs .tab-header li:hover { border-bottom-color: " . get_option('sense_button_border_bottom_color') . "; }";
	
	
	echo "body .section.full-width-bg  .accordion-active .accordion-header, body .accordion-header:hover, body input[type='submit']:hover, body .shopping-cart-table input[type='submit']:hover, body .active-sort>button, body .shopping-cart:hover .cart-button, body .owl-header .carousel-arrows span:hover, body a.button:hover, body button:hover, body a.button.active-button, body button.active-button, body #button-to-top:hover, html body .section.full-width-bg .accordion-active .accordion-header, body .section.full-width-bg .accordion-header:hover, body .filter-dropdown>li>span:hover, body .filter-dropdown.opened>li>span, body .product-single-tabs .tab-header li.active-tab, body .product-single-tabs .tab-header li:hover, body .tab-header li.active-tab, body .tab-header li:hover  { border-top-color: " . get_option('sense_hover_button_border_top_color') . "; }";
	echo "body .section.full-width-bg  .accordion-active .accordion-header, body .accordion-header:hover, body input[type='submit']:hover, body .shopping-cart-table input[type='submit']:hover, body .active-sort>button, body .shopping-cart:hover .cart-button, body .owl-header .carousel-arrows span:hover, body .tab-header li.active-tab, body .tab-header li:hover, body a.button:hover, body button:hover, body a.button.active-button, body button.active-button, body #button-to-top:hover, html body .section.full-width-bg .accordion-active .accordion-header, body .section.full-width-bg .accordion-header:hover, body .filter-dropdown>li>span:hover, body .filter-dropdown.opened>li>span, body .product-single-tabs .tab-header li.active-tab, body .product-single-tabs .tab-header li:hover { border-bottom-color: " . get_option('sense_hover_button_border_bottom_color') . "; }";
	
	echo "body #navigation li.donate-button:hover, body #navigation li.donate-button:hover>a, body .banner.donate-banner input[type='submit']:hover, body a.button.donate:hover, body button.donate:hover, body #payment input[type='submit']:hover, body input[type='submit'].button.donate:hover { background: " . get_option('sense_donate_button_hover_color') . " !important; }";
	echo "body #navigation li.donate-button:hover>a, body .banner.donate-banner input[type='submit']:hover, body #payment input[type='submit']:hover, body input[type='submit'].button.donate:hover { border-top-color: " . get_option('sense_donate_button_hover_color') . "; }";
	
	echo "body .col-lg-3 .media-button a.button:hover, body .col-lg-9 .col-lg-4 .media-button a.button:hover, body a.button.transparent:hover, body button.transparent:hover, body a.button.transparent:hover:after, body button.transparent:hover:after, body .sidebar-box a.button.transparent:hover:after, body .filter-dropdown ul li:hover, body .filter-dropdown ul li.active-filter, body .dropcap.blue { color: " . get_option('sense_accent1_color') . " ; }";
	
	
	echo "body .section.full-width-bg .event-popover h6 a { color: " . get_option('sense_accent1_color') . " !important; }";
	
	
	echo "body .shopping-cart-content { border-color: " . get_option('sense_accent1_color') . " ; }";
	
	echo "body button.button.add-to-cart-button:after { color: " . get_option('sense_add_cart_single_icon_color') . " !important; }";
	
	echo "body a.button.details-button:hover, body a.button.details-button:hover:after { color: " . get_option('sense_accent1_color') . " !important; }";
	
	
	echo "body .pledgemaincontainer, body .col-lg-3 .media-button a.button, body .col-lg-9 .col-lg-4 .media-button a.button, body a.button, body button, body a.button.transparent, body button.transparent, body .issue-block:hover .issue-icon, body .filter-dropdown>li>span, body .media-format>div, body input[type='submit'], body input[type='reset'], body a.tag { color: " . get_option('sense_accent3_color') . " ; }";
	
	echo "html body button.dhvc-form-submit, html body .dhvc-form-submit:active, body .dhvc-form-submit:focus, .tribe-events-list .time-details, .tribe-events-list .tribe-events-event-cost span, body #content .section.full-width-bg .accordion-header h6, body #content .section.full-width-bg .tab-header li a h6, body a.button.details-button { color: " . get_option('sense_accent3_color') . " !important; }";
	
	echo "body .banner-rotator-flexslider .flex-control-nav li a  { background: " . get_option('sense_button_rotator_color') . "; }";
	
	echo "body .audio-progress-wrapper, body .volume-bar  { border-color: " . get_option('sense_border_audio_pr_color') . "; }";
	
	echo "body .audio-progress-wrapper, body .volume-bar  { background: " . get_option('sense_bg_audio_pr_color') . "; }";
	echo "body .audio-play-button, body .audio-volume  { border-color: " . get_option('sense_bg_audio_pr_color') . "; }";
	echo "body .audio-player, body .audio-volume .volume-bar:before, body .audio-player  { color: " . get_option('sense_bg_audio_text_color') . "; }";
	echo "body .audio-play-button:before  { color: " . get_option('sense_bg_audio_btn_color') . "; }";
	
	
	echo ".widget_display_stats dd, .widget_display_stats dt, body a, body .category-box a, body .sidebar-box.widget_nav_menu_custom .menu li a, body .sidebar-box.widget_nav_menu .menu li a { color: " . get_option('sense_basic_link_color') . " ; }";
	
	echo "body .section.full-width-bg .issue-content h4, body .alert-box.info, body .alert-box.info p  { color: " . get_option('sense_basic_link_color') . " !important ; }";
	
	echo "body .tooltip-inner { background: " . get_option('sense_basic_link_color') . " !important ; }";
	echo "body .tooltip.top .tooltip-arrow { border-top-color: " . get_option('sense_basic_link_color') . " !important ; }";
	echo "body .tooltip.left .tooltip-arrow { border-left-color: " . get_option('sense_basic_link_color') . " !important ; }";
	echo "body .tooltip.bottom .tooltip-arrow { border-bottom-color: " . get_option('sense_basic_link_color') . " !important ; }";
	echo "body .tooltip.right .tooltip-arrow { border-right-color: " . get_option('sense_basic_link_color') . " !important ; }";
	
	
	echo "body .event-calendar td .events li { border-color: " . get_option('sense_calendar_line_color') . " ; }";
	echo "body .event-calendar td:hover .events li { border-color: " . get_option('sense_calendar_line_color_hover') . " ; }";
	
	
	
	echo "body a:hover, body blockquote, body .post-side-meta .post-format, body .pricing-price { color: " . get_option('sense_accent3_color') . " ; }";
	
	echo "body a:hover, body .upcoming-events>li:hover h6 a { color: " . get_option('sense_basic_link_color_hover') . " ; }";
	

	
	echo "body .tribe-events-list-separator-month span, body .issue-block:hover .issue-content h4 { color: " . get_option('sense_accent3_color') . " !important; }";
	
	echo "body blockquote { border-left-color: " . get_option('sense_accent1_color') . " ; }";
	
	echo "body #content .section.full-width-bg .pricing-header h4 { color: " . get_option('sense_accent1_color') . " !important; }";
	
	echo "body blockquote.iconic-quote:after, body blockquote.iconic-quote:before { color: " . get_option('sense_accent5_color') . " ; }";
	
	echo ".tribe-events-list .tribe-events-event-cost span, body .product-single-tabs .tab-header li, html body button.dhvc-form-submit { background: " . get_option('sense_accent5_color') . " !important; }";
	
	echo "body #main-header blockquote:before, body #main-header blockquote:after { color: " . get_option('sense_header_blockquote_color') . " ; }";
	
	echo "body .accordion-icon:before, body .cart-button { color: " . get_option('sense_tab_icon_color') . " ; }";
	
	echo "body .team-member.big, body .team-member-info, body blockquote, body .issue-block { background: " . get_option('sense_accent4_color') . "; }";
	
	echo "body #bbpress-forums ul.chosen-results li, body blockquote, body .issue-block, html body #tribe-events-content .tribe-events-calendar td, body .media-item, body .portfolio-single, body input[type='text'], body input[type='email'], body input[type='password'], body select, body textarea, body .form-select+.chosen-container-single .chosen-single, body input[type='checkbox']+label:before, body input[type='radio']+label:before, body .chosen-container .chosen-drop, body .chosen-container .chosen-results li, body .sidebar-box.white, body .checkout .chosen-container-single .chosen-single, body .woocommerce-account .chosen-container-single .chosen-single, body table, body .chosen-container-single .chosen-single  { background: " . get_option('sense_accent4_color') . "; }";
	
	echo "body .accordion-content, body .issue-block:hover .issue-icon, body .event-popover, body .filter-dropdown ul, body .tab { background: " . get_option('sense_tab_content_bg_color') . "; }";
	
	
	echo "body .audio-player { background: " . get_option('sense_accent3_color') . " ; }";
	
	echo "body .alert-box.info, body .alert-box.info p { background: " . get_option('sense_shop_alert_info_color') . "; }";
	
	
	echo "body .quicktags-toolbar, body .upcoming-events .date>span, body .event-info .date>span { background: " . get_option('sense_accent6_color') . "; }";
	
	

	echo "body .gray-bg { background: " . get_option('sense_gray_bg_color') . "; }";
	
	
	echo "#navigation li:hover, #navigation li:hover>span, #navigation li:hover>a, #navigation>li.current-menu-item, #navigation>li.current-menu-item>span, #navigation>li.current-menu-item>a { color: " . get_option('sense_bg_menu_text_hover_color') . " !important; }";
	
	
	echo "body #lower-footer { border-top-color: " . get_option('sense_footer_border_color') . " !important; }";
	
	echo "body .category-box a:hover:before, body #button-to-top:hover, .filter-dropdown>li>span:hover, .filter-dropdown>li>span:hover:after, .filter-dropdown.opened>li>span, .filter-dropdown.opened>li>span:after, body .menu li a:hover:before, body .owl-header .carousel-arrows span:hover, body a.button:hover:after, body button:hover:after, body a.button:hover:before, body button:hover:before, body a.button.active-button:after, body button.active-button:after { color: " . get_option('sense_button_arrow_color_hover') . " !important; }";
	echo "body .menu li a:before, body .event-meta-block .social-share li a, body a.button.button-arrow-before:before, body button.button-arrow-before:before, body .button-pagination a.previous:before, body .button-pagination a.next:after, body a.button.button-arrow:after, body button.button-arrow:after, body .owl-header .carousel-arrows span { color: " . get_option('sense_button_arrow_color') . " ; }";
	echo "body .bbpress-sidebar ul a:before, body a.button:after, body a.button:before, body button:before, body button:after, body .increase-button, body .decrease-button, body .category-box a:before, body #button-to-top, body .filter-dropdown>li>span:after { color: " . get_option('sense_button_arrow_color') . "; }";
	echo "body a.button.details-button:after { color: " . get_option('sense_button_arrow_color') . " !important; }";
	

	echo "#navigation li:hover, #navigation li:hover>span, #navigation li:hover>a, #navigation>li.current-menu-item, #navigation>li.current-menu-item>span, #navigation>li.current-menu-item>a { background: " . get_option('sense_bg_menu_hover_color') . "  !important; }";
	
	
	echo "body a.button.twitter-button:hover { background: " . get_option('sense_bg_twitter_button_hover_color') . " ; }";
	echo "body a.button.twitter-button:hover { border-top-color: " . get_option('sense_bg_twitter_button_hover_color') . " ; }";
	echo "body a.button.twitter-button:hover { border-bottom-color: " . get_option('sense_bg_twitter_button_hover_color') . " ; }";
	
	
	
	echo "body a.button.twitter-button { background: " . get_option('sense_bg_twitter_button_color') . " ; }";
	echo "body a.button.twitter-button:hover:before { color: " . get_option('sense_bg_twitter_button_icon_color_hover') . " !important; }";
	echo "body a.button.twitter-button { color: " . get_option('sense_text_twitter_button_color') . " ; }";
	
	echo "body a.button.twitter-button { border-top-color: " . get_option('sense_bg_twitter_border_top_color') . " ; }";
	echo "body a.button.twitter-button { border-bottom-color: " . get_option('sense_bg_twitter_border_bottom_color') . " ; }";
	
	echo "body a.button.twitter-button:before { color: " . get_option('sense_bg_twitter_button_icon_color') . " ; }";
	
	
	echo "body #navigation>li:hover>a, body #navigation>li:hover>span, body #navigation>li.current-menu-item>a, body #navigation>li.current-menu-item>span { border-top-color: " . get_option('sense_bg_menu_border_top_hover_color') . " ; }";
	echo "body #navigation>li:hover, body #navigation>li:hover>span, body #navigation>li.current-menu-item, body #navigation>li.current-menu-item>span { border-bottom-color: " . get_option('sense_bg_menu_border_bottom_hover_color') . " !important; }";
	
	
	
	
	echo "body #lower-header:before, body #navigation>li>a, body #navigation>li>span { border-top-color: " . get_option('sense_bg_menu_border_top_color') . " ; }";
	echo "body #navigation li, body #menu-button, body #lower-header:before, body #navigation>li>a, body #navigation>li>span, body #navigation li ul li>a, body #navigation li ul li>span { border-bottom-color: " . get_option('sense_bg_menu_border_bottom_color') . " ; }";
	echo "body #menu-button, body #navigation>li { border-right-color: " . get_option('sense_bg_menu_border_bottom_color') . " ; }";
	echo "body #menu-button, body #navigation>li:first-child { border-left-color: " . get_option('sense_bg_menu_border_bottom_color') . " ; }";
	
	echo "body #navigation li, body #navigation li>span #navigation li>a { border-color: " . get_option('sense_bg_menu_border_bottom_color') . " !important; }";
	
	
	echo "body #navigation>li>a:after, body #navigation>li>span:after, body #navigation li ul li>a:after, body #navigation li ul li>span:after { color: " . get_option('sense_bg_menu_icon_color') . " ; }";
	
	echo "body #lower-header, body #navigation>li, body #navigation li ul { background: " . get_option('sense_bg_menu_main_color') . " ; }";
	
	
	$color_media = candidat_hex2rgb(get_option('sense_bg_media_btn_color'), 0.7);
	$color_media_hover = candidat_hex2rgb(get_option('sense_bg_media_btn_color'), 1);
	
	echo "body .media-hover .media-icon { color: " . get_option('sense_icon_media_btn_color') . " ; }";
	echo "body .media-hover .media-icon { background: " . $color_media . " ; }";
	echo "body .media-hover .media-icon:hover { background: " . $color_media_hover . " ; }";
	

	$color_media_twitter = candidat_hex2rgb(get_option('sense_twitter_bg_media_btn_color'), 0.7);
	$color_media_hover_twitter = candidat_hex2rgb(get_option('sense_twitter_bg_media_btn_color'), 1);
	$color_media_facebook = candidat_hex2rgb(get_option('sense_facebook_bg_media_btn_color'), 0.7);
	$color_media_hover_facebook = candidat_hex2rgb(get_option('sense_facebook_bg_media_btn_color'), 1);
	
		
	echo "body .media-hover .media-icon.share-twitter { background: " . $color_media_twitter . " ; }";
	echo "body .media-hover .media-icon.share-twitter:hover { background: " . $color_media_hover_twitter . " ; }";
	
	echo "body .media-hover .media-icon.share-facebook { background: " . $color_media_facebook . " ; }";
	echo "body .media-hover .media-icon.share-facebook:hover { background: " . $color_media_hover_facebook . " ; }";

	
	
	
	
	$is_body_font_family = get_option('sense_basic_font');
	$is_body_font_color = get_option('sense_basic_font_color');
	$is_body_font_style = get_option('sense_basic_text_styles');
	$is_body_font_size = get_option('sense_size_basic_text');
	
	echo "
		.section.full-width-bg p, .wpb_text_column p, .textwidget p
		{	
		font-family: '" . $is_body_font_family . "' !important;  color: " . $is_body_font_color . "; font-style: " . $is_body_font_style . ";  font-size: " . $is_body_font_size . " !important; 
		} 
		";
	
	$is_page_title_font_family = get_option('sense_page_title_font');
	$is_page_title_font_color = get_option('sense_page_title_font_color');
	$is_page_title_font_style = get_option('sense_page_title_styles');
	$is_page_title_font_size = get_option('sense_size_page_title');	
		
	echo "
		.section.page-heading h1, body .section.full-width-bg .calendar-header h3 
		{	
		font-family: '" . $is_page_title_font_family . "' !important;  color: " . $is_page_title_font_color . "; font-style: " . $is_page_title_font_style . ";  font-size: " . $is_page_title_font_size . " !important; 
		} 
		";	
		
	
	$is_breadcrumb_font_family = get_option('sense_breadcrumb_font');
	$is_breadcrumb_font_color = get_option('sense_breadcrumb_font_color');
	$is_breadcrumb_font_style = get_option('sense_breadcrumb_styles');
	$is_breadcrumb_font_size = get_option('sense_size_breadcrumb');	
		
	echo "
		body .page-heading .breadcrumb
		{	
		font-family: '" . $is_breadcrumb_font_family . "' !important;  color: " . $is_breadcrumb_font_color . "; font-style: " . $is_breadcrumb_font_style . ";  font-size: " . $is_breadcrumb_font_size . " !important; 
		} 
		";	
	
		
	$copyright_text_font_family = get_option('sense_copyright_font');
	$copyright_text_font_color = get_option('sense_copyright_font_color');
	$copyright_text_font_style = get_option('sense_copyright_text_styles');
	$copyright_text_font_size = get_option('sense_copyright_text_size');	
		
	echo "
		#lower-footer .copyright
		{	
		font-family: '" . $copyright_text_font_family . "' !important;  color: " . $copyright_text_font_color . "; font-style: " . $copyright_text_font_style . ";  font-size: " . $copyright_text_font_size . " !important; 
		} 
		";		
		
		
		
	$banner1_sidebar_titles_font_family = get_option('sense_banner1_sidebar_titles_font');
	$banner1_sidebar_titles_font_color = get_option('sense_banner1_sidebar_titles_font_color');
	$banner1_sidebar_titles_font_style = get_option('sense_banner1_sidebar_titles_styles');
	$banner1_sidebar_titles_font_size = get_option('sense_banner1_sidebar_titles_size');	
		
	echo "
		body .banner h4, body .section.full-width-bg .banner h4
		{	
		font-family: '" . $banner1_sidebar_titles_font_family . "' !important;  color: " . $banner1_sidebar_titles_font_color . "  !important; font-style: " . $banner1_sidebar_titles_font_style . " !important;  font-size: " . $banner1_sidebar_titles_font_size . " !important; 
		} 
		";			
		
	$banner2_sidebar_titles_font_family = get_option('sense_banner2_sidebar_titles_font');
	$banner2_sidebar_titles_font_color = get_option('sense_banner2_sidebar_titles_font_color');
	$banner2_sidebar_titles_font_style = get_option('sense_banner2_sidebar_titles_styles');
	$banner2_sidebar_titles_font_size = get_option('sense_banner2_sidebar_titles_size');	
		
	echo "
		body .banner-wrapper.mystyle2 h4
		{	
		font-family: '" . $banner2_sidebar_titles_font_family . "' !important;  color: " . $banner2_sidebar_titles_font_color . "  !important; font-style: " . $banner2_sidebar_titles_font_style . " !important;  font-size: " . $banner2_sidebar_titles_font_size . " !important; 
		} 
		";			
		
	
	$banner1_sidebar_text_font_family = get_option('sense_banner1_sidebar_text_font');
	$banner1_sidebar_text_font_color = get_option('sense_banner1_sidebar_text_font_color');
	$banner1_sidebar_text_font_style = get_option('sense_banner1_sidebar_text_styles');
	$banner1_sidebar_text_font_size = get_option('sense_banner1_sidebar_text_size');	
		
	echo "
		body .banner p, body .section.full-width-bg .banner p
		{	
		font-family: '" . $banner1_sidebar_text_font_family . "' !important;  color: " . $banner1_sidebar_text_font_color . "  !important; font-style: " . $banner1_sidebar_text_font_style . " !important;  font-size: " . $banner1_sidebar_text_font_size . " !important; 
		} 
		";		
	
	
		
	$sidebar_titles_font_family = get_option('sense_sidebar_titles_font');
	$sidebar_titles_font_color = get_option('sense_sidebar_titles_font_color');
	$sidebar_titles_font_style = get_option('sense_sidebar_titles_styles');
	$sidebar_titles_font_size = get_option('sense_sidebar_titles_size');	
		
	echo "
		.sidebar-box h3, .section.full-width-bg .sidebar-box h3, body .section.full-width-bg .sidebar-box h3.custom_sidebar_title
		{	
		font-family: '" . $sidebar_titles_font_family . "' !important;  color: " . $sidebar_titles_font_color . "  !important; font-style: " . $sidebar_titles_font_style . " !important;  font-size: " . $sidebar_titles_font_size . " !important; 
		} 
		";			
		
		
		
	$footer_titles_font_family = get_option('sense_footer_titles_font');
	$footer_titles_font_color = get_option('sense_footer_titles_font_color');
	$footer_titles_font_style = get_option('sense_footer_titles_styles');
	$footer_titles_font_size = get_option('sense_footer_titles_size');	
		
	echo "
		#main-footer h4
		{	
		font-family: '" . $footer_titles_font_family . "' !important;  color: " . $footer_titles_font_color . "; font-style: " . $footer_titles_font_style . ";  font-size: " . $footer_titles_font_size . " !important; 
		} 
		";			
		
	
	$post_day_font_family = get_option('sense_post_day_font');
	$post_day_font_color = get_option('sense_post_day_font_color');
	$post_day_font_style = get_option('sense_post_day_styles');
	$post_day_font_size = get_option('sense_post_day_size');	
		
	echo "
		body .post-side-meta .date .day
		{	
		font-family: '" . $post_day_font_family . "' !important;  color: " . $post_day_font_color . "; font-style: " . $post_day_font_style . ";  font-size: " . $post_day_font_size . " !important; 
		} 
		";		
		
	$post_month_font_family = get_option('sense_post_month_font');
	$post_month_font_color = get_option('sense_post_month_font_color');
	$post_month_font_style = get_option('sense_post_month_styles');
	$post_month_font_size = get_option('sense_post_month_size');	
		
	echo "
		body .post-side-meta .date .month
		{	
		font-family: '" . $post_month_font_family . "' !important;  color: " . $post_month_font_color . "; font-style: " . $post_month_font_style . ";  font-size: " . $post_month_font_size . " !important; 
		} 
		";		










	
		
	$header_text_font_family = get_option('sense_header_text_font');
	$header_text_font_color = get_option('sense_header_text_font_color');
	$header_text_font_style = get_option('sense_header_text_styles');
	$header_text_font_size = get_option('sense_header_text_size');	
		
	echo "
		header #main-header blockquote, header #main-header p
		{	
		font-family: '" . $header_text_font_family . "' !important;  color: " . $header_text_font_color . "; font-style: " . $header_text_font_style . ";  font-size: " . $header_text_font_size . " !important; 
		} 
		";				
		
		
		
		
	$small_text_font_family = get_option('sense_small_text_font');
	$small_text_font_color = get_option('sense_small_text_font_color');
	$small_text_font_style = get_option('sense_small_text_styles');
	$small_text_font_size = get_option('sense_small_text_size');	
		
	echo "
		body .event-popover .event-meta li, body .small-caption, body .tribe-events-event-meta address.tribe-events-address, body .tribe-events-list .tribe-events-venue-details, body .event-meta-block p.title, body .post-meta>span, body .post-meta-track, body .upcoming-events .event-content .event-meta, body .calendar-header label, body .media-filters label
		{	
		font-family: '" . $small_text_font_family . "' !important;  color: " . $small_text_font_color . "; font-style: " . $small_text_font_style . ";  font-size: " . $small_text_font_size . " !important; 
		} 
		";		


	$menu_font_family = get_option('sense_menu_font');
	$menu_font_color = get_option('sense_menu_font_color');
	$menu_font_style = get_option('sense_menu_styles');
	$menu_font_size = get_option('sense_menu_size');	
		
	echo "
		body #navigation li>span, body #navigation li>a
		{	
		font-family: '" . $menu_font_family . "' !important;  color: " . $menu_font_color . "; font-style: " . $menu_font_style . "; font-size: " . $menu_font_size . " !important; 
		} 
		";		



	$submenu_font_family = get_option('sense_submenu_font');
	$submenu_font_color = get_option('sense_submenu_font_color');
	$submenu_font_style = get_option('sense_submenu_styles');
	$submenu_font_size = get_option('sense_submenu_size');	
		
	echo "
		body #navigation li ul.DropMenu li>a, body #navigation li ul.DropMenu li>span
		{	
		font-family: '" . $submenu_font_family . "' !important;  color: " . $submenu_font_color . "; font-style: " . $submenu_font_style . "; font-size: " . $submenu_font_size . " !important; 
		} 
		";			
		
		


	$is_h1_font_family = get_option('sense_h1_font');
	$is_h1_font_color = get_option('sense_h1_font_color');
	$is_h1_font_style = get_option('sense_h1_text');
	$is_h1_font_size = get_option('sense_text_h1');
	$is_h2_font_family = get_option('sense_h2_font');
	$is_h2_font_color = get_option('sense_h2_font_color');
	$is_h2_font_style = get_option('sense_h2_text');
	$is_h2_font_size = get_option('sense_text_h2');
	$is_h3_font_family = get_option('sense_h3_font');
	$is_h3_font_color = get_option('sense_h3_font_color');
	$is_h3_font_style = get_option('sense_h3_text');
	$is_h3_font_size = get_option('sense_text_h3');
	$is_h4_font_family = get_option('sense_h4_font');
	$is_h4_font_color = get_option('sense_h4_font_color');
	$is_h4_font_style = get_option('sense_h4_text');
	$is_h4_font_size = get_option('sense_text_h4');
	$is_h5_font_family = get_option('sense_h5_font');
	$is_h5_font_color = get_option('sense_h5_font_color');
	$is_h5_font_style = get_option('sense_h5_text');
	$is_h5_font_size = get_option('sense_text_h5');
	$is_h6_font_family = get_option('sense_h6_font');
	$is_h6_font_color = get_option('sense_h6_font_color');
	$is_h6_font_style = get_option('sense_h6_text');
	$is_h6_font_size = get_option('sense_text_h6');

	echo "
		.section.full-width-bg h1{font-family: " . $is_h1_font_family . " !important;  color: " . $is_h1_font_color . " !important; font-style: " . $is_h1_font_style . " !important; 	font-size: " . $is_h1_font_size . " !important; } 

		.section.full-width-bg h2 {font-family: " . $is_h2_font_family . " !important;  color: " . $is_h2_font_color . " !important; font-style: " . $is_h2_font_style . " !important; 	font-size: " . $is_h2_font_size . " !important; } 

	    .section.full-width-bg h3, .latest_news h3, .owl-carousel-container  h3 {font-family: " . $is_h3_font_family . " !important;  color: " . $is_h3_font_color . " !important; font-style: " . $is_h3_font_style . " !important; 	font-size: " . $is_h3_font_size . " !important; } 

	    .section.full-width-bg h4 {font-family: " . $is_h4_font_family . " !important;  color: " . $is_h4_font_color . " !important; font-style: " . $is_h4_font_style . " !important; 	font-size: " . $is_h4_font_size . " !important; } 

		.section.full-width-bg h5 {font-family: " . $is_h5_font_family . " !important;  color: " . $is_h5_font_color . " !important; font-style: " . $is_h5_font_style . " !important; 	font-size: " . $is_h5_font_size . " !important; } 

		.section.full-width-bg h6 {font-family: " . $is_h6_font_family . " !important;  color: " . $is_h6_font_color . " !important; font-style: " . $is_h6_font_style . " !important; 	font-size: " . $is_h6_font_size . " !important; } 
		";

	echo '</style>';		
}





?>