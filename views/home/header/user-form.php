<div id="user-form">
    <h5 class="card-title">Welcome, @<?= $_SESSION['user']['nickname']?>!</h5>
    <a href="controllers/authController.php?action=logout" class="card-link">logout</a>
</div>