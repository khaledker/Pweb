<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" href="image/1.jpg">
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">

            <?php
            include ("db.php");
            if (isset($_POST['submit'])) {
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = mysqli_real_escape_string($conn, $_POST['password']);
                $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

                // Vérifier si le nom d'utilisateur est unique
                $verify_query = mysqli_query($conn, "SELECT username FROM users WHERE username='$username'");
                if (strlen($username) < 6 || strlen($username) > 20) {
                    echo "<div class='message'>
                    <p>Username must be between 6 and 20 characters</p>
                </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";

                } else if ($password !== $confirm_password) {
                    echo "<div class='message'>
                    <p>Passwords do not match</p>
                </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";

                } else if (mysqli_num_rows($verify_query) != 0) {
                    echo "<div class='message'>
                      <p>This username is used, Try another One Please!</p>
                  </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                } else {
                    // Hashage du mot de passe
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                    // Insertion de l'utilisateur
                    $insert_query = "INSERT INTO users(username, password) VALUES('$username', '$hashed_password')";

                    if (mysqli_query($conn, $insert_query)) {
                        echo "<div class='message'>
                          <p>Registration successfully!</p>
                      </div> <br>";
                        echo "<a href='index.php'><button class='btn'>Login Now</button>";
                    } else {
                        echo "<div class='message'>
                          <p>Error Occured: " . mysqli_error($conn) . "</p>
                      </div> <br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                    }
                }
            } else {
                ?>

                <header class="login">Sign up</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" autocomplete="off" required>
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Register" required>
                    </div>

                    <div class="links">
                        Already a member? <a href="index.php">Sign In</a>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</body>

</html>