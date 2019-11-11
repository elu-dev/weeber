<div id="login-form">
    <h5 class="card-title">Login</h5>
    <form class="form-horizontal" action="controllers/authController.php?action=login" method="POST">
        <div class="form-group col">

        <?php if (isset($_SESSION['form_errors']['global'])): ?>
        <div class="text-danger mb-2"><?= $_SESSION['form_errors']['global'] ?></div>
        <?php endif ?>

            <input type="email" class="form-control" name="email" placeholder="Email" required>
            <?php if (isset($_SESSION['form_errors']['email'])): ?>
            <div class="text-danger"><?= $_SESSION['form_errors']['email'] ?></div>
            <?php endif ?>
        </div>
        <div class="form-group col">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <?php if (isset($_SESSION['form_errors']['password'])): ?>
            <div class="text-danger"><?= $_SESSION['form_errors']['password'] ?></div>
            <?php endif ?>
        </div>
        <div class="form-group col">
            <input type="submit" class="card-link btn btn-primary" value="Login">
            <a href="#" class="card-link" id="show-register">register</a>
        </div>
    </form>
</div>