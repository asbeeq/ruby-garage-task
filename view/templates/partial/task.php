<div class="row">
    <div class="project-task col-md-8 col-md-offset-2 col-xs-12 col-xs-offset-0" data-task-id="<?= $task['id'] ?>">
        <div class="row aligned-row">
            <div class="project-task-done col-md-1 col-xs-1 text-center">
                <input type="checkbox">
            </div>
            <div class="project-task-text col-md-9 col-xs-9">
                <p class="task-text">
                    <?= $task['name'] ?>
                </p>
                <p class="priority col-md-6">
                    <i class="fa fa-star gray-star"></i>
                    not urgent and not important
                </p>
                <p class="deadline text-right col-md-6">
                    <i class="fa fa-clock-o"></i>
                    Deadline not set
                </p>
            </div>
            <div class="project-task-action text-center col-md-2 col-xs-2">
                <div class="edit-task-buttons">
                    <i class="fa fa-sort" aria-hidden="true"></i>
                    <span class="delimiter"></span>
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                    <span class="delimiter"></span>
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
</div>