<?php
session_start();

    $token = bin2hex(random_bytes(32));
    $_SESSION['token'] = $token;
    header('Location: ../views/login?token='.$token);
?>