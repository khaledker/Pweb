<?php
session_start();



// Security headers to protect against various vulnerabilities
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" href="image/1.jpg">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <?php
            include ("db.php");
            if (isset($_POST['submit'])) {
                $username = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['username']), ENT_QUOTES, 'UTF-8');
                $password = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password']), ENT_QUOTES, 'UTF-8');
                $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' ") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                if ($row) {
                    if (password_verify($password, $row['password'])) {
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['id'] = $row['id'];
                        header("Location: task.php");
                        exit();
                    } else {
                        echo "<div class='message'>
                                <p>Wrong Username or Password</p>
                              </div><br>";
                    }
                } else {
                    echo "<div class='message'>
                            <p>Wrong Username or Password</p>
                          </div><br>";
                }
            }
            ?>
            <header class="login">Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>