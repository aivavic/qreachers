//loader
$(document).ready(function () {
    $(".logo").click(function () {
        $(this).css("animationName", "none");
        $(".logo").animate({
            height: "45px",
            width: "80px"
        }, 10);
    });
    
    var containerHeight = $(window).height() - $("footer").outerHeight() - $("nav").height();
    $(".main-container").css({"min-height": containerHeight });
});

$(".filter-btn").click(function (e) {
    e.preventDefault();

    $(this).animate(function () {
        opacity: 1
    }, 200, function () {
        $(".filter-box").animate({
            height: $(".tags-box").outerHeight() + 15
        }, 200);
        $(".filter-btn").hide();
        $(".tags-close").fadeIn();
        $(".tags-box").addClass("opened-tags");
    });
});

$(".tags-close").click(function (e) {
    e.preventDefault();

    $(".tags-box").removeClass("opened-tags");
    $(this).fadeOut();
    setTimeout(function () {
        $(".filter-btn").fadeIn();
        $(".filter-box").animate({
            height: 145
        }, 200);
    }, 400);

});

$(".burger").click(function () {
    if ($(".dropdown").height() < 1) {
        if ($(window).height() > 400)
            $(".dropdown").height($(window).height() - 90);
        else {
            $(".dropdown").addClass("horisontal-nav");
            $(".dropdown").height($(window).height() - 90);
        }

        $(".burger").addClass("active");
        $(".drop-wrap").fadeIn(400, function () {
            $(".lang-box").fadeIn();
        });
        $(".nav-item").click(function () {
            $(".burger").removeClass("active");
            $(".lang-box").fadeOut(50, function () {
                $(".drop-wrap").fadeOut(function () {
                    $(".dropdown").removeClass("horisontal-nav");
                    $(".dropdown").height(0);
                });
            });
        });
    }
    else {
        $(".burger").removeClass("active");
        $(".lang-box").fadeOut(50, function () {
            $(".drop-wrap").fadeOut(function () {
                $(".dropdown").removeClass("horisontal-nav");
                $(".dropdown").height(0);
            });
        });
    }
});

$(window).resize(function () {
    var containerHeight = $(window).height() - $("footer").outerHeight() - $("nav").height();
    $(".main-container").css({"min-height": containerHeight });
    
    if ($(".dropdown").height() > 1) {
        if ($(window).height() > 400) {
            $(".dropdown").height($(window).height() - 90);    
            $(".dropdown").removeClass("horisontal-nav");
        }

        else {
            $(".dropdown").addClass("horisontal-nav");
            $(".dropdown").height($(window).height() - 90);
        }

        $(".burger").addClass("active");
        $(".drop-wrap").fadeIn(400, function () {
            $(".lang-box").fadeIn();
        });
    }
});

$(window).on("orientationchange", function () {
    if ($(".dropdown").height() > 1) {
        if ($(window).height() > 400) {
            $(".dropdown").height($(window).height() - 90);
            $(".dropdown").removeClass("horisontal-nav");
        }
        else {
            $(".dropdown").addClass("horisontal-nav");
            $(".dropdown").height($(window).height() - 90);
        }

        $(".burger").addClass("active");
        $(".drop-wrap").fadeIn(400, function () {
            $(".lang-box").fadeIn();
        });
    }
    
    var containerHeight = $(window).height() - $("footer").outerHeight() - $("nav").height();
    $(".main-container").css({"min-height": containerHeight });
});

$(window).scroll(function () {
    if ($(window).scrollTop() > 80) {
        $(".scroll-box").fadeOut();
    }
    if ($(window).scrollTop() < 10) {
        $(".scroll-box").fadeIn();
    }
});

function urlencode(v) {
    return encodeURIComponent(v).replace(/%20/g, '+');
}