<?php
// custom plugin by yusuf eko n.
/**
 * Plugin Name: Malika Shortcode
 * Plugin URI: http://malika.id/
 * Description: Shortcode Product for Waorder theme
 * Version: 0.0.1
 * Author: Yusuf Eko N.
 * Author URI: http://malika.id/
 */
 
 //include '../../../wp-load.php';
 
 function malika_google_analityc(){
    ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-128606766-2"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'UA-128606766-2');
        </script>
    <?php
}

add_action( 'wp_head', 'malika_google_analityc' );
 
 // Add Font Family
add_filter( 'generate_typography_default_fonts', function( $fonts ) {
    $fonts[] = 'Avenir';
    $fonts[] = 'Poppins SemiBold';

    return $fonts;
} );

add_action('wp_head', 'sobad_style_font');
function sobad_style_font() {
    $link = '/wp-content/plugins/malika-shortcode/Font/style.css';
    echo '<link rel="stylesheet" id="avenir-font" href="'.$link.'" type="text/css" media="all">';
    
    $link = '/wp-content/plugins/malika-shortcode/Font/Poppins/style.css';
    echo '<link rel="stylesheet" id="poppins-font" href="'.$link.'" type="text/css" media="all">';
}

// Shortcode
 
 add_shortcode( 'malika-bundling-product', 'malika_bundling_product' );

function malika_bundling_product(){
	$query_args = array(
	    'post_type' 		=> 'product',
	    'post_status' 		=> 'publish',
		'product-category'  => 'bundling-produk',
	    'posts_per_page'	=> 4,
        'orderby' 			=> 'rand',//'date',
	    'order' 			=> 'DESC',
    );
	
	ob_start();
	malika__waorder_product($query_args);
	return ob_get_clean();
}

add_shortcode( 'malika-category-product', 'malika_category_product' );

function malika_category_product($atts){
    $a = shortcode_atts( array(
        'category'  => 'produk',
        'page'      => '4',
	), $atts );
	
	$category = explode(',',$a['category']);
    
	$query_args = array(
	    'post_type' 		=> 'product',
	    'post_status' 		=> 'publish',
		'product-category'  => $category,
	    'posts_per_page'	=> $a['page'],
        'orderby' 			=> 'rand',//'date',
	    'order' 			=> 'DESC',
    );
	
	ob_start();
	malika__waorder_product($query_args);
	return ob_get_clean();
}

add_shortcode( 'malika-release-product', 'malika_release_product' );

function malika_release_product(){
	$query_args = array(
	    'post_type' 		=> 'product',
	    'post_status' 		=> 'publish',
		//'post__in'			=> array('9564','7509','9582','6864'),
		'product-category'  => 'bohemian-style',
        'orderby' 			=> 'rand',//'date',
	    'order' 			=> 'DESC',
	    'posts_per_page'	=> 4
    );
	
	ob_start();
	malika__waorder_product($query_args);
	return ob_get_clean();
}

function malika__waorder_product($query_args=array()) {
    $post = '';
    $list = new WP_Query($query_args);
    
    if($list->have_posts()){
        ?>
            <style>
                .btn-waorder-malika {
                    text-align: center;
                    padding-bottom: 20px;
                }
                
                .btn-waorder-malika {
                    text-align: center;
                    padding-bottom: 20px;
                }
                
                .btn-waorder-malika button.order-button {
                    color: #fff;
                    border-radius: 18px;
                    font-weight: 700;
                    font-size: 12px;
                    width: 150px;
                    position: relative;
                }
                
                .btn-waorder-malika button.order-button i.icon.ion-logo-whatsapp {
                    font-size: 24px;
                    position: absolute;
                    left: 20px;
                }
                
            </style>
            
            <div class="boxcontainer clear">        
        <?php
        while($list->have_posts()){
            $list->the_post();
            
            ?>
					<article class="productbox">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<div class="content">
								<div class="thumb">
									<img class="lazy" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php echo get_the_title(); ?>">
									<?php
									$ribbon = get_post_meta(get_the_ID(), 'product_ribbon', true);
									?>
									<?php if( $ribbon ): ?>
										<span class="ribbon"><small class="text color-scheme-background"><?php echo $ribbon; ?></small></span>
									<?php endif; ?>
								</div>
								<div class="title">
									<h3><?php echo get_the_title(); ?></h3>
								</div>
								<div class="pricing">
									<?php
									$class = '';
									$price = get_post_meta(get_the_ID(), 'product_price', true);
									$price_slik = (int) get_post_meta(get_the_ID(), 'product_price_slik', true);
									if($price_slik){
									    $class = 'red-price';
									}
									?>
									<span class="price <?php print($class) ;?>">Rp <?php echo number_format($price,0,',','.'); ?></span>
									<?php if( $price_slik ): ?><span class="price_slik"><del>Rp <?php echo number_format($price_slik,0,',','.'); ?></del></span><?php endif; ?>
								</div>
								<div class="btn-waorder-malika">
								    <button type="button" class="order-button color-scheme-background" onclick="singleCartWA(this);"> 
								            <i class="icon ion-logo-whatsapp"></i>
								            <span style="margin-left: 30px;">Beli Sekarang</span> 
								    </button>
								</div>
							</div>
						</a>
					</article>
			<?php
        }
        
        ?>
            </div>
        <?php
        
        wp_reset_postdata();
    }
    
    return $post;
}