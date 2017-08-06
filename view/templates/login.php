<div class="panel panel-default">
    <div class="panel-heading"><h4>Log In</h4></div>
    <div class="panel-body">
        <form method="post">
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" name="login" class="form-control" id="login" value="<?= $oldLogin ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
            <span class="or">or</span>
            <a href="/register">register</a>
        </form>
    </div>
</div>