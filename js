<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>

$(document).ready(function() { 
        catchuoi('.tom-tat','...',100)
});
//CẮT CHUỖI EXCEPT
function catchuoi($element,$readmore,$limit){
var ecnd=$($ele).text().substr(0,100);
if(ecnd){
$('.tom-tat').text(ecnd);
kl=$('.tom-tat').append($rm);
console.log(kl.text());
}
}
</script>
