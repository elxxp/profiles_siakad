<?php
setcookie('errorDirect', 'true', time() + 1, "/");
header('Location: ../views/main');
?>