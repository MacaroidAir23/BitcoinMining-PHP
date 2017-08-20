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

    $userdata = "";

    $sql = "SELECT userdata
                FROM $credentials->table_user 
                WHERE user = '$user'
                AND pass = '$pass'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userdata = $row['userdata'];
            break;
        }
    }

    if ($con->query($sql)) {
        echo json_encode($userdata);
    } else {
        echo json_encode(0);
    }
}
?>