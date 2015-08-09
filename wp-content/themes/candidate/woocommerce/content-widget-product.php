<?php global $product; ?>
<li>
	<div class="featured-image">
		<?php echo $product->get_image(); ?>
	</div>
	<div class="shop-item-content">
		<h6><a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>" ><?php echo $product->get_title(); ?></a></h6>
		<span class="price"><?php echo $product->get_price_html(); ?></span>
		
		<?php 
		$average = $product->get_average_rating();
		?>
		<div class="shop-rating read-only-small" data-score="<?php echo esc_html( $average ); ?>"></div>
		
	</div>
</li>