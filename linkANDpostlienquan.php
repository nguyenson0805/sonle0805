//Bài viết liên quan và đường dẫn
//BÀI VIếT LIÊN QUAN
<?php
<?php
function genre() {
global $post;
$id_post= get_the_ID();
$categories = get_the_category();
$cat= $categories[0]->term_id ;
$cat_name= $categories[0]->name ;
$vnkings = new WP_Query( array( 'cat' =>$cat ) );
$i=1;
?>

<div class="quan_tam">
	<h3><?=get_locale()!="en_US"?''.$cat_name.'LIÊN QUAN':''.$cat_name.' RELATED'?>
	</h3>
 <?php while ($vnkings->have_posts()) : $vnkings->the_post();
if($i<5&&$id_post!=get_the_ID()){
?>
<div class="bai_viet">
    <a href="<?php the_permalink() ;?>" class="tieu_de_bai_viet"><?php the_title();?></a>

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
