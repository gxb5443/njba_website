<?php
/**
 * @package by Theme Record
 * @auther: MattMao
 * @Custom post types
*/

/*
*
Add the Sidebar post type
*
*/
add_action('init', 'theme_create_post_type_sidebar');

function theme_create_post_type_sidebar() 
{
	$labels = array(
		'name' => __( 'Sidebars','mm_lang'),
		'singular_name' => __( 'Sidebar','mm_lang' ),
		'add_new' => __('Add New','mm_lang'),
		'add_new_item' => __('Add New Sidebar','mm_lang'),
		'edit_item' => __('Edit Sidebar','mm_lang'),
		'new_item' => __('New Sidebar','mm_lang'),
		'view_item' => __('View Sidebar','mm_lang'),
		'search_items' => __('Search Sidebar','mm_lang'),
		'not_found' => __('No sidebar found','mm_lang'),
		'not_found_in_trash' => __('No sidebar found in Trash','mm_lang'), 
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_ui' => true,
		'query_var' => false,
		'can_export' => true,
		'rewrite' => false,
		'hierarchical' => false,
		'has_archive' => false,
		'show_in_nav_menus' => false,
		'supports' => array('title', 'excerpt')
	); 
	register_post_type( 'sidebar' , $args );
}


#
#Prod edit columns
#
function prod_edit_columns_sidebar($columns)
{
	$columns = array();
	$columns['cb'] = '<input type=\'checkbox\' />';
	$columns['sidebar_name'] = __('Name', 'mm_lang');
	$columns['sidebar_shortcode'] = __('Shortcode', 'mm_lang');
	$columns['sidebar_desc'] = __('Description', 'mm_lang');
	$columns['sidebar_actions'] = __('Actions', 'mm_lang');
	
	return $columns;
}



#
#Prod custom columns
#
function prod_custom_columns_sidebar($column)
{
	global $post;

	$name = get_the_title();
	$shortcode = '[sidebar id="'.$post->ID.'"]';
	$desc = get_the_excerpt();

	switch ($column)
	{
		case 'sidebar_name' :	
			echo '<p>'. $name .'</p>';	
		break;
		
		case 'sidebar_shortcode' :	
			echo '<p><span>'. $shortcode .'</span></p>';	
		break;
		
		case 'sidebar_desc' :	
			echo '<p>'. $desc .'</p>';	
		break;	

		case 'sidebar_actions' :	
			echo '<p><a href="'. admin_url('post.php?post='.$post->ID.'&action=edit'). '">'. __('Edit', 'mm_lang'). '</a></p>';			
		break;		
	}
}



#
#Remove meta boxes
#
function theme_sidebar_meta_boxes() {
	remove_meta_box( 'slugdiv', 'sidebar' , 'normal' );
	
}












add_action('init', 'theme_create_post_type_slideshow');
add_filter('manage_edit-slideshow_columns', 'prod_edit_columns_slideshow');
add_action('manage_posts_custom_column',  'prod_custom_columns_slideshow');

function theme_create_post_type_slideshow() 
{
	$labels = array(
		'name' => __( 'Slides', 'mm_lang'),
		'singular_name' => __( 'Slides', 'mm_lang' ),
		'add_new' => __('Add New', 'mm_lang'),
		'add_new_item' => __('Add New Slide', 'mm_lang'),
		'edit_item' => __('Edit Slide', 'mm_lang'),
		'new_item' => __('New Slide', 'mm_lang'),
		'view_item' => __('View Slide', 'mm_lang'),
		'search_items' => __('Search Slide', 'mm_lang'),
		'not_found' => __('No slides found', 'mm_lang'),
		'not_found_in_trash' => __('No slides found in Trash', 'mm_lang')
	);

	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_ui' => true,
		'query_var' => false,
		'can_export' => true,
		'rewrite' => false,
		'hierarchical' => false,
		'has_archive' => false,
		'show_in_nav_menus' => false,
		'capability_type' => 'post',
		'menu_position' => 5, 
		'supports' => array('title', 'page-attributes', 'thumbnail', 'editor')
	); 

	register_post_type( 'slideshow' , $args );
}


function prod_edit_columns_slideshow($columns)
{
	$newcolumns = array(
		'cb' => '<input type=\"checkbox\" />',
		'slideshow_id' => __('ID',  'mm_lang'),
		'slideshow_thumbnail' => __('Featured Image',  'mm_lang'),
		'title' => __('Title',  'mm_lang')
	);
	
	$columns= array_merge($newcolumns, $columns);
	
	return $columns;
}


function prod_custom_columns_slideshow($column)
{
	
	global $post;

	$id = $post->ID;

	switch ($column)
	{
		case 'slideshow_id':
		echo '<p>'. $id .'</p>';	
		break;	

		case 'slideshow_thumbnail':
		if ( has_post_thumbnail() ) { the_post_thumbnail('archive-thumb'); } else { echo __('No featured image',  'mm_lang'); }
		break;	
	}
	
}






////////campaign//////////////////////////////////////////////////////////////////////////////////////////////////////////////
add_action('init', 'candidate_create_post_type_campaign');
add_filter('manage_edit-banners_columns', 'prod_edit_columns_campaign');
add_action('manage_posts_custom_column',  'prod_custom_columns_campaign');

function candidate_create_post_type_campaign() 
{
	$labels = array(
		'name' => __( 'Campaign', 'mm_lang'),
		'singular_name' => __( 'Campaign', 'mm_lang' ),
		'add_new' => __('Add New', 'mm_lang'),
		'add_new_item' => __('Add New', 'mm_lang'),
		'edit_item' => __('Edit Campaign', 'mm_lang'),
		'new_item' => __('New Campaign', 'mm_lang'),
		'view_item' => __('View Campaign', 'mm_lang'),
		'search_items' => __('Search Campaign', 'mm_lang'),
		'not_found' => __('No Campaign found', 'mm_lang'),
		'not_found_in_trash' => __('No Campaign found in Trash', 'mm_lang')
	);

	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_ui' => true,
		'query_var' => false,
		'can_export' => true,
		'rewrite' => false,
		'hierarchical' => false,
		'has_archive' => false,
		'show_in_nav_menus' => false,
		'capability_type' => 'post',
		'menu_position' => 5, 
		'supports' => array('title', 'thumbnail'),
	); 

	register_post_type( 'campaign' , $args );
}




function prod_edit_columns_campaign($columns)
{
	$newcolumns = array(
		'cb' => '<input type=\"checkbox\" />',
		'campaign_id' => __('ID',  'mm_lang'),
		'banners_thumbnail' => __('Campaign Image',  'mm_lang'),
		'title' => __('Title',  'mm_lang')
	);
	
	$columns= array_merge($newcolumns, $columns);
	
	return $columns;
}


function prod_custom_columns_campaign($column)
{
	
	global $post;

	$id = $post->ID;

	switch ($column)
	{
		case 'campaign_id':
		echo '<p>'. $id .'</p>';	
		break;	

		case 'banners_thumbnail':
		if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail'); } else { echo __('No featured image',  'mm_lang'); }
		break;	
	}
	
}










add_action('init', 'team_members'); 
add_action( 'init', 'my_testimonial' );
add_action( 'init', 'my_issues' );
add_action( 'init', 'portfolio_post' );


function team_members()  {  
  $labels = array(  
    'name' => __('Team', 'framework'),  
    'singular_name' => __('Team', 'framework'),  
    'add_new' => __('Add Member', 'framework'),  
    'add_new_item' => __('Add Member', 'framework'),  
    'edit_item' => __('Edit Member', 'framework'),  
    'new_item' => __('New Member', 'framework'),  
    'view_item' => __('View Member', 'framework'),  
    'search_items' => __('Search Member', 'framework'),  
    'not_found' =>  __('No Members found', 'framework'),  
    'not_found_in_trash' => __('No Members found in Trash', 'framework'),  
    'parent_item_colon' => ''  
  );  
  
  $args = array(  
    'labels' => $labels,  
    'public' => true,  
    'show_ui' => true,  
    'query_var' => true,  
    'rewrite' => true,  
    'show_in_nav_menus' => false,  
    'capability_type' => 'post',     
    'hierarchical' => false, 
    'exclude_from_search' => true,   
    'menu_position' => 5,  
    'supports' => array('title','editor','thumbnail')  
  );  
  register_post_type('team_members',$args);  
} 

add_action( 'init', 'create_team_taxonomies', 0 );
function create_team_taxonomies() {
	$args = array(
	    'hierarchical' => true,
	    'labels' => array('name'=>'Categories'), 
	    'public' => true,
	    'query_var' => true,
	    'show_ui' => true,
	     'rewrite' => true,
		'show_in_nav_menus' => false
	    );
	register_taxonomy('team-category', 'team_members', $args);
}












function my_testimonial() {
	global $data;
	register_post_type(
		'testimonial',
		array(
			'labels' => array(
				'name' => 'Testimonial',
				'singular_name' => 'testimonial'
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => true,
			'can_export' => true,
			'show_in_nav_menus' => false,
			'capability_type' => 'post',
			'menu_position' => 5, 		
			'supports' => array('title', 'editor','thumbnail') 
		)
	);
}


function my_issues() {
	global $data;
	register_post_type(
		'issues',
		array(
			'labels' => array(
				'name' => 'Issues',
				'singular_name' => 'issues'
			),
			'public' => true,
			'has_archive' => false,
			'rewrite' => true,
			'can_export' => true,
			'show_in_nav_menus' => false,
			'capability_type' => 'post',
			'menu_position' => 5, 		
			'supports' => array('title', 'editor','thumbnail') 
		)
	);
}


function portfolio_post()  {  
  $labels = array(  
    'name' => __('Portfolio', 'framework'),  
    'singular_name' => __('Portfolio', 'framework'),  
    'add_new' => __('Add Portfolio', 'framework'),  
    'add_new_item' => __('Add Portfolio', 'framework'),  
    'edit_item' => __('Edit Portfolio', 'framework'),  
    'new_item' => __('New Portfolio', 'framework'),  
    'view_item' => __('View Portfolio', 'framework'),  
    'search_items' => __('Search Portfolio', 'framework'),  
    'not_found' =>  __('No Portfolio found', 'framework'),  
    'not_found_in_trash' => __('No Portfolio found in Trash', 'framework'),  
    'parent_item_colon' => ''  
  );  
  
  $args = array(  
    'labels' => $labels,  
    'public' => true, 
    'query_var' => true,  
    'rewrite' => true,
    'show_in_nav_menus' => false,  
    'capability_type' => 'post',    
    'menu_position' => 5,  
    'supports' => array('title','editor','thumbnail','author','page-attributes','comments')  
  );  
  register_post_type('portfolio_post',$args);  
} 

add_action( 'init', 'create_portfolio_taxonomies', 0 );
function create_portfolio_taxonomies() {
	$args = array(
	    'hierarchical' => true,
	    'labels' => array('name'=>'Categories'), 
	    'public' => true,
	    'query_var' => true,
	    'show_ui' => true,
	     'rewrite' => true,
		'show_in_nav_menus' => false
	    );
	register_taxonomy('portfolio-category', 'portfolio_post', $args);
}

add_action( 'init', 'create_portfolio_taxonomies2', 0 );
function create_portfolio_taxonomies2() {
	$args = array(
	    'hierarchical' => true,
	    'labels' => array('name'=>'Tags'), 
	    'public' => true,
	    'query_var' => true,
	    'show_ui' => true,
	     'rewrite' => true,
		'show_in_nav_menus' => false
	    );
	register_taxonomy('portfolio-tags', 'portfolio_post', $args);
}


add_action( 'init', 'create_portfolio_taxonomies3', 0 );
function create_portfolio_taxonomies3() {
	$args = array(
	    'hierarchical' => true,
	    'labels' => array('name'=>'Skills'), 
	    'public' => true,
	    'query_var' => true,
	    'show_ui' => true,
	     'rewrite' => true,
		'show_in_nav_menus' => false
	    );
	register_taxonomy('portfolio-skills', 'portfolio_post', $args);
}



/*
*
Reorder portfolio
*
*/

function get_banners_category2($id = null){
	$categories = get_the_terms( $id, 'portfolio-category' );
	$res = '';
	if(!empty($categories)){
		foreach ( $categories as $val ) {
			$res .= $val->slug;
			$res .= ', ';
		}
	}
	return  $res;
}

function candidate_portfolio_print_scripts() {
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('candidate_portfolio_reorder', get_template_directory_uri().'/admin/js/banner_reorder.js');
}

function candidate_portfolio_reorder_page() {
	$add_submenu = 'add_submenu_page';
	$add_product_reorder = $add_submenu('edit.php?post_type=portfolio_post', 'Reorder', __('Reorder Portfolio',  'Candidate'), 'edit_posts', basename(__FILE__), 'candidate_portfolio_reorder');
	add_action('admin_print_scripts-' . $add_product_reorder, 'candidate_portfolio_print_scripts');
}

//add_action('admin_menu', 'candidate_portfolio_reorder_page');

function candidate_portfolio_reorder() {
	$args = array( 
		'post_status' => 'publish',
		'post_type' => 'portfolio_post',
		'order' => 'ASC',
		'orderby' => 'menu_order',
		'posts_per_page' => -1
	);

	global $post;
	$portfolios = new WP_Query($args);
?>
	<div class="wrap">
		<div id="icon-tools" class="icon32"><br /></div>
		<h2><?php _e('Reorder Portfolio',  'Candidate'); ?></h2>
		<p class="wp-reorder-message"><?php _e('Drag the portfolio to reorder.',  'Candidate'); ?></p>
		<ul id="portfolio-reorder-lists" class="wp-reorder-lists clearfix">
		<?php while( $portfolios->have_posts() ) : $portfolios->the_post(); ?>
		<?php if( get_post_status() == 'publish' ) { 
		$category1 = get_banners_category2($post->ID);
		
		?>
			<li id="<?php the_id(); ?>" class="menu-item" style="overflow:hidden; color:#ccc; float:left;  cursor: move; width:150px; height:220px; text-align:center; margin:0 10px 10px 0; background:#1E1E1F; border:1px solid #ccc;">
				<?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail'); } else { echo __('No image',  'Candidate'); } ?>
				<h4 class="menu-item-title" style="margin:0; " ><?php the_title(); ?></h4>
				<div class="blog-data" style="font-size:12px;line-height:12px; margin:0; color:#ccc;">
					<?php the_time('d'); ?> <span style="color:#fafafa;"><?php  the_time('M'); ?></span>
				</div>
				<p class="blog-info" style="margin:0; font-size:10px; font-style:italic;">
					<?php 
						$cur_terms = get_the_terms($post->ID, 'portfolio-category' );
					foreach($cur_terms as $cur_term) {
						echo ''. $cur_term->name .' ';
					} ?>
				</p>
				
				<ul class="menu-item-transport"></ul>
			</li>
		<?php } ?>
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
		</ul>
	</div>
<?php
}





function candidate_save_portfolio_order() {
    global $wpdb;
    $order = explode(',', $_POST['order']);
    $counter = 0;
    
    foreach($order as $portfolio_id) {
        $wpdb->update($wpdb->posts, array('menu_order' => $counter), array('ID' => $portfolio_id));
        $counter++;
    }
    die(1);
}

//add_action('wp_ajax_portfolio_reorder', 'candidate_save_portfolio_order');













?>