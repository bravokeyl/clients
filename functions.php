<?php
function bk_enqueue_scripts () {
	if (!is_admin()) {

		wp_register_style('portablsink-style', get_stylesheet_directory_uri() . '/bk.css', array('composer-plugins-stylesheet','composer-custom-css'), '1.0');

		wp_enqueue_style('portablsink-style');
		if(!is_front_page()) {
	    wp_enqueue_script ('bk-financing', 'https://vendor1.quickspark.com/one-liner.js?vc=254tqzq');
	  }
	}
}
add_action('wp_enqueue_scripts', 'bk_enqueue_scripts');

function bk_paypal_credit () {
	echo '<img src="'. get_stylesheet_directory_uri() .'/paypal.png" alt="bill-me-later" width="180" height="150" class="size-full paypal-billme" />';
}
add_action ( 'woocommerce_single_product_summary', 'bk_paypal_credit', 30);

add_filter( 'woocommerce_sale_price_html', 'bk_custom_sales_price', 10, 2 );

function bk_custom_sales_price( $price, $product ) {
    $yousave = round( ( $product->regular_price - $product->sale_price ) );
    return $price . sprintf( __('<div class="bk-price-save"><span class="saved">You save $%s</span></div>', 'woocommerce' ), $yousave );
}

add_filter('woocommerce_product_categories_widget_args', 'bk_show_empty_categories');

function bk_show_empty_categories($cat_args){
	$cat_args['hide_empty']=0;
	return $cat_args;
}

add_filter( 'woocommerce_product_tabs', 'bk_remove_product_tabs', 98 );
function bk_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );  	// Remove the additional information tab
    return $tabs;
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

add_action('wp_footer','bk_review_widget',25);
function bk_review_widget() {?>
	<script type='text/javascript'> var ucode='aHR0cHM6Ly9yZXZpZXd3aWRnZXQua3BpYW5hbHlzZXIuY29tLw=='; var code='ebdfb6cf47af6c4ac85b864f4acc3232'; var _rewF = document.createElement('script'); _rewF.type = 'text/javascript'; _rewF.async = true; _rewF.src = "https://reviewwidget.kpianalyser.com/js/reviews.js"; (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(_rewF); </script>
<?php }
