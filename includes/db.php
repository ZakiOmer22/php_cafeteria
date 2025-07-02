<?php

$ServerName = "localhost";
$Database = "cafeteria_db";
$user = "root";
$password = "";

$conn = mysqli_connect($ServerName, $user, $password, $Database);


if (!$conn) {
    echo "Connection Failed ... \n Check The Connection";
}

?>