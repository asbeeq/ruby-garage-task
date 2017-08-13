$(document).ready(function () {
    var body = $('body');
    // Show/Hide action button
    body.on('mouseover mouseout', '.project-header', function () {
        $(this).find(".project-header-right-icon").toggleClass("show");
    });

    body.on('mouseover mouseout', '.project-task', function () {
        $(this).find(".project-task-action").toggleClass("show");
    });

    // Delete project

    $(".project-header .fa-trash").on('click', function () {
        var c = confirm("Your project and all the tasks in it will be deleted. Are you sure?");
        if (c === true) {
            $.ajax({
                type: "POST",
                url: 'ajax/delete-project',
                data: 'project-id=' + $(this).data('project-id'),
                success: function (data) {
                    var response = JSON.parse(data);
                    if (response.status) {
                        delete_project(response);
                    } else {
                        console.log('Status delete project: ' + response.status);
                    }
                },
                error: function (data) {
                    var response = JSON.parse(data);
                    show_message(response.message);
                }
            });
        }
    });

    // Click edit project button

    $('.project-header .fa-pencil').on('click', function () {
        var project_header = $(this).parents('.project-header');

        body.off('mouseover mouseout', '.project-header');
        var name = project_header.find('.project-header-text h2').text();

        project_header.find('.edit-project-buttons').hide();
        $(this).parents('.project-header-right-icon')
            .append($('<div>')
                .addClass('project-save-cancel-buttons')
                .append($("<button>")
                    .addClass('btn btn-success')
                    .append($('<i>').addClass('fa fa-floppy-o')))
                .append($("<span>")
                    .addClass('delimiter'))
                .append($("<button>")
                    .addClass('btn btn-danger')
                    .append($('<i>').addClass('fa fa-ban'))));

        project_header.find('.project-header-text')
            .append($('<input>')
                .attr('name', 'name')
                .attr('data-project-id', project_header.parents('.project').data('project-id'))
                .addClass('form-control')
                .val(name))
         .find('h2').hide();
        project_header.find('input').focus()
    });

    // Click save button (edit project)

    body.on('click', '.project-header button:has(.fa-floppy-o)', function () {
        var project_header = $(this).parents('.project-header');
        var project_id = project_header.find('input').data('project-id');
        var new_name = project_header.find('input').val();

        $.ajax({
            type: "POST",
            url: 'ajax/update-project',
            data: 'project-id=' + project_id + '&new-name=' + new_name,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status) {
                    project_header.find('h2').text(project_header.find('input').val()).show();
                    project_header.find('input, .project-save-cancel-buttons').remove();
                    project_header.find(".project-header-right-icon").removeClass('show');
                    project_header.find('.edit-project-buttons').show();
                    body.on('mouseover mouseout', '.project-header',  function () {
                        $(this).find(".project-header-right-icon").toggleClass("show");
                    });
                    show_message(response.message);
                } else {
                    console.log('Status delete project: ' + response.status);
                }
            },
            error: function (data) {
                var response = JSON.parse(data);
                show_message(response.message);
            }
        });
    });

    // Click cancel button (Edit project)

    body.on('click', '.project-header button:has(.fa-ban)', function () {
        var project_header = $(this).parents('.project-header');
        project_header.find('input, .project-save-cancel-buttons').remove();
        project_header.find(".project-header-right-icon").removeClass('show');
        project_header.find('.edit-project-buttons, h2').show();
        body.on('mouseover mouseout', '.project-header',  function () {
            $(this).find(".project-header-right-icon").toggleClass("show");
        });
    });

    //Click add task button

    body.on('click', '.project-action-input button', function () {
        var project_input = $(this).parents('.project-action-input');
        var project_id = project_input.find('input').data('project-id');
        var task = project_input.find('input').val();
        $.ajax({
            type: "POST",
            url: 'ajax/create-task',
            data: 'project-id=' + project_id + '&task=' + task,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status) {
                    project_input.find('input').val('').focus();
                    project_input.parents('.project').find('.tasks').append(response.task_block);
                    show_message(response.message);
                } else {
                    console.log('Status add task: ' + response.status);
                    if (response.message) {
                        show_message(response.message);
                    }
                }
            },
            error: function (data) {
                var response = JSON.parse(data);
                show_message(response.message);
            }
        });
    });

    // Click delete task button

    body.on('click', '.project-task .fa-trash-o', function () {
        var task_row = $(this).parents('.project-task');
        $.ajax({
            type: "POST",
            url: 'ajax/delete-task',
            data: 'task-id=' + task_row.data('task-id'),
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status) {
                    delete_task(response);
                    // show_message(response.message);
                } else {
                    console.log('Status delete task: ' + response.status);
                }
            },
            error: function (data) {
                var response = JSON.parse(data);
                show_message(response.message);
            }
        });
    });

    // Sort tasks

    $('.tasks').sortable({
        handle: '.fa-sort',
        axis: 'y',
        update: function ( event, ui ) {
            var data = 'project-id=' + $(this).parents('.project').data('project-id');
            $.each($(this).find('.project-task'), function () {
                data += '&order[]=' + ($(this).data('task-id'));
            });
            $.ajax({
                type: "POST",
                url: 'ajax/sort-task',
                data: data,
                success: function (data) {
                    var response = JSON.parse(data);
                    if (!response.status) {
                        console.log('Status order task: ' + response.status);
                    }
                },
                error: function (data) {
                    var response = JSON.parse(data);
                    show_message(response.message);
                }
            });
        }
    });

    // click edit task button

    body.on('click', '.project-task .fa-pencil', function () {
        body.off('mouseover mouseout', '.project-task');
        var task_row = $(this).parents('.project-task');
        var name = $.trim(task_row.find('.task-text').text());
        task_row.find('.task-text').hide();

        task_row.find('.edit-task-buttons').hide();
        $(this).parents('.project-task-action')
            .append($('<div>')
                .addClass('task-save-cancel-buttons')
            .append($("<button>")
                .addClass('btn btn-success btn-sm')
                .append($('<i>').addClass('fa fa-floppy-o')))
            .append($('<span>')
                .addClass('delimiter'))
            .append($("<button>")
                .addClass('btn btn-danger btn-sm')
                .append($('<i>').addClass('fa fa-ban')))
            );

        task_row.find('.project-task-text')
            .prepend($('<div>')
                .addClass('form-group')
                .append($('<input>')
                    .attr('name', 'name')
                    .attr('type', 'text')
                    .addClass('form-control input-sm task-input')
                    .val(name)
                )
            );
    });

    body.on('click', '.project-task button:has(.fa-ban)', function () {
        var project_task = $(this).parents('.project-task');
        project_task.find('.project-task-text input, .task-save-cancel-buttons').remove();
        project_task.find('.edit-task-buttons, .task-text').show();
        project_task.find(".project-task-action").removeClass('show');
        body.on('mouseover mouseout', '.project-task',  function () {
            $(this).find(".project-task-action").toggleClass("show");
        });
    });

    // Helpers


    var delete_project = function(response) {
        $('.project[data-project-id=' + response.project + ']')
            .fadeTo('400', 0, function(){
                $(this).remove();
                show_message(response.message);
            });
    };

    var delete_task = function (response) {
        $('.row:has(.project-task[data-task-id=' + response.task_id + '])')
            .fadeTo('400', 0, function(){
                $(this).remove();
            });
        show_message(response.message);
    };

    var show_message = function(message) {
        var alert = $('.alert-message-wrapper');
        if (alert.length !== 0) {
            alert.fadeTo('fast', 0, function(){
                $(this).remove();
                $('main').prepend(message);
            });
        } else {
            $('main').prepend(message);
        }
    };
});