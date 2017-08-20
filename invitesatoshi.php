<?php

    spl_autoload_register(function ($class){
        include $class . '.php';
    });

    $credentials = new credentials();

    $con = new mysqli($credentials->hostname, $credentials->username, $credentials->password, $credentials->dbname);

    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if ($con->connect_error) {
        echo json_encode(0);
    } else {

        $coins = 0;

        $sql = "SELECT promocoins
                FROM $credentials->table_user 
                WHERE user = '$user'
                AND pass = '$pass'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $coins = $row['promocoins'];
                break;
            }
        }

        $sql = "UPDATE $credentials->table_user 
                SET promocoins = 0 
                WHERE user = '$user'
                AND pass = '$pass'";

        if ($con->query($sql)) {
            echo json_encode($coins);
        } else {
            echo json_encode(0);
        }
    }
?>