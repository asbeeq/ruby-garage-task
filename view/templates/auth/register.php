<div class="panel panel-default">
    <div class="panel-heading"><h4>Register</h4></div>
    <div class="panel-body">
        <form method="post">
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" name="login" class="form-control" id="login" value="<?= $oldLogin ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="<?= $oldEmail ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="password_confirm" class="form-control" id="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
            <span class="or">or</span>
            <a href="/login">log in</a>
        </form>
    </div>
</div>