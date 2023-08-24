$(document).scroll(function() {
    if($(window).scrollTop() === 0) {
        $(".logoWrapper").addClass("toRight");
        $(".logoWrapper").removeClass("toLeft");
        $("nav").addClass("top");
        $("nav").removeClass("not-top");
    } else {
        $(".logoWrapper").addClass("toLeft");
        $(".logoWrapper").removeClass("toRight");
        $("nav").addClass("not-top");
        $("nav").removeClass("top");
    }
});