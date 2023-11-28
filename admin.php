<?php
include 'db_connect.php';

// Retrieve user and event count data
$query = "SELECT u.username, COALESCE(uec.event_count, 0) as event_count
          FROM users u
          LEFT JOIN user_events_count uec ON u.id = uec.creator_id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Page</title>
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
    <h1>Welcome to the Admin Page</h1>

    <a href="create_event.php">Create an Event</a><br>

    <h2>List of Users and Their Event Counts</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Event Count</th>
        </tr>
        <?php
        foreach ($users as $user) {
            echo '<tr>';
            echo '<td>' . $user['username'] . '</td>';
            echo '<td>' . $user['event_count'] . '</td>';
            echo '</tr>';
        }
        ?>
    </table>

    <a href="login.php">Logout</a>
</body>

</html>