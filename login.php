<?php

    spl_autoload_register(function ($class){
        include $class . '.php';
    });

    $credentials = new credentials();

    $con = new mysqli($credentials->hostname, $credentials->username, $credentials->password, $credentials->dbname);

    if ($con->connect_error){
        echo json_encode("false");
    } else {

        $user = $_POST['user'];
        $pass = $_POST['pass'];

        if (isset($user) && isset($pass)) {
            if (strlen($user) > 0 && strlen($pass) > 0) {
                $sql = "SELECT user, pass FROM $credentials->table_user";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    $exist = FALSE;
                    while ($row = $result->fetch_assoc()) {
                        if ($row['user'] == $user && $row['pass'] == $pass) {
                            $exist = TRUE;
                            break;
                        }
                    }
                    if ($exist == TRUE) {
                        echo json_encode("true");
                    } else {
                        echo json_encode("false");
                    }
                } else {
                    echo json_encode("false");
                }
            } else {
                echo json_encode("false");
            }
        } else {
            echo json_encode("false");
        }
    }
?>