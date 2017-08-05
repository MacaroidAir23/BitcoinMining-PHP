<?php

    spl_autoload_register(function ($class){
        include $class . '.php';
    });

    $credentials = new credentials();

    $con = new mysqli($credentials->hostname, $credentials->username, $credentials->password, $credentials->dbname);

    $code = $_POST['code'];

    if ($con->connect_error) {
        echo json_encode("false");
    } else {

        $coins = 200;

        $sql = "SELECT * FROM $credentials->table_user WHERE invite = '$code'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $coins += $row['promocoins'];
                break;
            }
        }

        $sql = "UPDATE $credentials->table_user SET promocoins = $coins WHERE invite = '$code'";

        if ($con->query($sql)) {
            echo json_encode("true");
        } else {
            echo json_encode("false");
        }
    }
?>