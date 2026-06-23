<?php
//session_start();

$is_logged_in = isset($_SESSION['user_id']);
$full_name = $_SESSION['full_name'] ?? '';

// Extract first name from full name
$first_name = '';
if (!empty($full_name)) {
    $name_parts = explode(' ', $full_name);
    $first_name = $name_parts[0];
}
?>

<header class="navbar">
    <div class="nav-container">
        <div class="logo-section">

            <h2><a href="dashboard.php" style="text-decoration: none; color: inherit;">Smart Lost & Found</a></h2>
        </div>

        <nav class="nav-links">
            <a href="dashboard.php">Home</a>
            <a href="search.php">Search</a>

            <?php if ($is_logged_in): ?>
                <a href="upload-item.php" class="report-btn">
                    Report Item
                </a>
                <div class="user-menu">
                    <span class="user-name"><?php echo htmlspecialchars($first_name); ?></span>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
            <?php else: ?>
                <a href="login.php" class="login-btn">
                    Login
                </a>
                <a href="register.php" class="register-btn">
                    Register
                </a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-200..200">

<style>

    .navbar {
        background-color: #ffffff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 70px;
    }

    .logo-section {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 24px;
        font-weight: 600;
        color: #333;
    }

    .logo-icon {
        font-size: 32px;
        color: #2196F3;
    }

    .logo-section h2 {
        margin: 0;
        font-size: 24px;
    }

    .nav-links {
        display: flex;
        gap: 25px;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-links a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
        font-size: 15px;
        transition: color 0.3s ease;
    }

    .nav-links a:hover {
        color: #2196F3;
    }

    .login-btn {
        padding: 8px 16px;
        background-color: #2196F3;
        color: white;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .login-btn:hover {
        background-color: #1976D2;
    }

    .register-btn {
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .register-btn:hover {
        background-color: #45a049;
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: 10px;
    }

    .user-name {
        font-weight: 500;
        color: #333;
        font-size: 14px;
    }

    .logout-btn {
        padding: 6px 12px;
        background-color: #ff6b6b;
        color: white;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .logout-btn:hover {
        background-color: #ff5252;
    }

    .report-btn {
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .report-btn:hover {
        background-color: #45a049;
    }

    @media (max-width: 768px) {
        .nav-container {
            flex-direction: column;
            height: auto;
            padding: 15px 20px;
            gap: 15px;
        }

        .nav-links {
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        .logo-section h2 {
            font-size: 20px;
        }
    }
</style>
