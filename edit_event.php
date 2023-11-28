<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

$eventId = $_GET['id'];

// Check if the logged-in user is the event creator
$userId = $_SESSION["user_id"];
$query = "SELECT user_id FROM events WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$eventId]);
$event = $stmt->fetch();

if ($event && $event['user_id'] === $userId) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $eventDate = $_POST["event_date"];

        $query = "UPDATE events SET title = ?, description = ?, event_date = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$title, $description, $eventDate, $eventId]);

        header("Location: home.php");
        exit;
    }

    $query = "SELECT * FROM events WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$eventId]);
    $event = $stmt->fetch();
} else {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Event</title>
</head>

<body>
    <h1>Edit Event</h1>
    <form method="post" action="edit_event.php?id=<?php echo $eventId; ?>">
        Title: <input type="text" name="title" required value="<?php echo $event['title']; ?>"><br>
        Description: <textarea name="description" required><?php echo $event['description']; ?></textarea><br>
        Event Date: <input type="date" name="event_date" required value="<?php echo $event['event_date']; ?>"><br>
        <input type="submit" value="Save Changes">
    </form>
    <a href="home.php">Back to Home</a>
</body>

</html>