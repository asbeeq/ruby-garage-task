$(document).ready(function () {
    $(".project-header").on('mouseover mouseout', function () {
        $(this).find(".project-header-right-icon").toggleClass("show", "hidden");
    })
});