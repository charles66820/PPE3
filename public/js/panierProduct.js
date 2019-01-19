$('#addCartForm').on('submit', function (e) {
    let form = $(this)[0];
    let value = form.id.value;
    let qty = form.qty.value;
    let url = form.id.dataset.src;
    let finalUrl = url.replace('1',qty);

    $.ajax({
        url: finalUrl.replace('%3Cvalue%3E',value),
        method: "get",
        contentType: false,
        success: function (result) {
            if (result.lineCount) {
                $('#btndone').text('Voire le panier');
                $('#confirme').modal('show');
                $('#modalbody').html('<p>'+result.msg+'<p>');
                $('#cartnumber').text(result.lineCount);
            } else {
                $('#btndone').text('Se connecté');
                $('#modalbody').html('<p>Pour ajouter des articles panier connectez-vous<p>');
                $('#confirme').modal('show');
            }
        },
        error: function (error) {
            console.error(error.responseText);
        }
    });
    return false;
});
