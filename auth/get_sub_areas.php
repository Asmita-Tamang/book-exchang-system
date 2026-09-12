<?php

require_once "../config/database.php";

header("Content-Type: application/json");

if (!isset($_GET["area_id"])) {
    echo json_encode([]);
    exit;
}

$area_id = (int) $_GET["area_id"];

$sql = "
    SELECT id, name
    FROM sub_areas
    WHERE area_id = ?
    ORDER BY name
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $area_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$sub_areas = [];

while ($row = mysqli_fetch_assoc($result)) {
    $sub_areas[] = $row;
}

echo json_encode($sub_areas);

mysqli_stmt_close($stmt);