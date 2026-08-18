<?php

require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    $province = trim($_POST["province"]);
    $district = trim($_POST["district"]);
    $city = trim($_POST["city"]);
    $ward = $_POST["ward"];

    // Check if passwords match
    if ($password !== $confirm_password) {

        $message = "Passwords do not match.";

    } else {

        // Check if email already exists
        $check_email = "SELECT id FROM users WHERE email = ?";

        $stmt = mysqli_prepare($conn, $check_email);

        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {

            $message = "This email is already registered.";

        } else {

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $sql = "INSERT INTO users
                    (name, email, phone, password, province, district, city, ward)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "sssssssi",
                $name,
                $email,
                $phone,
                $hashed_password,
                $province,
                $district,
                $city,
                $ward
            );

            if (mysqli_stmt_execute($stmt)) {

                $message = "Registration successful!";

            } else {

                $message = "Registration failed. Please try again.";
            }
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

    <title>Register - Book Exchange System</title>

</head>

<body>

    <h1>Create an Account</h1>

    <?php if ($message != ""): ?>

        <p>
            <?php echo $message; ?>
        </p>

    <?php endif; ?>


    <form action="" method="POST">

        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>

        <br><br>


        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <br><br>


        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone">

        <br><br>


        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <br><br>


        <label for="confirm_password">Confirm Password:</label>
        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            required
        >

        <br><br>


        <label for="province">Province:</label>
        <input type="text" id="province" name="province">

        <br><br>


        <label for="district">District:</label>
        <input type="text" id="district" name="district">

        <br><br>


        <label for="city">City:</label>
        <input type="text" id="city" name="city">

        <br><br>


        <label for="ward">Ward:</label>
        <input type="number" id="ward" name="ward">

        <br><br>


        <button type="submit">Register</button>

    </form>

</body>

</html>