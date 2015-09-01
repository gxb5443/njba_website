<?php
/**
 * Review order table
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( ! is_ajax() ) : ?><div id="order_review"><?php endif; ?>

	<table class="shop_table your-order-table animate-onscroll">
		<thead>
			<tr>
				<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>
	
		<tbody>
			<?php
				do_action( 'woocommerce_review_order_before_cart_contents' );

				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						?>
						<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
							
							<td class="order-product">
								<div class="product-thumbnail">
									<?php 
									$product_id = $_product->id;
									if( has_post_thumbnail($product_id) ) {
									echo get_the_post_thumbnail( $product_id, 'thumbnail' ); 
									} else {
									echo woocommerce_placeholder_img( 'shop_thumbnail' );
									} ?>
								</div>
								<p>
								<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ); ?>
								<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' ' . sprintf( '&times; %s', $cart_item['quantity'] ) . '', $cart_item, $cart_item_key ); ?>
								<?php echo WC()->cart->get_item_data( $cart_item ); ?>
								</p>
							</td>
							
							<th class="price">
								<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
							</th>
						</tr>
						<?php
					}
				}

				do_action( 'woocommerce_review_order_after_cart_contents' );
			?>
		</tbody>
	
		<tfoot>						
			<tr class="cart-subtotal">
				<th class="align-right"><?php _e( 'Cart Subtotal', 'woocommerce' ); ?></th>
				<th class="price"><?php wc_cart_totals_subtotal_html(); ?></th>
			</tr>

			<?php foreach ( WC()->cart->get_coupons( 'cart' ) as $code => $coupon ) : ?>
				<tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
					<th class="align-right"><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
					<td class="price"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
				</tr>
			<?php endforeach; ?>

			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

				<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

				<?php wc_cart_totals_shipping_html(); ?>

				<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

			<?php endif; ?>

			<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
				<tr class="fee">
					<th class="align-right"><?php echo esc_html( $fee->name ); ?></th>
					<td class="price"><?php wc_cart_totals_fee_html( $fee ); ?></td>
				</tr>
			<?php endforeach; ?>

			<?php if ( WC()->cart->tax_display_cart === 'excl' ) : ?>
				<?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
					<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
						<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
							<th class="align-right"><?php echo esc_html( $tax->label ); ?></th>
							<td class="price"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr class="tax-total">
						<th class="align-right"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
						<td class="price"><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></td>
					</tr>
				<?php endif; ?>
			<?php endif; ?>

		

			<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

			<tr class="order-total">
				<th class="align-right"><?php _e( 'Order Total', 'woocommerce' ); ?></th>
				<th class="price"><?php wc_cart_totals_order_total_html(); ?></th>
			</tr>

			<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
		</tfoot>
		
	
	</table>



<?php if ( ! is_ajax() ) : ?></div><?php endif; ?>