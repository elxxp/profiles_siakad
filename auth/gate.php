<?php
session_start();
if(isset($_SESSION['keyOwn'])) {
  header('location: ../views/main');
  exit;
}

$transButton = "cursor-pointer";

if(isset($_POST['in'])) {

  if(@$_POST['tokenGate'] == @$_SESSION['token']) {
    unset($_SESSION['token']);

    $username = htmlspecialchars($_POST['username']); 
    $password = $_POST['password'];

    require '../database/config.php';
    $sqlUsername = mysqli_query($conn, "SELECT accountUsername FROM account WHERE accountUsername = '$username'");
    $resultUsername = mysqli_num_rows($sqlUsername);
    
    if($resultUsername > 0) {

      $sqlAccount = mysqli_query($conn, "SELECT * FROM account WHERE accountUsername = '$username' AND accountPassword = '$password'");
      $resultAccount = mysqli_num_rows($sqlAccount);

      if($resultAccount > 0 ) {
        $disable = "disabled";
        $transButton = "opacity-50 cursor-default";
        $status = '<div id="temporaryStatus" class="fixed z-100 inset-x-0 mx-auto top-5 flex items-center justify-center w-fit text-xs text-green-600 bg-green-100 border border-green-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-check mr-2"></i>Login successfully, redirecting...</div>';

        $_SESSION['keyOwn'] = bin2hex(random_bytes(12));

        header("Refresh:2.5; url=../views/main");
      } else {
        $status = '<div id="temporaryStatus" class="fixed z-100 inset-x-0 mx-auto top-5 flex items-center justify-center w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Incorrect password or username</div>';
      }

    } else {
      $status = '<div id="temporaryStatus" class="fixed z-100 inset-x-0 mx-auto top-5 flex items-center justify-center w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Username not found</div>';
    }

  } else {
    header('Refresh:1; url=../auth/gate');
    $status = '<div id="temporaryStatus" class="fixed z-100 inset-x-0 mx-auto top-5 flex items-center justify-center w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Invalid token, reloading...</div>';
  }
}

$token = bin2hex(random_bytes(32));
$_SESSION['token'] = $token;

?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../src/output.css" rel="stylesheet">
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
  <link rel="stylesheet" href="https://cdn.hugeicons.com/font/hgi-stroke-rounded.css"/>
  <link rel="stylesheet" href="../lib/css/font.css">
  <link rel="stylesheet" href="../lib/css/keyframes.css">
  <title>Gate</title>
</head>
<body>
  <div id="temporary">
    <?= @$status ?>
  </div>

  <div class="container-form flex items-center justify-center h-screen">
    <div class="inner-container-form w-80 h-fit text-center bg-a-700">
      <div class="py-5">
        <i class="fa-solid fa-scribble text-[40px] pb-3"></i>
        <h1 class="text-xl font-bold">Login account</h1>
        <p class="text-sm">Insert information below</p>
        <!-- <p class="text-[8px]"><?= @$_SESSION['token']?></p> -->
      </div>
      <div class="content-from">
        <form method="post">
          <div class="flex items-center w-full text-xs py-4 px-5 border border-gray-500 rounded-md mb-1">
            <i class="fa-regular fa-user-tie mr-3"></i>
            <input id="controlUsername" class="w-full outline-none border-none" type="text" name="username" placeholder="Username" value="<?= @$_POST['username'] ?>" autocomplete="off" <?= @$disable ?>>
          </div>

          <div class="flex items-center w-full text-xs py-4 px-5 border border-gray-500 rounded-md mb-3">
            <i class="fa-regular fa-key mr-3"></i>
            <input id="controlPassword" class="w-full outline-none border-none" type="password" name="password" placeholder="Password" autocomplete="off" <?= @$disable ?>>
            <div onclick="showPassword()" id="passVisibility" class= "flex items-center ml-2 cursor-pointer">
              <i class="hgi hgi-stroke hgi-view-off"></i>
            </div>
          </div>
          <input type="hidden" name="tokenGate" value="<?= $_SESSION['token']?>">
          <input type="hidden" name="in" value="true">
        </form>

        <button id="submit" onclick="get()" class="flex justify-center items-center w-full text-xs py-3.5 bg-black text-white rounded-md <?= @$transButton ?>" <?= @$disable ?>>Get key</button>
        <button type="button" onclick="location.href='../views/main'" class="w-fit h-fit font-bold text-xs my-3.5 text-black rounded-md <?= @$transButton ?>" <?= @$disable ?>>back</button>

      </div>
    </div>
  </div>
</body>
<script>
  function showPassword() {
    let input = document.getElementById("controlPassword");
    let eye = document.getElementById("passVisibility");

    if (input.type === "password") {
      input.type = "text";
      eye.innerHTML = '<i class="hgi hgi-stroke hgi-view"></i>';
    } else {
      input.type = "password";
      eye.innerHTML = '<i class="hgi hgi-stroke hgi-view-off"></i>';
    }
  }

  function get(){
    let username = document.querySelector('input[name="username"]').value;
    let password = document.querySelector('input[name="password"]').value;

    if(username !== "" || password !== "") {
      if(username !== "") {
        if(password !== "") {
          document.getElementById('controlUsername').setAttribute('disabled', '');
          document.getElementById('controlPassword').setAttribute('disabled', '');
          document.getElementById('submit').innerHTML = '<i class="fa-solid fa-spinner-third fa-spin text-sm mr-2"></i>Get key';
          document.getElementById('submit').setAttribute('disabled', '');
          document.getElementById('submit').classList.add('opacity-50', 'cursor-default');
          setTimeout(() => {
            document.getElementById('controlUsername').removeAttribute('disabled');
            document.getElementById('controlPassword').removeAttribute('disabled');
            document.querySelector('form').submit();
            console.log('submitted')
          }, 1500);
        } else {
          document.getElementById('temporary').innerHTML = '<div id="temporaryStatus" class="fixed z-100 inset-x-0 mx-auto top-5 flex items-center justify-center w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Insert password first</div>'
          console.log('password empty')
          vanish()
        }
      } else {
        document.getElementById('temporary').innerHTML = '<div id="temporaryStatus" class="fixed z-100 inset-x-0 mx-auto top-5 flex items-center justify-center w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Insert username first</div>'
        console.log('username empty')
        vanish()
      }
    } else {
      document.getElementById('temporary').innerHTML = '<div id="temporaryStatus" class="fixed z-100 inset-x-0 mx-auto top-5 flex items-center justify-center w-fit text-xs text-red-600 bg-red-100 border border-red-300 rounded-lg px-4 py-2 mb-1 keyf-status"><i class="fa-solid fa-circle-xmark mr-2"></i>Information cannot be em    pty</div>'
      console.log('empty')
      vanish()
    }
  }

  function vanish(){
    setTimeout(() => {
      document.getElementById('temporaryStatus').classList.add('vanish')
    }, 2000);
  }
</script>
</html>