(()=>{
    let btnGoToTop = document.getElementById("btnGoToTop");
    let lock = false;

    window.addEventListener('scroll',function (e) {
        if (document.body.scrollTop > 60 || document.documentElement.scrollTop > 60) {
            // lock = false;
            btnGoToTop.classList.remove("hideBtnGoToTop");
            btnGoToTop.classList.add("showBtnGoToTop");
        } else {
            if (lock || (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20)) {
                btnGoToTop.classList.remove("showBtnGoToTop");
                btnGoToTop.classList.add("hideBtnGoToTop");
                lock = false;
            }
        }
    });

    btnGoToTop.addEventListener('webkitAnimationEnd',function (e) {
        console.log(e);
        lock = true;
    });

    btnGoToTop.addEventListener('click', function () {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    })
})();