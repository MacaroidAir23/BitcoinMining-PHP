<?php

    spl_autoload_register(function ($class_name) {
        include $class_name . '.php';
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
                $exist = FALSE;
                while ($row = $result->fetch_assoc()) {
                    if ($row['user'] == $user) {
                        $exist = TRUE;
                        break;
                    }
                }
                if ($exist == FALSE) {
                    $code = getInviteCode();
                    $sql = "INSERT INTO $credentials->table_user (user, pass, invite, promocoins) VALUES ('$user', '$pass', '$code', 0)";
                    if ($con->query($sql) == TRUE) {
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

    function getInviteCode() {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $code = '';
        for ($i = 0; $i < 10; $i++) {
            $code .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }
        return $code;
    }
?>