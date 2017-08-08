$(document).ready(function () {
    // Show/Hide action button
    $(".project-header").on('mouseover mouseout', function () {
        $(this).find(".project-header-right-icon").toggleClass("show");
    });

    $(".project-task").on('mouseover mouseout', function () {
        $(this).find(".project-task-action").toggleClass("show");
    });

    // Delete project

    $(".project-header .fa-trash").on('click', function () {
        $.ajax({
            type: "POST",
            data: null,
            url: 'ajax/delete-project',
            dataType: 'text',
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });
    
    function sendAjax(url, data) {
        $.ajax({
            url: 'ajax/test.html',
            success: function () {
                alert('Load was performed.');
            },
            error: function () {

            }
        });
    }
});