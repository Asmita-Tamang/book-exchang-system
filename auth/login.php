<?php

session_start();

require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email == "") {
    $message = "Email is required.";
}
elseif ($password == "") {
    $message = "Password is required.";
}
elseif (strpos($email, " ") !== false) {
    $message = "Email must not contain spaces.";
}
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $message = "Please enter a valid email address.";
}
else {

    $sql = "
        SELECT id, name, email, password
        FROM users
        WHERE email = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_email"] = $user["email"];

            header("Location: ../index.php");
            exit;

        } else {
            $message = "Incorrect password.";
        }

    } else {
        $message = "No account found with this email.";
    }

    mysqli_stmt_close($stmt);
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Login to your Book Exchange account</p>
            </div>

            <?php if ($message != ""): ?>

                <div class="message">
                    <?php echo htmlspecialchars($message); ?>
                </div>

            <?php endif; ?>


            <form method="POST">

                <div class="form-group">

                    <label for="email">Email</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        placeholder="Enter your email"
                    >

                </div>


                <div class="form-group">

                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        placeholder="Enter your password"
                    >

                </div>


                <button type="submit" class="login-button">
                    Login
                </button>

            </form>


            <p class="register-link">
                Don't have an account?
                <a href="register.php">Register</a>
            </p>

        </div>

    </div>

</body>
</html>