<?php
require '../database/config.php';

$sql = "SELECT * FROM profiles";
$result = $conn->query($sql);

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
    <title>Main</title>
</head>
<body>
    <center>
        <div id="overlay" class="fixed z-99 top-0 w-screen h-screen bg-black/40 hidden"></div>
        <div id="loading" class="flex items-center justify-center fixed z-100 top-[50%] left-[50%] translate-[-50%] size-20 bg-gray-100 rounded-xl hidden">
            <i class="fa-solid fa-spinner-third fa-spin fa-spin-reverse absolute text-gray-300 text-3xl" style="--fa-animation-duration: 1s;"></i>
            <i class="fa-solid fa-spinner-third fa-spin text-3xl"></i>
        </div>

        <div class="fixed z-100 inset-x-0 mx-auto top-5">
            <ul id="sessionStatus">
                <li id="o1" class="hidden w-fit text-xs bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-spinner-third fa-spin mr-2"></i>Checking key...</li>
                <li id="o2" class="hidden w-fit text-xs bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-spinner-third fa-spin mr-2"></i>Creating new session...</li>
                <li id="o3" class="hidden w-fit text-xs bg-green-100 border border-green-300 rounded-lg px-4 py-2 mb-1 "><i class="fa-solid fa-circle-check text-green-500 mr-2"></i>Session created</li>
                <li id="o4" class="hidden w-fit text-xs bg-green-100 border border-green-300 rounded-lg px-4 py-2 mb-1 "><i class="fa-solid fa-spinner-third fa-spin mr-2"></i>Directing to <strong>10.100.10.2</strong></li>
            </ul>
        </div>

        <div class="profiles w-150 h-[70vh] my-20 bg-gray-100/50 border border-gray-200 p-7 rounded-xl">
            
            <h1 class="text-left font-semibold mb-3">10.100.10.2 Area</h1>
            <?php while($data = $result->fetch_assoc()): ?>
            <div class="profile flex items-center justify-between w-full bg-gray-100 border border-gray-300 rounded-lg px-5 py-2 mb-3 shadow-sm">
                <div class="inner-profile flex items-center">
                    <i class="fa-solid fa-user text-base"></i>
                    <div class="profile-information inline text-left ml-4">
                        <p class="font-semibold"><?= $data['userDisplay'] ?><span class="font-normal text-xs ml-1"><?= $data['nameDisplay'] ?></span></p>
                        <div class="profile-status flex items-center aling-start gap-1">
                            <p class="flex items-center w-fit text-[10px] bg-sky-100 border border-sky-300 rounded-lg px-2">
                                <i class="mr-1 fa-regular fa-cards-blank text-[7px] text-sky-500"></i>
                                <?= ucfirst($data['levelKey']) ?>
                            </p>

                            <?php if($data['detect'] == 'false'){ // check log detetcted ?>
                                <p class="flex items-center w-fit text-[10px] bg-green-100 border border-green-300 rounded-lg px-2">
                                    <i class="mr-1 fa-regular fa-user-secret text-[7px] text-green-500"></i>
                                    Log undetected
                                </p>
                            <?php } else { ?>
                                <p class="flex items-center w-fit text-[10px] bg-red-100 border border-red-300 rounded-lg px-2">
                                    <i class="mr-1 fa-solid fa-triangle-exclamation text-[7px] text-red-500"></i>
                                    Log detected
                                </p>
                            <?php } ?>

                            <?php if($data['bypass'] == 'true'){ ?>
                                <p class="flex items-center w-fit text-[10px] bg-green-100 border border-green-300 rounded-lg px-2">
                                    <i class="mr-1 fa-solid fa-lock-open text-[6px] text-green-500"></i>
                                    Bypassed
                                </p>
                            <?php } else { ?>
                                <p class="flex items-center w-fit text-[10px] bg-red-100 border border-red-300 rounded-lg px-2">
                                    <i class="mr-1 fa-solid fa-lock text-[6px] text-red-500"></i>
                                    un-Bypassed
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <?php if($data['bypass'] == 'true'){ ?>
                    <div onclick=directing() class="direct bg-gray-200 border border-gray-300 rounded-lg px-1.5 py-1 cursor-pointer">
                        <i class="fa-regular fa-key text-sm"></i>
                        <p class="text-[7px]">Get session</p>
                    </div>
                <?php } else { ?>
                    <div class="direct opacity-50 bg-gray-200 border border-gray-300 rounded-lg px-1.5 py-1">
                        <i class="fa-regular fa-lock text-sm"></i>
                        <p class="text-[7px]">Get session</p>
                    </div>
                <?php } ?>

                <form action="../database/directLocal.php" method="post" id="profile1" class="hidden"><input type="hidden" name="idKey" value="1"></form>
            </div>
            <?php endwhile; ?>

            <h1 class="text-left font-semibold mb-3 mt-7">103.153.190.121 Area</h1>

        </div>
    </center>
</body>
<script src="../lib/js/main.js"></script>
<script>
function directing(){
    document.getElementById('o1').classList.add('hidden');
    document.getElementById('o2').classList.add('hidden');
    document.getElementById('o3').classList.add('hidden');
    document.getElementById('o4').classList.add('hidden');

    document.getElementById('overlay').classList.remove('hidden');
    document.getElementById('loading').classList.remove('hidden');

    setTimeout(function(){
        document.getElementById('o1').classList.remove('hidden');
    }, 500);

    setTimeout(function(){
        document.getElementById('o1').classList.add('hidden');
        document.getElementById('o2').classList.remove('hidden');
    }, 2500);

    setTimeout(function(){
        document.getElementById('o2').classList.add('hidden');
        document.getElementById('o3').classList.remove('hidden');
    }, 5000);

    setTimeout(function(){
        document.getElementById('o3').classList.add('hidden');
        document.getElementById('o4').classList.remove('hidden');
    }, 7500);

    setTimeout(function(){
        document.getElementById('profile1').submit();
    }, 8000);
    
    setTimeout(function(){
        document.getElementById('overlay').classList.add('hidden');
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('o4').classList.add('hidden');
    }, 15000);
}
</script>
</html>