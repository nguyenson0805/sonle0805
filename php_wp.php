<?php //Add_category custom post 
function add_custom_types_to_tax( $query ) {
if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
 
// Get all your post types
$post_types = get_post_types();
 
$query->set( 'post_type', $post_types );
return $query;
}
}
add_filter( 'pre_get_posts', 'add_custom_types_to_tax' );
//THÊM LIÊN HỆ--------------------------------------------------------------------------------->
function devvn_wc_custom_get_price_html( $price, $product ) {
    if ( $product->get_price() == 0) {
        if ( $product->is_on_sale() && $product->get_regular_price() ) {
            $regular_price = wc_get_price_to_display( $product, array( 'qty' => 1, 'price' => $product->get_regular_price() ) );
 
            $price = wc_format_price_range( $regular_price, __( 'Free!', 'woocommerce' ) );
        } else {
            $price = '<span class="amount">' . __( 'Liên Hệ', 'woocommerce' ) . '</span>';
        }
    }
    return $price;
}
add_filter( 'woocommerce_get_price_html', 'devvn_wc_custom_get_price_html', 10, 2 );
// GET THUỘC TÍNH RA PRODUCT---------------------------------------------------------------------------->
function get_more(){
global $product;
$koostis = $product->get_attribute( 'loại' );
$k = $product->get_attribute( 'nhà cung cấp' );
$stock_status = $product->get_stock_status();
if($stock_status=="outofstock"){
	$tt="Hết hàng";
}elseif ($stock_status=="instock") {
	$tt="Còn hàng";
}else{
	$tt="Chờ lấy";
}
$tt;
echo '<p><strong>Loại:</strong> '.$koostis.'</p>';
echo '<p><strong>Cung cấp bởi:</strong> '.$k.'</p>';
echo '<p><strong>Trạng thái:</strong> '.$tt.'</p>';
}
add_action('woocommerce_single_product_summary','get_more');
//Tạo bảng mete box-------------------------------------------------------------------------------------------------------------->
function son_meta_box(){
	add_meta_box('thong-tin','Thông tin tour','son_thongtin_output','product');
}
add_action('add_meta_boxes','son_meta_box');
//Thêm input
function son_thongtin_output( $post )
{
 $ngay_khoi_hanh = get_post_meta( $post->ID, '_ngay_khoi_hanh', true );
 $so_cho_trong = get_post_meta( $post->ID, '_so_cho_trong', true );
 // Tạo trường Link Download
 echo ( '<label for="ngay_khoi_hanh">Ngày khởi hành: </label>' );
 echo ('<input type="date" id="ngay_khoi_hanh" name="ngay_khoi_hanh" value="'.esc_attr( $ngay_khoi_hanh ).'" /><br>');
  echo ( '<label for="so_cho_trong">Số chỗ trống: </label>' );
 echo ('<input type="number" id="so_cho_trong" name="so_cho_trong" value="'.esc_attr( $so_cho_trong ).'" />');
}
//Lưu thông tin nhập
function son_thongtin_save( $post_id )
{
 $ngay_khoi_hanh  = sanitize_text_field( $_POST['ngay_khoi_hanh'] );
 update_post_meta( $post_id, '_ngay_khoi_hanh',$ngay_khoi_hanh);
  $so_cho_trong  = sanitize_text_field( $_POST['so_cho_trong'] );
 update_post_meta( $post_id, '_so_cho_trong',$so_cho_trong);
}
add_action( 'save_post', 'son_thongtin_save' );
//in thông tin ra
function get_more(){
global $post;
 $ngay_khoi_hanh = get_post_meta( $post->ID, '_ngay_khoi_hanh', true );
  $so_cho_trong = get_post_meta( $post->ID, '_so_cho_trong', true )." chỗ trống";
  $SKU= get_post_meta( $post->ID, '_sku', true );
 // Tạo trường Link
  $array=array("Số chỗ trống"=>$so_cho_trong,
  	           "Ngày khởi hành"=>$ngay_khoi_hanh,
               "SKU"=>$SKU
                );
  foreach ($array as $key => $value) {
  	echo '<li><span class="icon-info">
					<i class="fa fa-check-square-o" aria-hidden="true"></i>'.$key.': 
									</span>
									<span class="info">'.$value.'</span>
								</li>';
  }
  echo do_shortcode('[contact-form-7 id="32" title="Contact form 1"]');

}
add_action('woocommerce_single_product_summary','get_more');
//IN THUỘC TINH RA PRODUCT SMALL
function add_iteam_single_product(){
  global $post;
  $ngay_khoi_hanh = get_post_meta( $post->ID, '_ngay_khoi_hanh', true );
  if($ngay_khoi_hanh ){
  echo '<span class="pull-left fix-size-collections">
				<b>Khởi hành: </b>'.$ngay_khoi_hanh.'
			</span>';
		}
   
}
add_action('woocommerce_after_shop_loop_item_title','add_iteam_single_product');
// TẠO LINK XEM CHI TIẾT--------------------------------------------------------------------------------------------------------------->
function add_view_more(){
	global $post;
  echo '<a href="'.get_permalink($post->ID).'">Xem chi tiết
									<i class="fa fa-long-arrow-right"></i>
								</a>';
   
}
add_action('woocommerce_before_shop_loop_item_title','add_view_more');
// CẮT CHUỖI EXCERPT ALL POST--------------------------------------------------------------------------------------------------------->
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
