<?php
   // Connect to database
    $conn = mysqli_connect('localhost', 'remote', 'huadatabasesql', 'final_project');

    // Check connection
    if (!$conn)
    {
        echo 'Connection error: ' . mysqli_connect_error();
    }
?>