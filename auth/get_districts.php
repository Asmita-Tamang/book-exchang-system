<?php

require_once "../config/database.php";

header("Content-Type: application/json");

$province_id = isset($_GET["province_id"])
    ? (int) $_GET["province_id"]
    : 0;

if ($province_id <= 0) {
    echo json_encode([]);
    exit;
}

$sql = "
    SELECT id, name
    FROM districts
    WHERE province_id = ?
    ORDER BY name
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $province_id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$districts = [];

while ($row = mysqli_fetch_assoc($result)) {

    $districts[] = [
        "id" => $row["id"],
        "name" => $row["name"]
    ];

}

echo json_encode($districts);

mysqli_stmt_close($stmt);