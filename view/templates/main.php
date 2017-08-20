<?php if (\Model\User::isLogin()) : ?>
    <div id="projects">
        <?php if (count($projects) > 0) : ?>
            <?php foreach ($projects as $project) : ?>
                <?= \Core\View::renderPartial('partial/project', ['project' => $project]) ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="text-center">
        <button type="button" class="btn btn-primary btn-lg text-" data-toggle="modal" data-target="#myModal">
            Create project
        </button>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Create project</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="project-name">Project name</label>
                        <input type="text" name="project-name" class="form-control" id="project-name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="add-project" class="btn btn-primary">Create</button>
                </div>
            </div>
        </div>
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