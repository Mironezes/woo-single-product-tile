<?php
/*
*
* Single Product Tile Widget
*
*/

if (!defined('ABSPATH')) {
	exit;
}

class WSPT_Single_Product_Tile_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'wspt_products_by_category',
			__('Single product tile', 'woo-single-product-tile') ,
			array(
				'description' => __('Output single product tile by a specific ID.', 'woo-single-product-tile')
			));
		}

		function form($instance) {
			$cat = (isset($instance[ 'cat' ])) ? $instance['cat'] : '';
			?>
			<p>

				<label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e( 'Product', 'woo-single-product-tile' ) ?></label>
				<select class='widefat' id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>">

					<?php
					$product_args = array(
						'taxonomy' => 'product',
						'orderby' => 'name',
						'order' => 'ASC',
						'limit' => 25,

						);
					$products = wc_get_products($product_args);
					foreach($products as $product) {
							?>
							<option value='<?php echo $product->get_id() ?>' <?php echo ($cat == $product->get_id()) ? 'selected' : ''; ?>><?php echo $product->get_name() ?></option>
							<?php
					}
					?>
				</select>
		</p>
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['cat'] = strip_tags($new_instance['cat']);

		return $instance;
	}

	function widget($args, $instance) {

		echo $args['before_widget'];

		?>
			<?php
			$arggs = array(
				'post_type' => 'product',
				'posts_per_page' => '1',
				'post__in'=> array($instance['cat']),
			);
			$loop = new WP_Query($arggs);

			while ($loop->have_posts()):
				$loop->the_post();
				global $product;
			?>

				<div class="product-tile">
					<div class="product-tile-img">
						<?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Produkt <?php the_title(); ?>" width="300px" height="300px" />'; ?>													
					</div>

					<div class="product-tile-content">	
						<div class="product-tile-main">
							<h3><?php the_title(); ?></h3>   

							<div class="product-tile-main-start-price">
								<span class="product-start-price__title">ab</span>
								<strong class="product-start-price__value"><?php the_field('product_start_price'); ?>€</strong>
							</div>	
						</div>
						<div class="product-tile-buttons">
							<?php the_field('product_link'); ?>
							<a href="<?php echo get_permalink(); ?>" class="decorated-button button">MEHR ERFAHREN</a>
						</div>									
					</div>										                	
				</div>

		<?php endwhile; ?>
		<?php wp_reset_query(); ?>	
		<?php
		echo $args['after_widget'];
	}
}

function single_product_tile_widget() {
	register_widget('WSPT_Single_Product_Tile_Widget');
}

add_action('widgets_init', 'single_product_tile_widget');
?>
