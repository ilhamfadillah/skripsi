<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "skripsi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_once "controller/UserController.php";
require_once "controller/UsahaController.php";
require_once "model/UsahaModel.php";
// require_once "model/WisataModel.php";
// require_once "model/GaleriModel.php";
