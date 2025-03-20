<?php
session_start();
session_unset();
session_destroy();
setcookie('logout', 'true', time() + 1, "/");
header("Location: ../views/main");
?>