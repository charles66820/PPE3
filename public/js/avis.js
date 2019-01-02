//permet de gérer le hover et la selection des étoiles
let selectstar = 0;
let laststar = 6;
$('#starsselecteur').children().on('click',function(){
    selectstar = $(this).attr("data-star");
    if (selectstar == laststar) {
        selectstar = 0;
        $('#starsselecteur').removeClass().addClass('stars0').children().last().val(selectstar);
        laststar = 0;
    } else {
        $('#starsselecteur').removeClass().addClass('stars'+selectstar).children().last().val(selectstar);
        laststar = selectstar;
    }
    console.log(selectstar);
}).on('mouseover', function(){
    $('#starsselecteur').removeClass().addClass('stars'+$(this).attr("data-star"));
}).on('mouseleave', function(){
    $('#starsselecteur').removeClass().addClass('stars'+selectstar);
});
