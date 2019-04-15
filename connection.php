<?php

    // Database Credentials

    $servername = "localhost";
    $username = "relief_support";
    $password = "RSupport";
    $database = "relief";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //echo "Connected successfully";

?>