<<<<<<< HEAD
<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "book_exchange_system";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

=======
<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "book_exchange_system";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

>>>>>>> 8d7e43fb5367baa8394cd56a0886732437ef3895
?>