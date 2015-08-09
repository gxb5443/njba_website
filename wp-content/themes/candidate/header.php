<!DOCTYPE html>



<?php
/* Global Variables */
$bg_image_repeat = 'no-repeat';
$bg_image_attachment = 'fixed';

	if(get_option('sense_settings_background_attachment') != '') {
	$bg_image_attachment = get_option('sense_settings_background_attachment');
	}
	
	if(get_option('sense_settings_bg_repeat') != '') {
	$bg_image_repeat = get_option('sense_settings_bg_repeat');
	}
?>

<!--[if lte IE 8]>              <html class="ie8 no-js" <?php language_attributes(); ?>>     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js no-fouc" <?php language_attributes(); ?>>  <!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' );?>" />
<meta name="description" content="<?php bloginfo( 'description' );?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta property="og:title" content="<?php wp_title( '|', true, 'right' ); ?>" />
<meta property="og:description" content="<?php bloginfo( 'description' );?>" />
<meta property="og:type" content="cause" />

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php wp_title( '|', true, 'right' ); ?>">
<meta name="twitter:description" content="<?php bloginfo( 'description' );?>">


	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	
	<!--[if IE 9]>
		<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/css/ie9.css">
	<![endif]-->
	
	<!--[if lt IE 9]>
		<link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/jackbox-ie8.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/css/ie.css">
	<![endif]-->
	
	<!--[if gt IE 8]>
		<link href="<?php echo esc_url(get_template_directory_uri()); ?>/css/jackbox-ie9.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	
	<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo esc_url(get_template_directory_uri()); ?>/css/fontello-ie7.css">
	<![endif]-->
	
	
<!--[if lt IE 9]>
	<script src="js/selectivizr-and-extra-selectors.min.js"></script>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
	<![endif]-->
	
	<style type="text/css">
		.no-fouc {display:none;}
	</style>
	

	

	<?php
		wp_head();
	?>	
	

	
	<?php
	if(get_option('sense_settings_loading') != 'hide') {
	?>		
		
	<script type="text/javascript">
		(function($) {

		$(document).ready(function(){
		
			$('html').show();
			
			var window_w = $(window).width();
			var window_h = $(window).height();
			var window_s = $(window).scrollTop();
			
			$("body").queryLoader2({
				backgroundColor: '#f2f4f9',
				barColor: color_loader,
				barHeight: 4,
				percentage:false,
				deepSearch:true,
				minimumTime:1000,
				onComplete: function(){
					
					$('.animate-onscroll').filter(function(index){
					
						return this.offsetTop < (window_s + window_h);
						
					}).each(function(index, value){
						
						var el = $(this);
						var el_y = $(this).offset().top;
						
						if((window_s) > el_y){
							$(el).addClass('animated fadeInDown').removeClass('animate-onscroll');
							setTimeout(function(){
								$(el).css('opacity','1').removeClass('animated fadeInDown');
							},2000);
						}
						
					});
					
				}
			});
			
		});
		
		})(jQuery);	
	</script>
	
	
	<?php
	}
	?>	
	


	<?php
	if(get_option('sense_settings_loading') == 'hide') {
	?>
	
	
	
	<script type="text/javascript">
		(function($) {

		$(document).ready(function(){
		
			$('html').show();
			
			var window_w = $(window).width();
			var window_h = $(window).height();
			var window_s = $(window).scrollTop();
			

					
					$('.animate-onscroll').filter(function(index){
					
						return this.offsetTop < (window_s + window_h);
						
					}).each(function(index, value){
						
						var el = $(this);
						var el_y = $(this).offset().top;
						
						if((window_s) > el_y){
							$(el).addClass('animated fadeInDown').removeClass('animate-onscroll');
							setTimeout(function(){
								$(el).css('opacity','1').removeClass('animated fadeInDown');
							},2000);
						}
						
					});
					
		
			
		});
		
		})(jQuery);	
	</script>
	
	
	
	
	
	
	<?php
	}
	?>
	
	

	
</head>

<?php
$bg_color = '';
$bg_image = '';

echo '<style>';

	if(get_option('sense_background1') != '') {
	$bg_image = get_option('sense_background1');
	}
	if(get_option('sense_select_bg_color1') != '') {
	$bg_color = get_option('sense_select_bg_color1');
	}

	if(get_option('sense_checkboxbackground1') == 'theme' || get_option('sense_checkboxbackground1') == '') {
	
		if(get_option('sense_settings_layout_img') == 'pattern_1') {
		$bg_image = get_template_directory_uri() .'/img/background/1.jpg';
		}
		if(get_option('sense_settings_layout_img') == 'pattern_2') {
		$bg_image = get_template_directory_uri() .'/img/background/2.jpg';
		}
		if(get_option('sense_settings_layout_img') == 'pattern_3') {
		$bg_image = get_template_directory_uri() .'/img/background/3.jpg';
		}
	
	echo 'body, body.boxed-layout { background: '. esc_attr($bg_color) .'  url("'. esc_url($bg_image) .'")  '. esc_attr($bg_image_repeat) .' '. esc_attr($bg_image_attachment) .'; }';   
	}
	
    if(get_option('sense_checkboxbackground1') == 'color' ) {
	echo 'body, body.boxed-layout { background-color: '. esc_attr($bg_color) .'; background-image:none;}';
	}
	
	if(get_option('sense_checkboxbackground1') == 'custom' ) {
	echo 'body, body.boxed-layout { background: url("'. esc_url($bg_image) .'") '. esc_attr($bg_image_repeat) .' '. esc_attr($bg_image_attachment) .'; }';  
	}

	
	
	if(get_option('sense_show_breadcrumb_title') == 'hide' ) {
	echo '.page-heading{ display: none; }';  
	}
	
	
echo '</style>';

?>


<body <?php body_class(); ?> >

 <div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
 
	
	
	
	
	<!-- Container -->
	<div class="container">

	<!-- Header -->
	<header id="header" class="animate-onscroll">
		
		<!-- Main Header -->
		<div id="main-header">
			
			<div class="container">
			
			<div class="row">

				<!-- Logo -->
				<div id="logo" class="">
					<?php if(get_option('sense_settings_logo') == 'show_image')
						{
						?>
						<a href="<?php echo esc_url(home_url('/')); ?>" class="logo" style="" >
						   <img class="logo_img" alt="Logo" src="<?php echo esc_url(get_option('sense_logo_image_loft')); ?>"/>
						</a>
					<?php } else { ?>
						<h1>
							<a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
							<?php echo esc_html(get_option('sense_logo_text_loft'));  ?>
							</a>
						</h1>
					<?php } ?>
				</div>
				<!-- /Logo -->
		
				<!-- Main Quote -->
				<div class="main_quote ">
					<?php if(get_option('sense_show_slogan_top') == 'show')
						{
						?>
					<?php echo get_option('sense_header_text');  ?>
					<?php } ?>
				</div>
				<!-- /Main Quote -->
						
				<!-- Newsletter -->
				<div class="top_newsletter ">
					<?php if(get_option('sense_show_topform') == 'show')
						{
							
						$top1 = get_option('sense_top_text1');	
						$top2 = get_option('sense_top_text2');	
							
						?>
					<form id="newsletter" action="#" method="POST" style="display:block!important;" >
						<span class="ajax-loader"></span>
						
						<?php echo get_option('sense_top_title1'); ?>
						
						
						<div class="newsletter-form">
						
							<div class="newsletter-email">
								<input id="s-email" type="text" name="email" placeholder="<?php echo $top1; ?>">
							</div>
							
							<div class="newsletter-zip">
								<input type="text" name="newsletter-zip" placeholder="<?php echo $top2; ?>">
							</div>
							
							<div class="newsletter-submit">
								<input type="submit" id="signup_submit" name="newsletter-submit" value="">
								<i class="icons icon-right-thin"></i>
							</div>
							
						</div>
						<div id="mailchimp-sign-up1" ><p>.</p></div>
					</form>
					<?php } ?>
					
					
				</div>
				<!-- /Newsletter -->
	
			</div>
			
			</div>
			
		</div>
		<!-- /Main Header -->
	
	
	<!-- Lower Header -->
	<div id="lower-header">
		
		<div class="container">
		
		<div id="menu-button">
			<div>
			<span></span>
			<span></span>
			<span></span>
			</div>
			<span><?php _e( 'Menu', THEMENAME ); ?></span>
		</div>
	

		<?php  if (has_nav_menu('main_navigation')) :
				wp_nav_menu( array(
				'theme_location' => 'main_navigation',
				'container' => false,
				 'menu_class' => '',
				 'menu_id' => 'navigation',
				 'echo' => true,
				 'depth' => 4,
				 'fallback_cb'=> '',
				 'walker' => new candidate_Nav_Walker()
				));
				endif; 		
		?>
	
		</div>
					
	</div>
	<!-- /Lower Header -->
	</header>
	<!-- /Header -->