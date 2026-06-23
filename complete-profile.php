<?php
session_start();
include 'includes/connection.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$messageType = "";

// Check if user already has phone number
$user_id = $_SESSION['user_id'];
$check_sql = "SELECT phone_number FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $check_sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// If phone already exists, redirect to dashboard
if (!empty($user['phone_number'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle phone number submission
if (isset($_POST['save_phone'])) {
    $country_code = $_POST['country_code'] ?? '';
    $phone = trim($_POST['phone_number'] ?? '');

    // Remove starting 0 if exists
    if (substr($phone, 0, 1) == "0") {
        $phone = substr($phone, 1);
    }

    $phone_number = $country_code . $phone;

    if (empty($phone_number)) {
        $message = "Phone number is required!";
        $messageType = "error";
    } elseif (strlen($phone) < 7) {
        $message = "Please enter a valid phone number!";
        $messageType = "error";
    } else {
        // Update phone number in database
        $update_sql = "UPDATE users SET phone_number = ? WHERE user_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "si", $phone_number, $user_id);

        if (mysqli_stmt_execute($update_stmt)) {
            $_SESSION['phone_number'] = $phone_number;
            $message = "Phone number saved successfully!";
            $messageType = "success";
            // Redirect after 2 seconds
            header("refresh:2;url=dashboard.php");
        } else {
            $message = "Error saving phone number. Please try again.";
            $messageType = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Profile</title>
    <link rel="stylesheet" href="assets/css/register.css">
    <style>
        .message {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .profile-note {
            background-color: #e7f3ff;
            border-left: 4px solid #0d6efd;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #004085;
        }
    </style>
</head>

<body>

    <?php include 'includes/navbar.php'; ?>

    <section class="register-section">

        <div class="register-container">

            <h1>Complete Your Profile</h1>

            <p>We need your phone number to complete your registration</p>

            <div class="profile-note">
                <strong>📱 Almost there!</strong> Your Google account is linked. Just add your phone number to finish setup.
            </div>

            <?php if ($message != "") { ?>
                <div class="message <?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php } ?>

            <form method="POST" action="complete-profile.php">

                <div class="form-group">
                    <label>Phone Number</label>

                    <div style="display:flex; gap:10px;">

                        <select name="country_code" required style="width:120px;">
                            <option value="94">+94 (Sri Lanka)</option>
                            <option value="91">+91 (India)</option>
                            <option value="1">+1 (USA/Canada)</option>
                            <option value="44">+44 (UK)</option>
                            <option value="61">+61 (Australia)</option>
                        </select>

                        <input
                            type="text"
                            name="phone_number"
                            placeholder="771234567"
                            required
                        >

                    </div>
                </div>

                <button
                    type="submit"
                    name="save_phone"
                    class="register-btnnn"
                >
                    Save & Continue
                </button>

            </form>

            <div class="login-link">
                <p>
                    <a href="dashboard.php">Skip for now</a>
                </p>
            </div>

        </div>

    </section>

</body>

</html>
