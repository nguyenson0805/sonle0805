//Bài viết liên quan và đường dẫn
//BÀI VIếT LIÊN QUAN
<?php
function genre( $atts, $content = null ) {
global $post;
$categories = get_the_category_list( ', ', '', $post->ID );
$vnkings = new WP_Query(array(
'post_type'=>'post',
'post_status'=>'publish',
'cat_name' => $categories,
//thay id_của_category bằng id danh mục bạn muốn hiển thị nhé
'orderby' => 'ID',
'order' => 'DESC',
'posts_per_page'=> 5));
$i=1;
?>

<h3> Có thể bạn quan tâm</h3>
<div class="quan_tam">
 <?php while ($vnkings->have_posts()) : $vnkings->the_post();
if($i<5){
?>
<div class="bai_viet">
    <a href="<?php the_permalink() ;?>" class="anh_bai_viet"> 
        <?php the_post_thumbnail();?>
    </a>
    <a href="<?php the_permalink() ;?>" class="tieu_de_bai_viet"><?php the_title() ;?></a>

</div>
<?php } $i++; endwhile ; ?></div><?php wp_reset_query() ;}
add_shortcode("genre", "genre");
//ĐƯỜNG DẪN
function custom_breadcrumb() {
			global $post;
            echo '<div class="duong_dan">';
			if(!is_front_page()){
				echo '<li> <a href="'.home_url().'">Trang chủ<i class="icon-angle-right"></i></a></li>';
			}
 
			if(is_singular(array('post'))){
				$cats=get_the_category();
				$catName=$cats[0]->name;
				$catID=get_cat_ID( $catName );
				$catLink=get_category_link($catID);
				echo '<li> <a href="'.$catLink.'">'.$catName.'<i class="icon-angle-right"></i></a></li>';
				$curTitle=get_the_title(($post->ID),0,100);
				$curTitle=(strlen($curTitle) >100)?substr($curTitle,0,100).'...':$curTitle;
				echo '<li class="active">'.$curTitle.'</li>';
			}
			// Your custom post type - Portfolio here
			if(is_singular(array('portfolio'))){
				$pType= get_terms('portfolio_type'); 
				if(is_array($pType)&& count($pType)>0){
					$portLink="#";
					$portName=$pType[0]->name;
					echo '<li> <a href="'.$portLink.'">'.$portName.'<i class="icon-angle-right"></i></a></li>';
				}
			}
			if(is_page()){ 
				$postParents=get_post_ancestors($post->ID);
				if(is_array($postParents) && count(($postParents)>0)){
					foreach ($postParents as $key => $value) {
						$pageLink=get_permalink($value);
						$pageTitle=get_the_title($value);
						echo '<li> <a href="'.$pageLink.'">'.$pageTitle.'<i class="icon-angle-right"></i></a></li>';
					}
				}
				$curTitle=get_the_title(($post->ID),0,100);
				$curTitle=(strlen($curTitle) >100);
				echo '<li class="active">'.$curTitle.'</i></li>';
 
 
			}
			if(is_category()){ 
				$category = get_category(get_query_var('cat'));
				$cat_id = $category->cat_ID;
				$theCat=get_cat_name($cat_id);
				echo '<li class="active">'.$theCat.'<i class="icon-angle-right"></i></a></li>';
			}
			if(is_tag()){
				echo '<li class="active">'.get_query_var('tag').'<i class="icon-angle-right"></i></a></li>';
			}
			if(is_author()){ 		
				echo '<li class="active">'. get_the_author_meta('user_nicename').'<i class="icon-angle-right"></i></a></li>';
			}
						if(is_search()){ 		
				echo '<li class="active">'. get_search_query().'<i class="icon-angle-right"></i></a></li>';
			}
			echo '</div>';
 
}
add_shortcode("custom_breadcrumb", "custom_breadcrumb");
