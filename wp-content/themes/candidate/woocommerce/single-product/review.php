<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
?>
<li itemprop="reviews" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

		<?php 
		
		echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '50' ), '', get_comment_author() ); ?>
		<div class="shop-rating read-only animate-onscroll" data-score="<?php echo $rating; ?>"></div>
		<h5><?php comment_author(); ?></h5>
		<span class="date"><?php echo get_comment_date( __( get_option( 'date_format' ), 'woocommerce' ) ); ?></span>

			<?php if ( $comment->comment_approved == '0' ) : ?>

				<p class="meta"><em><?php _e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em></p>

			<?php endif; ?>


			<p class="description"><?php comment_text(); ?></p>
		
	
