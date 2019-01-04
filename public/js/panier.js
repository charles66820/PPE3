$('form').on('submit', function (e) {

    console.log($(this)[0].action.value);
    console.log($(this)[0].id.value);

    // $.ajax({
    //     url: "/assets/php/editprofil.php",
    //     method: "get",
    //     contentType: false,
    //     success: function (result) {
    //         console.log(result);
    //     },
    //     error: function (error) {
    //         console.error(error.responseText);
    //     }
    // });
    return false;
});
$('#cartRemove').on('click', function (e) {
    alert('remove cart '+e.target.dataset.src);
});
