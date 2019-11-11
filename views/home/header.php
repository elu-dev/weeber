<div class="card m-4">
    <div class="card-body">
        <?php
            session_start();
            if (isset($_SESSION['user'])) require_once 'views/home/header/user-form.php';
            else {
                require_once 'views/home/header/register-form.php';
                require_once 'views/home/header/login-form.php';
                unset($_SESSION["form_errors"]);
            }
        ?>
    </div>
</div>