// При первом заходе на сайт

var preload;
var animated = false;

function preloadStart() {
    var currentFrame = 0;

    if (!animated) window.preload = setInterval(function () {
        switch (currentFrame) {
        case 0:
            $(".logo").width(75);
            $(".logo").height(55);
            currentFrame = 1;
            break;
        case 1:
            $(".logo").width(77);
            $(".logo").height(25);
            currentFrame = 2;
            break;
        case 2:
            $(".logo").width(51);
            $(".logo").height(57);
            currentFrame = 3;
            break;
        case 3:
            $(".logo").width(38);
            $(".logo").height(39);
            currentFrame = 4;
            break;
        case 4:
            $(".logo").width(75);
            $(".logo").height(26);
            currentFrame = 5;
            break;
        case 5:
            $(".logo").width(97);
            $(".logo").height(53);
            currentFrame = 0;
            break;
        }
    }, 700);

    animated = true;
}

// Выключаем прелоадер при первой загрузке страницы

function preloadLogoEnd() {
    clearInterval(window.preload);

    $(".logo").animate({
        width: 120,
        height: 67
    }, function () {
        $(".number-left").animate({
            opacity: 1,
            right: "3px"
        }, function () {
            $(".number-right").animate({
                opacity: 1,
                right: "-15px"
            });
        });
        setTimeout(function () {
            $(".logo").fadeOut(function () {
                $(".logo").children().hide();
            });

            setTimeout(function () {
                $(".mask").fadeOut()
            }, 1400);
        }, 1000);
    });

    animated = false;
}

// Вызов прелоадера при переходе между страницами

function preloadFadeIn() {
    var currentFrame = 0;

    if (!animated) {
        $(".mask").fadeIn(function () {
            $(".logo").show();
            $(".logo").animate({
                opacity: 1
            });
        });
        
        window.preload = setInterval(function () {
            switch (currentFrame) {
            case 0:
                $(".logo").width(75);
                $(".logo").height(55);
                currentFrame = 1;
                break;
            case 1:
                $(".logo").width(77);
                $(".logo").height(25);
                currentFrame = 2;
                break;
            case 2:
                $(".logo").width(51);
                $(".logo").height(57);
                currentFrame = 3;
                break;
            case 3:
                $(".logo").width(38);
                $(".logo").height(39);
                currentFrame = 4;
                break;
            case 4:
                $(".logo").width(75);
                $(".logo").height(26);
                currentFrame = 5;
                break;
            case 5:
                $(".logo").width(97);
                $(".logo").height(53);
                currentFrame = 0;
                break;
            }
        }, 700);
        
    }
    
    animated = true;
}

// Выключение прелоадера при полной загрузке контента

function preloadFadeOut() {

    if (animated) {        
        setTimeout(function () {
            $(".logo").fadeOut(function () {
                $(".mask").fadeOut(function () {                    
                    clearInterval(window.preload);
                });
            });
        }, 2000);
    }

    animated = false;

}