<?php

session_start();

$conn = new mysqli("localhost", "root", "", "smartlostfound", 3307);

if($conn->connect_error)
{
    die("Connection Failed : " . $conn->connect_error);
}

/* GET ITEM ID FROM URL */

$item_id = $_GET['item_id'] ?? null;

if(!$item_id)
{
    die("Invalid Item ID");
}

/* GET ITEM + FINDER DETAILS */

$sql = "SELECT items.*, 
        users.full_name, 
        users.email,
        users.phone_number

        FROM items

        JOIN users 
        ON items.user_id = users.user_id

        WHERE items.item_id = '$item_id'";

$result = $conn->query($sql);

if(!$result || $result->num_rows == 0)
{
    die("Item Not Found");
}

$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Claim Item</title>

    <link rel="stylesheet" href="assets/css/claim-item.css">

</head>

<body>
    <?php include 'includes/navbar.php'; ?>
    
<?php
    $is_logged_in = isset($_SESSION['user_id']);
    ?>

<section class="claim-page">

    <div class="claim-container">

        <!-- ITEM DETAILS -->

        <div class="item-details">

            <img 
                src="<?php echo $row['image']; ?>"
                class="item-image"
                alt="Item Image"
            >

            <h2>

                <?php echo $row['item_name']; ?>

            </h2>

            <p>

                <strong>Category:</strong>

                <?php echo $row['category']; ?>

            </p>

            <p>

                <strong>Location:</strong>

                <?php echo $row['location']; ?>

            </p>

            <p>

                <strong>Date:</strong>

                <?php echo $row['created_at']; ?>

            </p>

            <p>

                <strong>Description:</strong>

                <?php echo $row['description']; ?>

            </p>

        </div>

        <!-- FINDER DETAILS -->

        <div class="finder-details">

            <h3>

                Finder Information

            </h3>

            <p>

                <strong>Name:</strong>

                <?php echo $row['full_name']; ?>

            </p>

            <p>

                <strong>Email:</strong>

                <?php echo $row['email']; ?>

            </p>

            <p>

                <strong>Phone:</strong>

                <?php echo $row['phone_number']; ?>

            </p>

            <a 
                href="https://wa.me/<?php echo $row['phone_number']; ?>?text=Hello%20I%20would%20like%20to%20claim%20the%20item%20<?php echo urlencode($row['item_name']); ?>" 
                target="_blank"
                class="whatsapp-btn"
                >

                    Contact on WhatsApp

            </a>
        </div>

        

        

    </div>

</section>

</body>

</html>