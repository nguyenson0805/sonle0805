<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>

$(document).ready(function() { 
        exceptJs('.tom-tat','...',100)
});
//CẮT CHUỖI EXCEPT------------------------------------------------------------------------------------->
function exceptJs($selector,$length,$readmoretext){
 $($selector).each(function(index){
      if($(this).text().length>1){
         $(this).text($(this).text().substr(0,$length)).append($readmoretext);
}
    else{
        $(this).text("Đây là nội dung")
       }
    });
}
//ADD IMAGE HEADER----------------------------------------------------------------------------------->
if($('.category-tin-tuc #main').index()==1)
{
$('.category-tin-tuc #main').append('<div class="img-cat"></div>');
$('.category-tin-tuc #main .img-cat').append('<h2 class="page-title-inner container "></h2>');
$('.category-tin-tuc #main .img-cat>h2').append($('#content > header > div > div > h1 > span').text());
}
//Langding page
function href_lading(){
if($('.home').index()!=1){
$( ".header-nav-main a" ).each(function() {
          $hash=$(this).attr('href');
          $host=window.location.hostname;
         $( this ).attr('href','http://'+$host+'/'+$hash);
});
}
}
//Tự động padding với text (fail only 2 size)---------------------------------------------------->
function auto_padding_text_fontsize(select){
var max=0;
var min=$(select).height();
$(select).each(function(){
          height=$(this).height();
          if(height>max){
          max=height;
          }
});
$(select).each(function(){
        if($(this).height()!=max){
         $(this).css("padding-bottom",max-$(this).height())
         }
});
}
//Sửa text quick view-------------------------------------------------------------------------------------------------->
function edit_text_quick_view(location,edit_text){
if($(location).index()!=-1){
    $(location).each(function(i){
   $(this).text(edit_text);
});
}
}
//Xem thêm show on hover(test)---------------------------------------------------------------------------------------------->
function link_quick_view(){
$('.hot-tours .product-small').each(function(){
             b=$(this).find('.product-title>a').attr('href');
              c="<div class='image-toolss grid-tools text-center hide-for-small bottom hover-slide-in show-on-hover'><a class='quick-views' href='"+b+"'></a></div>";
             $(this).find('.box-image').append(c);
             
});
$('.post-type-archive-product .product-small').each(function(){
             b=$(this).find('.product-title>a').attr('href');
              c="<div class='image-toolss grid-tools text-center hide-for-small bottom hover-slide-in show-on-hover'><a class='quick-views' href='"+b+"'></a></div>";
             $(this).find('.box-image').append(c);
             
});
$('.new-tours .product-small').each(function(){
             b=$(this).find('.product-title>a').attr('href');
              c="<div class='image-toolss grid-tools text-center hide-for-small bottom hover-slide-in show-on-hover'><a class='quick-views' href='"+b+"'></a></div>";
             $(this).find('.box-text').append(c);
             
});

}
</script>
