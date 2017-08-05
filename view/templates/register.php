<form method="post">
    <div class="form-group">
        <label for="login">Login</label>
        <input type="text" name="login" class="form-control" id="login" value="<?= $oldLogin ?>">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password">
    </div>
    <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="password_confirm" class="form-control" id="confirm_password">
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
</form>