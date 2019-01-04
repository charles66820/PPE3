$('form').on('submit', function (e) {
    let form = $(this)[0];
    let action = form.action.value;
    let value = form.id.value;
    let url = form.id.dataset.src;

    if (action == 'quentityremove'){
        $.ajax({
            url: url.replace('%3Cvalue%3E',value),
            method: "get",
            contentType: false,
            success: function (result) {
                if (result.qty <= 0) {
                    $(form).parent().parent().parent().parent().remove();
                    if (result.lineCount <= 0){
                        $('#cartvoid').css({display: 'block'})
                    }
                } else {
                    let lineQty = $(form).parent().parent().prev().children().eq(0);
                    lineQty.text(result.qty);
                }
                $('#cartnumber').text(result.lineCount);
                $('#cartCount').text(result.lineCount);
                $('#cartPrice').text(result.totalPrice);
                $('#cartPriceHT').text(result.totalPriceHT);
            },
            error: function (error) {
                console.error(error.responseText);
            }
        });
    } else if (action == 'quentityadd'){
        $.ajax({
            url: url.replace('%3Cvalue%3E',value),
            method: "get",
            contentType: false,
            success: function (result) {
                let lineQty = $(form).parent().parent().prev().children().eq(0);
                lineQty.text(result.qty);
                $('#cartnumber').text(result.lineCount);
                $('#cartCount').text(result.lineCount);
                $('#cartPrice').text(result.totalPrice);
                $('#cartPriceHT').text(result.totalPriceHT);
            },
            error: function (error) {
                console.error(error.responseText);
            }
        });
    } else if (action == 'productremove'){
        $.ajax({
            url: url.replace('%3Cvalue%3E',value),
            method: "get",
            contentType: false,
            success: function (result) {
                $(form).parent().parent().parent().parent().remove();
                if (result.lineCount <= 0){
                    $('#cartvoid').css({display: 'block'})
                }
                $('#cartnumber').text(result.lineCount);
                $('#cartCount').text(result.lineCount);
                $('#cartPrice').text(result.totalPrice);
                $('#cartPriceHT').text(result.totalPriceHT);
            },
            error: function (error) {
                console.error(error.responseText);
            }
        });
    }
    return false;
});
$('#cartRemove').on('click', function (e) {
    $.ajax({
        url: e.target.dataset.src,
        method: "get",
        contentType: false,
        success: function (result) {
            $('#cartcontent').children().remove();
            if (result.lineCount <= 0){
                $('#cartvoid').css({display: 'block'})
            }
            $('#cartnumber').text(result.lineCount);
            $('#cartCount').text(result.lineCount);
            $('#cartPrice').text(result.totalPrice);
            $('#cartPriceHT').text(result.totalPriceHT);
        },
        error: function (error) {
            console.error(error.responseText);
        }
    });
});
