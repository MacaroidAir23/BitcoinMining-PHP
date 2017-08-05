<?php

    spl_autoload_register(function ($class){
        include $class . '.php';
    });

    $credentials = new credentials();

    $con = new mysqli($credentials->hostname, $credentials->username, $credentials->password, $credentials->dbname);

    $user = $_POST['user'];

    if ($con->connect_error){
        echo json_encode("false");
    } else {
        $sql = "SELECT invite FROM $credentials->table_user WHERE user = '$user'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $exist = FALSE;
            while ($row = $result->fetch_assoc()) {
                echo json_encode($row['invite']);
                break;
            }
        } else {
            echo json_encode("");
        }
    }
?>