<?php
session_start();
require '../database/config.php';

$sql = "SELECT * FROM profiles ORDER BY levelKey ASC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/output.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
    <link rel="stylesheet" href="https://cdn.hugeicons.com/font/hgi-stroke-rounded.css"/>
    <link rel="stylesheet" href="../lib/css/font.css">
    <link rel="stylesheet" href="../lib/css/keyframes.css">
    <title>Main</title>
    <style> *::-webkit-scrollbar { display: none; }</style>
</head>
<body>
    <center>
        <div id="overlay" class="fixed z-99 top-0 w-screen h-screen bg-black/40 hidden"></div>
        <div id="loading" class="flex items-center justify-center fixed z-100 top-[50%] left-[50%] translate-[-50%] size-20 bg-gray-100 rounded-xl hidden">
            <i class="fa-solid fa-spinner-third fa-spin fa-spin-reverse absolute text-gray-300 text-3xl" style="--fa-animation-duration: 1s;"></i>
            <i class="fa-solid fa-spinner-third fa-spin text-3xl"></i>
            <button id="cancel" onclick="stopAct()" class="flex items-center justify-center fixed z-100 top-[65%] left-[50%] translate-[-50%] w-32 h-8 bg-gray-100 rounded-md mt-15 text-xs cursor-pointer"><i class="fa-regular fa-arrow-left-to-line mr-1"></i>cancel request</button>
        </div>

        <div class="fixed z-100 inset-x-0 mx-auto top-5">
            <ul id="sessionStatus">
                <?php if(isset($_COOKIE['errorDirect'])): ?>
                    <li id="error" class="w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Error directing, try again</li>
                <?php endif; ?>

                <?php if(isset($_SESSION['keyOwn'])){ ?>
                    <li id="o1" class="hidden w-fit text-xs bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-spinner-third fa-spin mr-2"></i>Checking key...</li>
                    <li id="o2" class="hidden w-fit text-xs text-green-600 bg-green-100 border border-green-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-check text-green-500 mr-2"></i>Key verified</li>
                    <li id="o3" class="hidden w-fit text-xs bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-spinner-third fa-spin mr-2"></i>Creating new session...</li>
                    <li id="o4" class="hidden w-fit text-xs text-green-600 bg-green-100 border border-green-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-check text-green-500 mr-2"></i>Session created</li>
                    <li id="o5" class="hidden w-fit text-xs bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-spinner-third fa-spin mr-2"></i>Injecting session...</li>
                    <li id="o6" class="hidden w-fit text-xs text-green-600 bg-green-100 border border-green-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-check text-green-500 mr-2"></i>Injection complete</li>
                    <li id="o7" class="hidden w-fit text-xs bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-spinner-third fa-spin mr-2"></i>Directing...</li>
                <?php } else { ?>
                    <li id="o1" class="hidden w-fit text-xs bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-spinner-third fa-spin mr-2"></i>Checking key...</li>
                    <li id="o2" class="hidden w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark text-red-500 mr-2"></i>Key not found</li>
                    <li id="o3" class="hidden w-fit text-xs bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 mb-1 keyf-status">Login first to gain your key</li>
                <?php } ?>
            </ul>
        </div>

        <div class="mt-20 mb-10 cursor-default">
            <h1 class="text-2xl font-semibold">Profiles</h1>

            <?php if(isset($_SESSION['keyOwn'])){ ?>
                <p class="text-sm flex justify-center items-center"><i class="hgi hgi-stroke hgi-lock-key mr-1"></i>Key has available, <span onclick="location.href='../auth/logout'" class="font-semibold cursor-pointer hover:underline ml-1">logout</span></p>
            <?php } else { ?>
                <p class="text-sm flex justify-center items-center"><i class="hgi hgi-stroke hgi-square-lock-remove-01 mr-1"></i>Key not found, get your key<span onclick="location.href='../auth/gate'" class="font-semibold cursor-pointer hover:underline ml-1">here</span></p>
            <?php } ?>

            <div class="profiles w-150 h-[70vh] mt-5 bg-gray-100 border border-gray-300 p-7 rounded-xl overflow-y-scroll">
                <?php $order = 0; foreach($result as $data): $order++; ?>
                <div class="profile flex items-center justify-between w-full bg-gray-100 border border-gray-300 rounded-lg px-5 py-2 mb-3 shadow-sm">
                    <div class="inner-profile flex items-center">
                        <i class="fa-solid fa-user text-base"></i>
                        <div class="profile-information inline text-left ml-4">
                            <p class="font-semibold"><?= $data['userDisplay'] ?><span class="font-normal text-xs ml-1"><?= $data['nameDisplay'] ?></span></p>
                            <div class="profile-status flex items-center aling-start gap-1">
                                <p class="flex items-center w-fit text-[10px] bg-violet-100 border border-violet-300 rounded-lg px-2">
                                    <i class="mr-1 fa-solid fa-server text-[7px] text-violet-500"></i>
                                    10.100.10.2
                                </p>
    
                                <p class="flex items-center w-fit text-[10px] bg-zinc-100 border border-zinc-300 rounded-lg px-2">
                                    <i class="mr-1 fa-regular fa-cards-blank text-[7px] text-zinc-500"></i>
                                    <?= ucfirst($data['levelKey']) ?>
                                </p>
    
                                <?php if($data['detect'] == 'false' && $data['bypass'] == 'true'){ // check log detetcted ?>
                                    <p class="flex items-center w-fit text-[10px] bg-green-100 border border-green-300 rounded-lg px-2">
                                        <i class="mr-1 fa-regular fa-user-secret text-[7px] text-green-500"></i>
                                        Undetected
                                    </p>
                                <?php } elseif($data['detect'] == 'true' && $data['bypass'] == 'true') { ?>
                                    <p class="flex items-center w-fit text-[10px] bg-orange-100 border border-orange-300 rounded-lg px-2">
                                        <i class="mr-1 fa-solid fa-triangle-exclamation text-[7px] text-orange-500"></i>
                                        Not secure
                                    </p>
                                <?php } else { ?>
                                    <!-- blank -->
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
                        <button onclick="directing('local', <?= $order ?>)" class="direct bg-gray-200 border border-gray-300 rounded-lg px-1.5 py-1 cursor-pointer">
                            <i class="fa-regular fa-key text-sm"></i>
                            <p class="text-[7px]">Get session</p>
                        </button>
                    <?php } else { ?>
                        <div class="direct opacity-50 bg-gray-200 border border-gray-300 rounded-lg px-1.5 py-1 cursor-not-allowed">
                            <i class="fa-regular fa-lock text-sm"></i>
                            <p class="text-[7px]">Get session</p>
                        </div>
                    <?php } ?>
    
                    <?php if(isset($_SESSION['keyOwn'])): ?>
                    <form action="../database/directLocal" method="post" id="profileLocal<?= $order ?>" class="hidden">
                        <input type="hidden" name="idKey" value="<?= $data['idKey'] ?>">
                        <input type="hidden" name="keyOwn" value="<?= $_SESSION['keyOwn'] ?>">
                    </form>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <!-- -->
                <?php $order = 0; foreach($result as $data): $order++; ?>
                <div class="profile flex items-center justify-between w-full bg-gray-100 border border-gray-300 rounded-lg px-5 py-2 mb-3 shadow-sm">
                    <div class="inner-profile flex items-center">
                        <i class="fa-solid fa-user text-base"></i>
                        <div class="profile-information inline text-left ml-4">
                            <p class="font-semibold"><?= $data['userDisplay'] ?><span class="font-normal text-xs ml-1"><?= $data['nameDisplay'] ?></span></p>
                            <div class="profile-status flex items-center aling-start gap-1">
                                <p class="flex items-center w-fit text-[10px] bg-sky-100 border border-sky-300 rounded-lg px-2">
                                    <i class="mr-1 fa-solid fa-earth-americas text-[7px] text-sky-500"></i>
                                    103.153.190.121
                                </p>
    
                                <p class="flex items-center w-fit text-[10px] bg-zinc-100 border border-zinc-300 rounded-lg px-2">
                                    <i class="mr-1 fa-regular fa-cards-blank text-[7px] text-zinc-500"></i>
                                    <?= ucfirst($data['levelKey']) ?>
                                </p>
    
                                <?php if($data['detect'] == 'false' && $data['bypass'] == 'true'){ // check log detetcted ?>
                                    <p class="flex items-center w-fit text-[10px] bg-green-100 border border-green-300 rounded-lg px-2">
                                        <i class="mr-1 fa-regular fa-user-secret text-[7px] text-green-500"></i>
                                        Undetected
                                    </p>
                                <?php } elseif($data['detect'] == 'true' && $data['bypass'] == 'true') { ?>
                                    <p class="flex items-center w-fit text-[10px] bg-orange-100 border border-orange-300 rounded-lg px-2">
                                        <i class="mr-1 fa-solid fa-triangle-exclamation text-[7px] text-orange-500"></i>
                                        Not secure
                                    </p>
                                <?php } else { ?>
                                    <!-- blank -->
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
                        <button onclick="directing('server', <?= $order ?>)" class="direct bg-gray-200 border border-gray-300 rounded-lg px-1.5 py-1 cursor-pointer">
                            <i class="fa-regular fa-key text-sm"></i>
                            <p class="text-[7px]">Get session</p>
                        </button>
                    <?php } else { ?>
                        <div class="direct opacity-50 bg-gray-200 border border-gray-300 rounded-lg px-1.5 py-1 cursor-not-allowed">
                            <i class="fa-regular fa-lock text-sm"></i>
                            <p class="text-[7px]">Get session</p>
                        </div>
                    <?php } ?>
    
                    <?php if(isset($_SESSION['keyOwn'])): ?>
                    <form action="../database/directServer" method="post" id="profileServer<?= $order ?>" class="hidden">
                        <input type="hidden" name="idKey" value="<?= $data['idKey'] ?>">
                        <input type="hidden" name="keyOwn" value="<?= $_SESSION['keyOwn'] ?>">
                    </form>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                
                <p class="text-xs mt-5">Querying <span class="font-semibold"><?= mysqli_num_rows($result) * 2 ?> profiles</span> in total~</p>
    
            </div>
        </div>
    </center>
</body>
<script>
    function stopAct(){
        document.getElementById('cancel').innerHTML = "<i class='fa-solid fa-spinner-third fa-spin'></i>"
        document.getElementById('cancel').setAttribute('disabled', '')
        document.getElementById('cancel').classList.replace('bg-gray-100', 'bg-gray-300')
        document.getElementById('cancel').classList.replace('cursor-pointer', 'cursor-default')
        
        setTimeout(() => {
            document.getElementById('cancel').innerHTML = "<i class='fa-solid fa-circle-xmark mr-1.5 text-[10px]'></i> Error canceling"
            document.getElementById('cancel').classList.replace('bg-gray-300', 'bg-red-100')
            document.getElementById('cancel').classList.add('text-red-600')
            document.getElementById('cancel').classList.replace('cursor-default', 'cursor-not-allowed')
        }, 1000);
        location.reload()
    }

    function directing(server, order){
        document.getElementById('o1').classList.add('hidden');
        document.getElementById('o2').classList.add('hidden');
        document.getElementById('o3').classList.add('hidden');
        <?php if(isset($_SESSION['keyOwn'])): ?>
        document.getElementById('o4').classList.add('hidden');
        document.getElementById('o5').classList.add('hidden');
        document.getElementById('o6').classList.add('hidden');
        document.getElementById('o7').classList.add('hidden');
        <?php endif; ?>

        document.getElementById('overlay').classList.remove('hidden');
        document.getElementById('loading').classList.remove('hidden');

        setTimeout(function(){// checking key
            document.getElementById('o1').classList.remove('hidden');
        }, 500);

        setTimeout(function(){ // status key
            document.getElementById('o1').classList.add('hidden');
            document.getElementById('o2').classList.remove('hidden');
        }, 1000);

        setTimeout(function(){ // creating session
            document.getElementById('o2').classList.add('hidden');
            document.getElementById('o3').classList.remove('hidden');
        }, 2000);

        setTimeout(function(){ // status session
            document.getElementById('o3').classList.add('hidden');
            document.getElementById('o4').classList.remove('hidden');
        }, 3000);

        setTimeout(function(){ // injecting
            document.getElementById('o4').classList.add('hidden');
            document.getElementById('o5').classList.remove('hidden');
        }, 4000);

        setTimeout(function(){ // status injecting
            document.getElementById('o5').classList.add('hidden');
            document.getElementById('o6').classList.remove('hidden');
        }, 11000);

        setTimeout(function(){ // directing
            document.getElementById('o6').classList.add('hidden');
            document.getElementById('o7').classList.remove('hidden');
        }, 12000);
        
        <?php if(isset($_SESSION['keyOwn'])): ?>
            setTimeout(function(){ // submiting
                if(server == 'local'){
                    let profile = 'profileLocal' + order
                    document.getElementById(profile).submit();
                } else {
                    let profile = 'profileServer' + order
                    document.getElementById(profile).submit();
                }
            }, 14000);
        <?php endif; ?>
        
        <?php if(isset($_SESSION['keyOwn'])){ ?>
        setTimeout(function(){
            document.getElementById('overlay').classList.add('hidden');
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('o7').classList.add('hidden');
        }, 16000);
        <?php } else { ?>
        setTimeout(function(){
            document.getElementById('overlay').classList.add('hidden');
            document.getElementById('loading').classList.add('hidden');
            // document.getElementById('o7').classList.add('hidden');
        }, 6000);
        <?php } ?>
    }

    setTimeout(function(){
        document.getElementById('error').classList.add('hidden');
    }, 2000);
</script>
</html>