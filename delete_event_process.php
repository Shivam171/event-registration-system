<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["event_id"])) {
    $event_id = $_GET["event_id"];
    $user_id = $_SESSION["user_id"];

    // Check if the user is the creator of the event (additional check)
    $query = "SELECT user_id FROM events WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();

    if ($event && $event['user_id'] == $user_id) {
        // User is the creator of the event, proceed with deletion
        $deleteQuery = "DELETE FROM events WHERE id = ?";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([$event_id]);
    }
}

// Redirect back to the home page
header("Location: home.php");
exit;
