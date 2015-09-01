<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $post;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

$num_comments1 = get_comments_number();
$num_rating1 = (int) $product->get_average_rating();
$price1 = $product->get_price();

?>

<div <?php post_class( 'col-lg-3 col-md-3 col-sm-6 mix ' ); ?> data-dateorder="<?php  echo $post->post_date; ?>" data-popularorder="<?php  echo $num_comments1; ?>" data-avgratingorder="<?php  echo $num_rating1; ?>" data-priceorder="<?php  echo $price1; ?>">

	<?php 
	$attachment_ids = $product->get_gallery_attachment_ids();
	 ?>
	 <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	
	
	
	<!-- Shop Item -->
	<div class="shop-item animate-onscroll">
		
		<div class="shop-image">
			<a href="<?php the_permalink(); ?>">
			
				<?php if ( $product->is_on_sale() ) : ?>

					<?php echo '<div class="shop-ribbon-sale"></div>'; ?>

				<?php endif; ?>
				
				
				<?php if ( !$product->is_in_stock() ) : ?>

					<?php echo '<div class="shop-ribbon-stock"></div>'; ?>

				<?php endif; ?>
				
				
				<div class="shop-featured-image">
				
					<?php if( has_post_thumbnail() ) {
					echo get_the_post_thumbnail( $product->id, 'th-shop' ); 
					} else {
					echo woocommerce_placeholder_img( 'shop_thumbnail' );
					} ?>
					
				</div>
				<?php if ( $attachment_ids ) { 
				$image_attributes = wp_get_attachment_image_src( $attachment_ids[0], 'th-shop'  );			
				?>
				<div class="shop-hover">
					<img src="<?php echo $image_attributes[0]; ?>" alt="">
				</div>
				<?php } ?>
				
			</a>
		</div>
		
		<div class="shop-content">
			
			<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<?php if ( $price_html = $product->get_price_html() ) : ?>
			<span class="price"><?php echo $price_html; ?></span>
			<?php endif; ?>
			
			<?php woocommerce_get_template( 'loop/rating.php' ); ?>
			
			
			<?php woocommerce_template_loop_add_to_cart(); ?>
			
			<a href="<?php the_permalink(); ?>" class="button details-button button-arrow transparent"><?php echo __('Details',THEMENAME);?></a>
			
		</div>
		
	</div>
	<!-- /Shop Item -->
	
	
	<?php //do_action( 'woocommerce_after_shop_loop_item' ); ?>
	
	
	

</div >