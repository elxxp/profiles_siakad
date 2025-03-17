<?php
session_start();
require 'config.php';
$continue = false;

if(isset($_SESSION['keyOwn'])){

    if(isset($_POST['idKey']) && isset($_POST['keyOwn'])) {
        $profile = htmlspecialchars($_POST['idKey']);
        $key = htmlspecialchars($_POST['keyOwn']);

        if($profile != ""){

            if($key == $_SESSION['keyOwn']) {

                if(preg_match("/^\\d+$/", $profile)) {
                    $sql = "SELECT * FROM profiles WHERE idKey = $profile";
                    $result = $conn->query($sql);
                    $data = $result->fetch_assoc();

                    if(mysqli_num_rows($result) > 0) {

                        if($data['bypass'] == 'true'){
                            @$passKey = base64_decode($data['passKey']);
                            $continue = true;
                        } else {
                            $status = '<li id="error" class="w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Non-Bypassable profile, redirecting...</li>';
                            header('Refresh:3; url=../views/main');
                        }

                    } else {
                        $status = '<li id="error" class="w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Profile unvailable, redirecting...</li>';
                        header('Refresh:3; url=../views/main');
                    }
                    
                } else {
                    $status = '<li id="error" class="w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Invalid profile, redirecting...</li>';
                    header('Refresh:3; url=../views/main');
                }
            } else {
                $status = '<li id="error" class="w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Key invalid, redirecting...</li>';
                header('Refresh:3; url=../views/main');
            }

        } else {
            $status = '<li id="error" class="w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>No profile selected, redirecting...</li>';
            header('Refresh:3; url=../views/main');
        }

    } else {
        $status = '<li id="error" class="w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Invalid request #2, redirecting...</li>';
        header('Refresh:3; url=../views/main');
    }

} else {
    $status = '<li id="error" class="w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Unknown request, redirecting...</li>';
    header('Refresh:3; url=../views/main');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/output.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
    <link rel="stylesheet" href="../lib/css/font.css">
    <link rel="stylesheet" href="../lib/css/keyframes.css">
    <title>Directing...</title>
</head>
<body>
    <div id="overlay" class="fixed z-99 top-0 w-screen h-screen bg-black/40"></div>
    <div id="loading" class="flex items-center justify-center fixed z-100 top-[50%] left-[50%] translate-[-50%] size-20 bg-gray-100 rounded-xl">
        <i class="fa-solid fa-spinner-third fa-spin fa-spin-reverse absolute text-gray-300 text-3xl" style="--fa-animation-duration: 1s;"></i>
        <i class="fa-solid fa-spinner-third fa-spin text-3xl"></i>
    </div>

    <center>
        <div class="fixed z-100 inset-x-0 mx-auto top-5">
            <ul id="sessionStatus">
                <?= @$status ?>
            </ul>
        </div>
    </center>
    
    <form id="form" action="http://103.153.190.121/siakad/ceklogin.php" method="post">
        <input type="hidden" name="userid" value="<?= $data['userKey'] ?>">
        <input type="hidden" name="password" value="<?= $passKey ?>">
        <input type="hidden" name="level" value="<?= $data['levelKey'] ?>">
    </form>
</body>
<script>
    <?php if($continue == 'true'): ?>
    var formSubmitted = false;
    window.onload = function() {
        document.getElementById("form").submit();
        formSubmitted = true;
        setTimeout(function() {
            if (formSubmitted) {
                window.location.href = 'directError'
            }
        }, 5000);
    };
    function checkSuccess() {
        formSubmitted = false;
    }
    <?php endif; ?>
</script>
</html>