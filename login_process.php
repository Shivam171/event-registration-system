<?php
include 'db_connect.php';
session_start();

// Database connection code here

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Retrieve user data from the database
    $query = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        // Successful login, store user information in session
        $_SESSION["user_id"] = $user["id"];
        header("Location: home.php");
        exit;
    } else {
        // Invalid login, show an error alert and redirect back to login.php
        echo '<script>alert("Password is incorrect. Please try again.");</script>';
        echo '<script>window.location.href = "login.php";</script>';
        exit;
    }
}
