<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>


	<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

					?>
					<div class="cart-item">
					
						<div class="featured-image">
							<?php if( has_post_thumbnail($product_id) ) {
								echo get_the_post_thumbnail( $product_id, 'thumbnail' ); 
								} else {
								echo woocommerce_placeholder_img( 'shop_thumbnail' );
								} ?>
							
						</div>
					<div class="item-content">
													<h6><a href="<?php echo get_permalink( $product_id ); ?>"><?php echo $product_name; ?></a></h6>
													<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="price">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
													
								
						<div class="remove-item">
								<?php
									echo apply_filters('woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="delete parent-color" title="%s">%s</a>', esc_url($woocommerce->cart->get_remove_url($cart_item_key)), __('Remove', 'woocommerce'), '<i class="icons remove-shopping-item icon-cancel-circled"></i>'), $cart_item_key);
								?>
														
						</div>
					</div>
	
					</div>
					<?php
				}
			}
		?>

	<?php else : ?>
		<div class="cart-item empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></div>
		
	<?php endif; ?>


<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

	<div class="cart-item">
		<h6><?php _e( 'Cart subtotal', 'woocommerce' ); ?>: <?php echo WC()->cart->get_cart_subtotal(); ?></h6>
	</div>
	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<div class="cart-item">
		<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="button"><?php _e( 'View Cart', 'woocommerce' ); ?></a>
		<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="button donate"><?php _e( 'Checkout', 'woocommerce' ); ?></a>
	</div>


<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>