<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.min.css" />
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 92vh;
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
    <h1>University Club Event Registration</h1>
    <h2>Login</h2>
    <form method="post" action="login_process.php">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>

    <p>Don't have an account? <a href="register.php">Register</a></p>
</body>

</html>