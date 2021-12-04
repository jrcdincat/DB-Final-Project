<?php
   // Connect to database
    $conn = mysqli_connect('localhost', 'root', '', 'final_project');

    // Check connection
    if (!$conn)
    {
        echo 'Connection error: ' . mysqli_connect_error();
    }
?>