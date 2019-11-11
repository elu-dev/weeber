<?php
require_once 'utils.php';
require_once '../database/db.php';

session_start();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if (isset($_SESSION['user'])) {
        if ($action == 'logout') logout();
    }
    if (isset($_POST)) {
        if ($action == "login") login($db);
        if ($action == "register") register($db);
    }
}
header('Location: ../index.php');


function logout() {
    unset($_SESSION['user']);
}

function login($db) {
    $email = $password = "";
    $form_errors = [];

    if (empty($_POST["email"])) $form_errors["email"] = "Email cannot be empty";
    else {
        $email = sanity_check($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $form_errors["email"] = "Invalid email";
    }
    if (empty($_POST["password"])) $form_errors["password"] = "Password cannot be empty";
    else {
        $password = sanity_check($_POST["password"]);
        if (!preg_match("/^\w+$/", $password)) $form_errors["password"] = "Only alphanumeric characters and underscore allowed";
    }

    if (!empty($form_errors)) {
        $_SESSION["form_errors"] = $form_errors;
    } else {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $db->query($sql);
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION["user"] = $user; 
            } else {
                $_SESSION["form_errors"]["global"] = "Something went wrong";
            }
        } else {
            $_SESSION["form_errors"]["global"] = "There's no user with $email";
        }
    }
}

function register($db) {
    $name = $email = $password = "";
    $form_errors = [];

    if (empty($_POST["name"])) $form_errors["name"] = "Nickname cannot be empty";
    else {
        $name = sanity_check($_POST["name"]);
        if (!preg_match("/^\w+$/", $name)) $form_errors["name"] = "Only alphanumeric characters and underscore allowed";
    }
    if (empty($_POST["email"])) $form_errors["email"] = "Email cannot be empty";
    else {
        $email = sanity_check($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $form_errors["email"] = "Invalid email";
    }
    if (empty($_POST["password"])) $form_errors["password"] = "Password cannot be empty";
    else {
        $password = sanity_check($_POST["password"]);
        if (!preg_match("/^\w+$/", $password)) $form_errors["password"] = "Only alphanumeric characters and underscore allowed";
        $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    }

    if (!empty($form_errors)) {
        $_SESSION["form_errors"] = $form_errors;
    } else {
        $sql = "INSERT INTO users VALUES(NULL, '$name', '$email', '$password', DEFAULT)";
        if ($db->query($sql) === TRUE) {
            login($db);
        } else {
            $_SESSION["form_errors"]["global"] = preg_match("/^Duplicate/i", $db->error) ? 'User already exists' : 'Error creating new user';
            $_SESSION["form_errors"]["global"] = 1;
        }
    }
}