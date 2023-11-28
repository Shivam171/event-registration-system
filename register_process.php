<?php
// Database connection code here
include 'db_connect.php';
// ----------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Insert user data into the database
    $query = "INSERT INTO users (name, email, phone, username, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $email, $phone, $username, $password]);

    // JavaScript alert
    echo '<script>alert("Registration successful. You can now login.");</script>';

    // Redirect to the login page
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}
