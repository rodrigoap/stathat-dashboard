<?php
    $dblink = new mysqli('localhost', 'db_user', 'db_pass', 'db_schema') or die('There was a problem connecting to the database');
    if(mysqli_connect_errno()) {
        echo "Connection Failed: " . mysqli_connect_errno();
        exit();
    }
?>
