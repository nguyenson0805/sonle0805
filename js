<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>

$(document).ready(function() { 
        exceptJs('.tom-tat','...',100)
});
//CẮT CHUỖI EXCEPT
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
</script>
