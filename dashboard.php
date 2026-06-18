<?php session_start();
include 'includes/connection.php';

$sql = "SELECT * FROM items ORDER BY item_id	 DESC LIMIT 3";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart Lost & Found</title>

    <link rel="stylesheet" type="text/css" href="assets/css/dashboard.css" />

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>

    <?php include 'includes/navbar.php'; ?>
    
    <?php
    $is_logged_in = isset($_SESSION['user_id']);
    ?>


    <section class="hero-section">

        <div class="hero-content">

            <div class="hero-text">

                <div class="tag">
                    Official University Platform
                </div>

                <h1>
                    Find Lost Items Easily
                </h1>

                <p>
                    A dedicated platform for students and staff to report and recover lost belongings safely and
                    efficiently.
                </p>

                <div class="hero-buttons">

                    <?php if ($is_logged_in): ?>
                        <a href="upload-item.php?type=lost" class="primary-btn">
                            Report Lost Item
                        </a>

                        <a href="upload-item.php?type=found" class="secondary-btn">
                            Report Found Item
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="primary-btn">
                            Login to Report Items
                        </a>

                        <a href="register.php" class="secondary-btn">
                            Create Account
                        </a>
                    <?php endif; ?>

                </div>

            </div>

            <div class="hero-image">

                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBsM_u4-kRkS6bhCDrWcaAKHLrgEAyY64XpTPgCHGBA4uKyUkDEcjPxFLvtoJidlUGvAL4FOczqi1Ru1hgbhZj3MVEyMRc1IwzbKslDEspH4oo21VrU7LzDnwjRMG4AJC1X_rpRGTyl_d7hYpZtKUx2hrwvHXGtqVI0zdzxVfyX1f0xc2mrLgWpFApC_22yhIixjCdxY6HMl9i1h2RIRx2PNaz_kAwxKQQCVIBQUA9h1sKL37wq_fGzl45MKAFAVKg6wMUR2V39gNhe"
                    alt="Student" />

            </div>

        </div>

    </section>

    <!-- SEARCH SECTION -->

    <section class="search-section">

        <div class="search-container">

            <input type="text" placeholder="Search for lost items..." />

            <select>
                <option>All Locations</option>
                <option>Library</option>
                <option>Gym</option>
                <option>Engineering Hall</option>
            </select>

            <button class="search-btn">
                Search
            </button>

        </div>

    </section>

    <!-- ITEMS SECTION -->

    <section class="items-section">

        <div class="section-title">

            <div>

                <h2>Latest Items</h2>

                <p>
                    Recently reported items across campus
                </p>

            </div>

            <a href="all-items.php" class="view-all-btn">
                View All
            </a>

        </div>

        <div class="item-grid">

            <?php

            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {

                    $badgeClass = "";

                    if($row['item_type'] == "Lost")
                    {
                        $badgeClass = "lost-badge";
                    }
                    else
                    {
                        $badgeClass = "found-badge";
                    }

            ?>

            <!-- CARD -->

            <div class="item-card">

                <div class="item-image">

                    <img 
                        src="<?php echo $row['image']; ?>"
                        alt="Item Image"
                    />

                    <span class="<?php echo $badgeClass; ?>">

                        <?php echo $row['item_type']; ?>

                    </span>

                </div>

                <div class="item-content">

                    <h3>

                        <?php echo $row['item_name']; ?>

                    </h3>

                    <p>

                        Location: <?php echo $row['location']; ?>

                    </p>

                    <p>

                        Category: <?php echo $row['category']; ?>

                    </p>

                    <div class="item-actions">
                        <?php if($row['item_type'] == "Lost"): ?>
                            <a href="report-found.php?item_id=<?php echo $row['item_id']; ?>" class="action-btn report-found-btn">
                                Report Found
                            </a>
                        <?php else: ?>
                            <a href="claim-item.php?item_id=<?php echo $row['item_id']; ?>">

                                Claim Item
                            </a>
                        <?php endif; ?>
                    </div>

                </div>

            </div>

            <?php

                }
            }
            else
            {
                echo "<p>No Items Found</p>";
            }

            ?>

        </div>

    </section>

    <!-- INFO SECTION -->

    <section class="info-section">

        <div class="info-box">

            <h2>How It Works</h2>

            <div class="steps">

                <div class="step">

                    <div class="step-number">1</div>

                    <h3>Report Item</h3>

                    <p>Upload lost or found item details.</p>

                </div>

                <div class="step">

                    <div class="step-number">2</div>

                    <h3>Smart Match</h3>

                    <p>System suggests matching items.</p>

                </div>

                <div class="step">

                    <div class="step-number">3</div>

                    <h3>Recover Item</h3>

                    <p>Claim and recover safely.</p>

                </div>

            </div>

        </div>

    </section>

    <!-- FOOTER -->

    <footer class="footer">

        <h3>Smart Lost & Found</h3>

        <p>© 2026 University Services</p>

    </footer>

</body>

</html>