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

    // Retrieve event information, including the user who created it
    $query = "SELECT user_id, title FROM events WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();

    if ($event && $event['user_id'] == $user_id) {
        // User is the creator of the event, so they have permission to delete it
        // Display a confirmation message with JavaScript
        echo '<script>
                if (confirm("Are you sure you want to delete the event: ' . $event['title'] . ' ?")) {
                    // If the user confirms, proceed with event deletion
                    window.location.href = "delete_event_process.php?event_id=' . $event_id . '";
                } else {
                    // If the user cancels, redirect back to the home page
                    window.location.href = "home.php";
                }
              </script>';
    } else {
        // User is not the event's creator, deny deletion
        // Redirect back to the home page
        header("Location: home.php");
        exit;
    }
} else {
    header("Location: home.php");
    exit;
}
