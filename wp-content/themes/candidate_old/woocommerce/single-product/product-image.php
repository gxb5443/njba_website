<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

?>

<!-- Product Gallery -->
<div class="shop-product-gallery animate-onscroll">
	
	<div class="main-image  images">

		<?php if ( $product->is_on_sale() ) : ?>

			<?php echo '<div class="shop-ribbon-sale"></div>'; ?>

		<?php endif; ?>
		
		<?php
		if ( has_post_thumbnail() ) {

			$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
			$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title' => $image_title
				) );

			$attachment_count = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}


			?>
			<img class="cloud-zoom-image" src="<?php echo $image_link; ?>"  alt="<?php echo $image_title; ?>" title="<?php echo $image_title; ?>" />
			
			<a itemprop="image" data-group="shop-jackbox" class="fullscreen-button woocommerce-main-image zoom jackbox" href="<?php echo $image_link; ?>" >
			
			<div class="fullscreen-icon">
			<i class="icons icon-resize-full"></i>
			</div>
			
			</a>
			<?php
			
			
		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $post->ID );

		}
		?>
		
		
	</div>
	
	
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
	
	
</div>
<!-- /Product Gallery -->









	


