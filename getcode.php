<?php

    spl_autoload_register(function ($class){
        include $class . '.php';
    });

    $code = '';
    for ($i = 0; $i < 3; $i++) {
        $code .= random_int(0, 9);
    }
    $code .= ' ';
    for ($i = 0; $i < 3; $i++) {
        $code .= random_int(0, 9);
    }
    $code .= ' ';
    $code .= random_int(0, 9);
    $code .= randomLetter();
    $code .= randomLetter();
    $code .= ' ';
    $code .= random_int(0, 9);
    $code .= random_int(0, 9);

    echo json_encode($code);

    function randomLetter() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        return $alphabet[random_int(0, strlen($alphabet) - 1)];
    }
?>