<?php
require '../database/config.php';

if(isset($_POST['query'])){
    $search = $_POST['query'];
    $sql = "SELECT * FROM profiles WHERE userDisplay LIKE '%$search%' OR nameDisplay LIKE '%$search%' OR levelKey LIKE '%$search%' ORDER BY levelKey ASC";
    $result = $conn->query($sql);
} else {
    $sql = "SELECT * FROM profiles ORDER BY levelKey ASC";
    $result = $conn->query($sql);
}

if(mysqli_num_rows($result) > 0){
?>


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

                    <?php if($data['detect'] == 'false' && $data['bypass'] == 'true'){ ?>
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

                    <?php if($data['detect'] == 'false' && $data['bypass'] == 'true'){ ?>
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


<?php
} else {
?>


    <div class="not-found mt-50">
        <i class="fa-regular fa-users-slash text-4xl mb-3"></i>
        <p class="font-600">Profile not available</p>
    </div>


<?php
}
?>