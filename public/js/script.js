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
    body.on('click', ".project-header .fa-trash", function () {
        var c = confirm("Your project and all the tasks in it will be deleted. Are you sure?");
        var project_id = $(this).data('project-id');
        if (!project_id) {
            console.log('Not found: project ID');
            return false;
        }
        if (c === true) {
            $.ajax({
                type: "POST",
                url: 'ajax/delete-project',
                data: 'project-id=' + project_id,
                success: function (data) {
                    var response = JSON.parse(data);
                    if (response.status) {
                        $('.project[data-project-id=' + response.project + ']')
                            .fadeTo('400', 0, function(){
                                $(this).remove();
                            });
                    } else {
                        console.log('Status delete project: ' + response.status);
                    }
                }
            });
        }
    });

    // Click edit project button
    body.on('click', '.project-header .fa-pencil', function () {
        var project_header = $(this).parents('.project-header');
        var name = project_header.find('.project-header-text h2').text();
        body.off('mouseover mouseout', '.project-header');
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

        if (!new_name) {
            show_message({
                'type':'danger',
                'text' : 'The name of the project can not be empty!'
            });
            return false;
        }

        if (!project_id) {
            console.log('Not found: project_id');
            return false;
        }

        $.ajax({
            type: "POST",
            url: 'ajax/update-project',
            data: 'project-id=' + project_id + '&new-name=' + new_name,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status) {
                    project_header.find('h2').text(new_name).show();
                    project_header.find('input, .project-save-cancel-buttons').remove();
                    project_header.find(".project-header-right-icon").removeClass('show');
                    project_header.find('.edit-project-buttons').show();
                    body.on('mouseover mouseout', '.project-header',  function () {
                        $(this).find(".project-header-right-icon").toggleClass("show");
                    });
                } else {
                    if (response.message) show_message(response.message);
                    console.log('Status edit project: ' + response.status);
                }
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

    // Click add project
    body.on('click', '#add-project', function () {
        var modal = $(this).parents('.modal-content');
        var project_name = modal.find('input').val();

        if (!project_name) {
            var message = $('<div>')
                .addClass('help-block has-error')
                .text('Enter project name');
            modal.find('.help-block').remove();
            modal.find('.form-group').append(message);
            return;
        }
        $.ajax({
            type: "POST",
            url: 'ajax/create-project',
            data: 'project-name=' + project_name,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status) {
                    $('#projects').append(response.project_block);
                    modal.find('input').val('');
                    $('#myModal').modal('hide');
                    $(".tasks").sortable({
                        handle: '.fa-sort',
                        axis: 'y',
                        update: function (event, ui) {
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
                                }
                            });
                        }
                    });
                } else {
                    if (response.message) show_message(response.message);
                    console.log('Status edit project: ' + response.status);
                }
            }
        });
    });

    //Click add task button
    body.on('click', '.project-action-input button', function () {
        var project_input = $(this).parents('.project-action-input');
        var project_id = project_input.find('input').data('project-id');
        var task = project_input.find('input').val();

        if (!task) {
            show_message({
                'type':'danger',
                'text' : 'Enter a task!'
            });
            return false;
        }

        if (!project_id) {
            console.log('Not found: project_id');
            return false;
        }

        $.ajax({
            type: "POST",
            url: 'ajax/create-task',
            data: 'project-id=' + project_id + '&task=' + task,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status) {
                    project_input.find('input').val('').focus();
                    project_input.parents('.project').find('.tasks').append(response.task_block);
                } else {
                    console.log('Status add task: ' + response.status);
                }
            }
        });
    });

    // Click delete task button
    body.on('click', '.project-task .fa-trash-o', function () {
        var task_id = $(this).parents('.project-task').data('task-id');
        if (!task_id) {
            console.log('Not found: task_id');
            return false;
        }
        $.ajax({
            type: "POST",
            url: 'ajax/delete-task',
            data: 'task-id=' + task_id,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status) {
                    $('.row:has(.project-task[data-task-id=' + response.task_id + '])')
                        .fadeTo('400', 0, function(){
                            $(this).remove();
                        });
                } else {
                    console.log('Status delete task: ' + response.status);
                }
            }
        });
    });

    // Sort tasks
    $(".tasks").sortable({
        handle: '.fa-sort',
        axis: 'y',
        update: function (event, ui) {
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
                }
            });
        }
    });

    // Click edit task button
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
    
    // Click cancel button
    body.on('click', '.project-task button:has(.fa-ban)', function () {
        var project_task = $(this).parents('.project-task');
        project_task.find('.form-group, .task-save-cancel-buttons').remove();
        project_task.find('.edit-task-buttons, .task-text').show();
        project_task.find(".project-task-action").removeClass('show');
        body.on('mouseover mouseout', '.project-task',  function () {
            $(this).find(".project-task-action").toggleClass("show");
        });
    });
    
    // Click save button
    body.on('click', '.project-task button:has(.fa-floppy-o)', function () {
        var task_block = $(this).parents('.project-task');
        var task_id = task_block.data('task-id');
        var new_name = task_block.find('input[type=text]').val();

        if (!task_id) {
            console.log('Not found: task_id');
            return false;
        }

        $.ajax({
            type: "POST",
            url: 'ajax/update-task',
            data: 'task-id=' + task_id + '&new-name=' + new_name,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status) {
                    task_block.find('.task-text').text(new_name).show();
                    task_block.find('.form-group, .task-save-cancel-buttons').remove();
                    task_block.find(".project-task-action").removeClass('show');
                    task_block.find('.edit-task-buttons').show();
                    body.on('mouseover mouseout', '.project-task',  function () {
                        $(this).find(".project-task-action").toggleClass("show");
                    });
                } else {
                    console.log('Status edit task: ' + response.status);
                }
            }
        });
    });

    // Change priority
    body.on('click', '.priority', function () {
        var task_block = $(this).parents('.project-task');
        var task_id = task_block.data('task-id');

        if (!task_id) {
            console.log('Not found: task_id');
            return false;
        }

        $.ajax({
            type: "POST",
            url: 'ajax/changePriority-task',
            data: 'task-id=' + task_id,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status) {
                    task_block.find('.priority span').text(response.new_priority_name);
                    task_block.find('.priority i')
                        .removeClass()
                        .addClass('fa fa-star ' + response.new_priority_color + '-star');
                } else {
                    console.log('Status edit priority: ' + response.status);
                }
            }
        });
    });

    // Show clear deadline
    body.on('mouseover mouseout', '.deadline', function () {
       $(this).find('.clear-deadline').toggleClass("show")
    });

    // Click clear deadline button
    body.on('click', '.clear-deadline', function () {
        var task_block = $(this).parents('.project-task');
        var id = task_block.data('task-id');
        $.ajax({
            type: "POST",
            url: 'ajax/changeDeadline-task',
            data: 'task-id=' + id + '&new-deadline=clear',
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status) {
                    task_block.find('input').val("Click to set deadline");
                } else {
                    console.log('Status edit deadline: ' + response.status);
                }
            }
        });
    });

    // Click done checkbox
    body.on('click', '.is-done', function () {
        var task_block = $(this).parents('.project-task');
        var id = task_block.data('task-id');
        var is_done = $(this).is(":checked");

        $.ajax({
            type: "POST",
            url: 'ajax/changeDone-task',
            data: 'task-id=' + id + '&is-done=' + is_done,
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status) {
                    task_block.find(".task-text").toggleClass("done");
                } else {
                    console.log('Status edit done: ' + response.status);
                }
            }
        });
    });

    var show_message = function(message) {
        var alert_block = $('<div>')
            .addClass('alert-message-wrapper')
            .append($('<div>')
                .attr('role', 'alert')
                .addClass('alert-message alert alert-dismissible')
                .addClass('alert-' + message.type)
                .text(message.text)
                .append($('<button>')
                    .attr('type', 'button')
                    .attr('data-dismiss', 'alert')
                    .attr('aria-label', 'Close')
                    .addClass('close')
                    .append($('<span>')
                        .attr('aria-hidden', 'true')
                        .text("×")
                    )
                )
            );
        var alert = $('.alert-message-wrapper');
        if (alert.length !== 0) {
            alert.fadeTo('fast', 0, function(){
                $(this).remove();
                $('main').prepend(alert_block);
            });
        } else {
            $('main').prepend(alert_block);
        }
    };
});