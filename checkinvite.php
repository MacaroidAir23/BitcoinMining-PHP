<?php

    spl_autoload_register(function ($class){
        include $class . '.php';
    });

    $credentials = new credentials();

    $con = new mysqli($credentials->hostname, $credentials->username, $credentials->password, $credentials->dbname);

    $invite = $_POST['code'];

    if ($con->connect_error){
        echo json_encode("false");
    } else {

        $promocoins = 0;

        $sql = "SELECT * FROM $credentials->table_user WHERE invite = '$invite'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $promocoins = $row['promocoins'];
                echo json_encode("true");
                break;
            }

            $promocoins += 1000;

            $sql = "UPDATE $credentials->table_user 
            SET promocoins = '$promocoins'
            WHERE invite = '$invite'";
            $con->query($sql);
        } else {
            echo json_encode("false");
        }
    }
?>