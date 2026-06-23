<?php
session_start();
include 'includes/connection.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $country_code = $_POST['country_code'] ?? '';
    $phone = trim($_POST['phone_number'] ?? '');
    $user_id = $_SESSION['user_id'];

    // Remove starting 0 if exists
    if (substr($phone, 0, 1) == "0") {
        $phone = substr($phone, 1);
    }

    $phone_number = $country_code . $phone;

    // Validate
    if (empty($phone_number) || strlen($phone) < 7) {
        echo json_encode(['success' => false, 'message' => 'Please enter a valid phone number']);
        exit();
    }

    // Update database
    $sql = "UPDATE users SET phone_number = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $phone_number, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['phone_number'] = $phone_number;
        echo json_encode(['success' => true, 'message' => 'Phone number saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error saving phone number']);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
