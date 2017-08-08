<div class="row" data-task-id="<?= $task['id'] ?>">
    <div class="project-task col-md-8 col-md-offset-2 col-xs-12 col-xs-offset-0">
        <div class="row aligned-row">
            <div class="project-task-done col-md-1 col-xs-1 text-center">
                <input type="checkbox">
            </div>
            <div class="project-task-text col-md-9 col-xs-9">
                <p><?= $task['name'] ?></p>
            </div>
            <div class="project-task-action col-md-2 col-xs-2">
                <p class="text-center">
                    <i class="fa fa-sort" aria-hidden="true"></i>
                    <span class="delimiter"></span>
                    <i class="fa fa-pencil" aria-hidden="true" data-task-id="<?= $task['id'] ?>"></i>
                    <span class="delimiter"></span>
                    <i class="fa fa-trash-o" aria-hidden="true" data-task-id="<?= $task['id'] ?>"></i>
                </p>
            </div>
        </div>
    </div>
</div>