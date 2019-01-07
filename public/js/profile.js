$("#client_avatarFile").on('change', e=>{
    let input = e.target;
    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = e=>{
            $('#avatar-bg').css({
                'background':'url('+e.target.result+')',
                'background-size':'cover',
                'background-position': '50% 50%'
            });
        };
        reader.readAsDataURL(input.files[0]);
    }
});