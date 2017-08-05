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
        $sql = "SELECT * FROM $credentials->table_user WHERE invite = '$invite'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $exist = FALSE;
            while ($row = $result->fetch_assoc()) {
                echo json_encode("true");
                break;
            }
        } else {
            echo json_encode("false");
        }
    }
?>