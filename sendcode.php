<?php

    spl_autoload_register(function ($class){
        include $class . '.php';
    });

    $credentials = new credentials();

    $subject = 'Amazon Gift Card from Gift Team';

    $from = "actgift@gmail.com";
    $email = $_POST['email'];
    $code = $_POST['code'];

    $headers = "From: " . strip_tags($from) . "\r\n";
    $headers .= "Reply-To: ". strip_tags($email) . "\r\n";
    $headers .= "CC: giftamarewardshelp@gmail.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $message = '<font size="5" color="gray">Dear User!</font><br>';
    $message .= '<font size="5" color="gray">Congratulations!</font><br>';
    $message .= '<font size="5" color="gray">You have just received your gift card! Thank you for using our application!</font><br>';
    $message .= '<font size="5" color="red">' .$code . '</font><br>';
    $message .= '<form action="https://www.amazon.com/gc/redeem/ref=gc_redeem_new_exp_DesktopRedirect/145-0134816-8972977?_encoding=UTF8&claimCode="><input type="submit" value="Redeem Now" style="background: red" width="200" height="50"><br>';

    mail($email, $subject, $message, $headers);

    $con = new mysqli($credentials->hostname, $credentials->username, $credentials->password, $credentials->dbname);

    if (strlen($email) > 0) {
        $sql = "INSERT INTO $credentials->table_email (email) VALUES ('$email')";
        if ($con->query($sql) === true) {
            echo json_encode("true");
        }
    }
    $con->close();
?>