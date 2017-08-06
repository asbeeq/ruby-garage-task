<?php if (\Model\User::isLogin()) : ?>
    <?php if (count($projects) > 0) : ?>
        <?php foreach ($projects as $project) : ?>
            <div class="project">
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
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            <span class="delimiter"></span>
                            <i class="fa fa-trash" aria-hidden="true"></i>
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
                        <div class="row">
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
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                        <span class="delimiter"></span>
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </p>
                                </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <div class="text-center">
        <a href="/project/create" class="btn btn-primary btn-lg">Create Project</a>
    </div>

<?php else : ?>
    <div class="jumbotron text-center">
        <h2>In order to use task list you need to</h2>
        <p>
            <a class="btn btn-primary btn-lg" href="/register" role="button">Register</a>
            <span class="or">or</span>
            <a class="btn btn-primary btn-lg" href="/login" role="button">Log in</a>
        </p>
    </div>
<?php endif; ?>