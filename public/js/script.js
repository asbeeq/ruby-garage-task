$(document).ready(function () {
    $(".task-list-header").on('mouseover mouseout', function () {
        $(".task-list-header-right-icon").toggleClass("show", "hidden");
    })
});