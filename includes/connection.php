<?php
$conn = new mysqli("localhost", "root", "", "smartlostfound", 3307);

if($conn->connect_error)
{
    die("Connection Failed : " . $conn->connect_error);
}
?>
