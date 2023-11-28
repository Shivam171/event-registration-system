<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php';

$successMessage = ""; // Initialize the success message as an empty string

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION["user_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $eventDate = $_POST["event_date"];
    $phone_number = $_POST["phone_number"];
    $email_id = $_POST["email_id"];

    // Check if the selected date is in the past
    $today = date("Y-m-d");

    if ($eventDate < $today) {
        $successMessage = "You cannot select a date in the past.";
    } else {
        // Handle file upload
        $imagePath = ""; // Initialize the image path to an empty string

        if ($_FILES["image"]["name"]) {
            $imageDir = "uploads/"; // Directory where the images will be stored
            $imagePath = $imageDir . $_FILES["image"]["name"];
            move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
        }

        // Insert event data into the database, including the image path, phone number, and email ID
        $query = "INSERT INTO events (user_id, title, description, event_date, image, phone_number, email_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userId, $title, $description, $eventDate, $imagePath, $phone_number, $email_id]);

        // Display a success message as an alert and redirect to home.php
        if (!empty($successMessage)) {
            echo '<script>alert("Event created successfully!");</script>';
            echo '<script>window.location.href = "home.php";</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.min.css" />
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: linear-gradient(45deg, #f0f0f0, #3498db, #f0f0f0, #3498db);
            background-size: 400% 400%;
            animation: gradientAnimation 5s infinite;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Your other CSS styles here */
    </style>
</head>

<body>
    <h1>Create an Event</h1>
    <form method="post" action="create_event.php" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea><br>

        <label for="event_date">Event Date:</label>
        <input type="date" name="event_date" required><br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" required><br>

        <label for="email_id">Email ID:</label>
        <input type="email" name="email_id" required><br>

        <label for="image">Event Image:</label>
        <input type="file" name="image"><br>

        <input type="submit" value="Create Event">
        <a href="home.php">Cancel</a>
    </form>

    <!-- Display the success message -->
    <?php
    if (!empty($successMessage)) {
        echo '<p style="color: green;">' . $successMessage . '</p>';
    }
    ?>
</body>

</html>