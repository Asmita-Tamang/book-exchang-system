<?php

require_once "../config/database.php";

header("Content-Type: application/json");

if (!isset($_GET["district_id"])) {
    echo json_encode([]);
    exit;
}

$district_id = (int) $_GET["district_id"];

$sql = "
    SELECT id, name
    FROM areas
    WHERE district_id = ?
    ORDER BY name
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $district_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$areas = [];

while ($row = mysqli_fetch_assoc($result)) {
    $areas[] = $row;
}

echo json_encode($areas);

mysqli_stmt_close($stmt);