<div id="register-form">
    <h5 class="card-title">Register</h5>
    <form class="form-horizontal" action="controllers/authController.php?action=register" method="POST">
        <div class="form-group col">

            <?php if (isset($_SESSION['form_errors']['global'])): ?>
            <h6 class="text-danger mb-2"><?= $_SESSION['form_errors']['global'] ?></h6>
            <?php endif ?>

            <input type="text" class="form-control" name="name" placeholder="Nickname" required>
            <?php if (isset($_SESSION['form_errors']['name'])): ?>
            <div class="text-danger"><?= $_SESSION['form_errors']['name'] ?></div>
            <?php endif ?>
        </div>
        <div class="form-group col">
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
            <input type="submit" class="card-link btn btn-primary" value="Register">
            <a href="#" class="card-link" id="show-login">login</a>
        </div>
    </form>
</div>