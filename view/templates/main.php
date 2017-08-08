<?php if (\Model\User::isLogin()) : ?>
    <?php if (count($projects) > 0) : ?>
        <?php foreach ($projects as $project) : ?>
            <?= \Core\View::renderPartial('partial/project', ['project' => $project]) ?>
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