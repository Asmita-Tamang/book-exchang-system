<?php

require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";

    $province_id = (int) ($_POST["province"] ?? 0);
    $district_id = (int) ($_POST["district"] ?? 0);
    $area_id = (int) ($_POST["area"] ?? 0);

    $sub_area_id = !empty($_POST["sub_area"])
        ? (int) $_POST["sub_area"]
        : null;

    
if ($name === "") {

        $message = "Full name is required.";

    } elseif ($email === "") {

        $message = "Email is required.";

    } elseif ($phone === "") {

        $message = "Phone number is required.";

    } elseif ($password === "") {

        $message = "Password is required.";

    } elseif ($confirm_password === "") {

        $message = "Please confirm your password.";

    } elseif ($province_id <= 0) {

        $message = "Please select a province.";

    } elseif ($district_id <= 0) {

        $message = "Please select a district.";

    } elseif ($area_id <= 0) {

        $message = "Please select an area.";

    } 
    elseif (!preg_match("/^[A-Za-z]+(?: [A-Za-z]+)*$/", $name)) {

        $message = "Full name should contain letters and spaces only.";

    }
    elseif (strpos($email, " ") !== false) {

        $message = "Email must not contain spaces.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";

    }
    elseif (!preg_match("/^(97|98)[0-9]{8}$/", $phone)) {

        $message = "Phone number must be exactly 10 digits and start with 97 or 98.";

    }
     elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$/", $password)) {

    $message = "Password must be at least 8 characters and contain an uppercase letter, lowercase letter, number, and special character.";

} elseif ($password !== $confirm_password) {

    $message = "Passwords do not match.";

} else {

    // Check whether the selected district belongs to the selected province
    $check_location = "
        SELECT id
        FROM districts
        WHERE id = ?
        AND province_id = ?
    ";

    $stmt = mysqli_prepare($conn, $check_location);

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $district_id,
        $province_id
    );

    mysqli_stmt_execute($stmt);

    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {

    $message = "Invalid district selected.";

} else {

    // Check whether the selected area belongs to the selected district
    $check_area = "
        SELECT id
        FROM areas
        WHERE id = ?
        AND district_id = ?
    ";

    $area_stmt = mysqli_prepare($conn, $check_area);

    mysqli_stmt_bind_param(
        $area_stmt,
        "ii",
        $area_id,
        $district_id
    );

    mysqli_stmt_execute($area_stmt);

    mysqli_stmt_store_result($area_stmt);

    if (mysqli_stmt_num_rows($area_stmt) == 0) {

        $message = "Invalid area selected.";

    } else {

        // Check sub-area if one was selected
        if ($sub_area_id !== null) {

            $check_sub_area = "
                SELECT id
                FROM sub_areas
                WHERE id = ?
                AND area_id = ?
            ";

            $sub_area_stmt = mysqli_prepare(
                $conn,
                $check_sub_area
            );

            mysqli_stmt_bind_param(
                $sub_area_stmt,
                "ii",
                $sub_area_id,
                $area_id
            );

            mysqli_stmt_execute($sub_area_stmt);

            mysqli_stmt_store_result($sub_area_stmt);

            if (mysqli_stmt_num_rows($sub_area_stmt) == 0) {

                $message = "Invalid sub-area selected.";

            } else {

                // Continue to email check
                goto check_email;

            }

            mysqli_stmt_close($sub_area_stmt);

        } else {

            // No sub-area selected, which is allowed
            goto check_email;
        }
    }

    mysqli_stmt_close($area_stmt);
}

check_email:

if ($message == "") {

    // Check if email already exists

        // Check if email already exists
        $check_email = "SELECT id FROM users WHERE email = ?";

        $stmt = mysqli_prepare($conn, $check_email);

        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $email
        );

        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {

            $message = "This email is already registered.";

        } else {

            // Hash the password
            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Insert user
            // Insert user
$sql = "INSERT INTO users
        (name, email, phone, password, province_id, district_id, area_id, sub_area_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssssiiii",
    $name,
    $email,
    $phone,
    $hashed_password,
    $province_id,
    $district_id,
    $area_id,
    $sub_area_id
);

if (mysqli_stmt_execute($stmt)) {

    header("Location: ./login.php");
    exit();

} else {

    $message = "Registration failed. Please try again.";

}
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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/register.css">

</head>

<body>

    <body>

    <div class="register-container">

        <div class="register-card">

            <div class="register-header">
                <h1>Create an Account</h1>
                <p>Join the Book Exchange System</p>
            </div>

    <?php if ($message != ""): ?>

        <p>
            <?php echo $message; ?>
        </p>

    <?php endif; ?>

<?php

$province_sql = "SELECT id, name FROM provinces ORDER BY name";

$province_result = mysqli_query($conn, $province_sql);

?>
    <form method="POST" action="" id="registerForm">

        <div class="form-group">

    <label for="name">Full Name</label>

    <input
        type="text"
        id="name"
        name="name"
        required
        pattern="[A-Za-z]+( [A-Za-z]+)*"
        title="Name should contain letters and spaces only."
        placeholder="Enter your full name"
    >

</div>




        <div class="form-group">

    <label for="email">Email</label>

    <input
        type="email"
        id="email"
        name="email"
        required
        pattern="[^\s@]+@[^\s@]+\.[^\s@]+"
        title="Please enter a valid email address without spaces."
        placeholder="Enter your email"
    >

</div>


<div class="form-group">
        <label for="phone">Phone:</label>
        <input
    type="tel"
    id="phone"
    name="phone"
    required
    pattern="(?:97|98)[0-9]{8}"
    maxlength="10"
    minlength="10"
    inputmode="numeric"
    title="Phone number must be exactly 10 digits and start with 97 or 98."
>
</div>


<div class="form-group">
        <label for="password">Password:</label>
        <input
    type="password"
    id="password"
    name="password"
    required
    minlength="8"
    pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}"
    title="Password must be at least 8 characters and contain an uppercase letter, lowercase letter, number, and special character."
>
</div>

<div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            required
        >
</div>

<div class="form-group">
        <label for="province">Province:</label>

<select
    id="province"
    name="province"
    required
>
    <option value="">Select Province</option>

    <?php while ($province = mysqli_fetch_assoc($province_result)): ?>

        <option value="<?php echo $province["id"]; ?>">
            <?php echo htmlspecialchars($province["name"]); ?>
        </option>

    <?php endwhile; ?>

</select>
</div>


<div class="form-group">
        <label for="district">District:</label>

<select
    id="district"
    name="district"
    required
    disabled
>
    <option value="">Select Province First</option>
</select>
</div>


<div class="form-group">
<label for="area">Area:</label>

<select
    id="area"
    name="area"
    required
    disabled
>
    <option value="">Select District First</option>
</select>
</div>


<div class="form-group">
<label for="sub_area">Sub-area:</label>

<select
    id="sub_area"
    name="sub_area"
    disabled
>
    <option value="">No Sub-area</option>
</select>

</div>





        <button type="submit" class="register-button">
    Create Account
</button>

<p class="login-link">
    Already have an account?
    <a href="login.php">Log in</a>
</p>

</form>

        </div>
    </div>

<script>

    const provinceSelect = document.getElementById("province");
const districtSelect = document.getElementById("district");
const areaSelect = document.getElementById("area");
const subAreaSelect = document.getElementById("sub_area");

    provinceSelect.addEventListener("change", function () {

        const provinceId = this.value;

        // Clear the old district options
        districtSelect.innerHTML = "";
        areaSelect.innerHTML = 
        '<option value="">Select District First</option>';
        areaSelect.disabled = true;
        
        subAreaSelect.innerHTML = 
        '<option value="">Select Area First</option>';
        subAreaSelect.disabled = true;

        // If no province is selected
        if (provinceId === "") {

            districtSelect.disabled = true;

            const option = document.createElement("option");

            option.value = "";
            option.textContent = "Select Province First";

            districtSelect.appendChild(option);

            return;
        }

        // Disable district while loading
        districtSelect.disabled = true;

        const loadingOption = document.createElement("option");

        loadingOption.value = "";
        loadingOption.textContent = "Loading districts...";

        districtSelect.appendChild(loadingOption);


        // Get districts from PHP
        fetch("get_districts.php?province_id=" + provinceId)

            .then(response => response.json())

            .then(data => {

                // Clear loading message
                districtSelect.innerHTML = "";
                

                // Enable district dropdown
                districtSelect.disabled = false;


                // Add placeholder
                const placeholder = document.createElement("option");

                placeholder.value = "";
                placeholder.textContent = "Select District";

                districtSelect.appendChild(placeholder);


                // Add districts
                data.forEach(district => {

                    const option = document.createElement("option");

                    option.value = district.id;

                    option.textContent = district.name;

                    districtSelect.appendChild(option);

                });

            })

            .catch(error => {

                console.error("Error loading districts:", error);

                districtSelect.innerHTML = "";

                const option = document.createElement("option");

                option.value = "";

                option.textContent = "Unable to load districts";

                districtSelect.appendChild(option);

            });

    });

    districtSelect.addEventListener("change", function () {

    const districtId = this.value;

    // Clear area
    areaSelect.innerHTML = "";

    // Clear sub-area
    subAreaSelect.innerHTML = "";

    if (districtId === "") {

        areaSelect.disabled = true;

        const option = document.createElement("option");
        option.value = "";
        option.textContent = "Select District First";

        areaSelect.appendChild(option);

        subAreaSelect.disabled = true;

        const subOption = document.createElement("option");
        subOption.value = "";
        subOption.textContent = "Select Area First";

        subAreaSelect.appendChild(subOption);

        return;
    }

    // Loading areas
    areaSelect.disabled = true;

    const loadingOption = document.createElement("option");
    loadingOption.value = "";
    loadingOption.textContent = "Loading areas...";

    areaSelect.appendChild(loadingOption);


    fetch("get_areas.php?district_id=" + districtId)

        .then(response => response.json())

        .then(data => {

            areaSelect.innerHTML = "";

            areaSelect.disabled = false;

            const placeholder = document.createElement("option");

            placeholder.value = "";
            placeholder.textContent = "Select Area";

            areaSelect.appendChild(placeholder);


            data.forEach(area => {

                const option = document.createElement("option");

                option.value = area.id;

                option.textContent = area.name;

                areaSelect.appendChild(option);

            });

        })

        .catch(error => {

            console.error("Error loading areas:", error);

            areaSelect.innerHTML = "";

            const option = document.createElement("option");

            option.value = "";

            option.textContent = "Unable to load areas";

            areaSelect.appendChild(option);

        });

});

areaSelect.addEventListener("change", function () {

    const areaId = this.value;

    subAreaSelect.innerHTML = "";

    if (areaId === "") {

        subAreaSelect.disabled = true;

        const option = document.createElement("option");

        option.value = "";

        option.textContent = "Select Area First";

        subAreaSelect.appendChild(option);

        return;
    }


    subAreaSelect.disabled = true;

    const loadingOption = document.createElement("option");

    loadingOption.value = "";

    loadingOption.textContent = "Loading sub-areas...";

    subAreaSelect.appendChild(loadingOption);


    fetch("get_sub_areas.php?area_id=" + areaId)

        .then(response => response.json())

        .then(data => {

            subAreaSelect.innerHTML = "";

            if (data.length === 0) {

                subAreaSelect.disabled = true;

                const option = document.createElement("option");

                option.value = "";

                option.textContent = "No Sub-area";

                subAreaSelect.appendChild(option);

                return;
            }


            subAreaSelect.disabled = false;

            const placeholder = document.createElement("option");

            placeholder.value = "";

            placeholder.textContent = "Select Sub-area";

            subAreaSelect.appendChild(placeholder);


            data.forEach(subArea => {

                const option = document.createElement("option");

                option.value = subArea.id;

                option.textContent = subArea.name;

                subAreaSelect.appendChild(option);

            });

        })

        .catch(error => {

            console.error("Error loading sub-areas:", error);

            subAreaSelect.innerHTML = "";

            subAreaSelect.disabled = true;

            const option = document.createElement("option");

            option.value = "";

            option.textContent = "Unable to load sub-areas";

            subAreaSelect.appendChild(option);

        });

});


</script>
</body>

</html>
