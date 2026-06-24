<?php
// 1. Database Connection
include 'includes/connection.php';

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 2. Fetch all users from the database, ordered by newest first
$sql = "SELECT * FROM users ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/admin_dashboard.css">
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-logo">
            <span class="material-symbols-outlined">admin_panel_settings</span>
            Admin Panel
        </div>

        <a href="admin_dashboard.php" class="nav-item">
            <span class="material-symbols-outlined">dashboard</span>
            Dashboard
        </a>
        <a href="admin_users.php" class="nav-item active">
            <span class="material-symbols-outlined">group</span>
            Users
        </a>
        <a href="admin_items.php" class="nav-item">
            <span class="material-symbols-outlined">inventory_2</span>
            Items
        </a>
        <a href="admin_claims.php" class="nav-item">
            <span class="material-symbols-outlined">assignment</span>
            Claims
        </a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Registered Users</h1>
            <a href="login.php" class="logout-btn">
                <span class="material-symbols-outlined">logout</span>
                Logout
            </a>
        </div>

        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Registered Date</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // 3. Loop through the fetched database records
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                            
                            // NEW: Action buttons for Edit and Delete
                            echo "<td style='text-align: right;'>
                                    <div class='action-btn-group'>
                                        <a href='edit_user.php?id=" . $row['user_id'] . "' class='btn-icon btn-edit' title='Edit User'>
                                            <span class='material-symbols-outlined'>edit</span>
                                        </a>
                                        <a href='delete_user.php?id=" . $row['user_id'] . "' class='btn-icon btn-delete' title='Delete User' onclick='return confirm(\"Are you sure you want to delete this user? This action cannot be undone.\");'>
                                            <span class='material-symbols-outlined'>delete</span>
                                        </a>
                                    </div>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        // Display message if no users exist
                        echo "<tr><td colspan='5' style='text-align: center; padding: 40px; color: var(--text-muted);'>No users found in the system.</td></tr>";
                    }
                    
                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>