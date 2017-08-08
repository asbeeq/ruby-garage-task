<div class="project" data-project-id="<?= $project['id'] ?>">
    <div class="row">
        <div class="project-header col-md-8 col-md-offset-2 col-xs-12 col-xs-offset-0">
            <div class="row aligned-row">
                <div class="col-md-1 col-xs-1 text-center project-header-icon">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                </div>
                <div class="col-md-9 col-xs-9 project-header-text">
                    <h2><?= $project['name'] ?></h2>
                </div>
                <div class="col-md-2 col-xs-2 text-center project-header-right-icon">
                    <i class="fa fa-pencil" data-project-id="<?= $project['id'] ?>" aria-hidden="true"></i>
                    <span class="delimiter"></span>
                    <i class="fa fa-trash" data-project-id="<?= $project['id'] ?>" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="project-action col-md-8 col-md-offset-2 col-xs-12 col-xs-offset-0">
            <div class="col-md-1 col-xs-1 text-center project-action-icon">
                <i class="fa fa-plus" aria-hidden="true"></i>
            </div>
            <div class="col-md-11 col-xs-11 project-action-input">
                <form method="post">
                    <div class="input-group">
                        <input type="text" class="form-control"
                               placeholder="Start typing here to create a task...">
                        <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">Add Task</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="tasks">
        <?php foreach ($project['tasks'] as $task) : ?>
            <?= \Core\View::renderPartial('partial/task', ['task' => $task]) ?>
        <?php endforeach; ?>
    </div>
</div>