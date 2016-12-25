<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

$page_layout = composer_get_option_value( 'shop_sidebar', 'full-width' );
$selected_sidebar_replacement = composer_get_option_value( 'shop_select_sidebar', 0 );

?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		do_action( 'woocommerce_before_main_content' );

		if ( $page_layout == 'right-sidebar' || $page_layout == 'left-sidebar' ) {
			echo '<div class="row padding-top">';

			echo '<div class="col-md-9 '. esc_attr($page_layout ).'">';
		}
	?>

		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

		<?php if ( have_posts() ) :
			$bkloop = 0;
			?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			<div class="loadmore-wrap">
				<?php woocommerce_product_loop_start(); ?>

					<?php woocommerce_product_subcategories(); ?>
						<div class="load-container">
							<?php while ( have_posts() ) : the_post(); ?>

								<?php wc_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>
						</div>
				<?php woocommerce_product_loop_end(); ?>

				<?php
					$prefix = composer_get_prefix();

				    //Pagination
				    $pagination = composer_get_option_value($prefix.'pagination', 'load_more'); // default, load_more, autoload

				    $loadmore_text = composer_get_option_value( $prefix.'loadmore_text', esc_html__( 'Load More', 'my-event' ) );
				    $allpost_loaded_text = composer_get_option_value( $prefix.'allpost_loaded_text', esc_html__( 'All Posts Loaded', 'my-event' ) );

				    // Arguements array
				    $shop_count = composer_get_option_value( 'shop_count', 8 );

				    $args = array(
				    	'post_type'	=> 'product',
				    	'posts_per_page' => $shop_count
				    );

				    // Values array
				    $values = array();

					$values['style']               = $pagination;
					$values['loadmore_text']       = $loadmore_text;
					$values['allpost_loaded_text'] = $allpost_loaded_text;
					$values['action']              = 'shop_loadmore';

				    echo composer_pagination( $args, $values ); // args, values
				?>
			</div>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				//do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */

		if ( $page_layout == 'right-sidebar' || $page_layout == 'left-sidebar' ) {

			echo '</div>'; //col-md-9

			//If the sidebar position is right or left sidebar, it ll apply
	        if( 'full-width' != $page_layout ){
	            composer_sidebar( $selected_sidebar_replacement , 'shop' );
	        }

			echo '</div>'; //row
		}

		do_action( 'woocommerce_after_main_content' );
	?>

<?php get_footer( 'shop' ); ?>
