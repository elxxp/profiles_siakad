<?php
require 'config.php';

if(isset($_POST['idKey'])) {
    $idKey = $_POST['idKey'];

    $sql = "SELECT * FROM profiles WHERE idKey = $idKey";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();

    $passKey = base64_decode($data['passKey']);

    ?>

    <form id="form" action="http://10.100.10.2/siakad/ceklogin.php" method="post">
        <input type="hidden" name="userid" value="<?= $data['userKey'] ?>">
        <input type="hidden" name="password" value="<?= $passKey ?>">
        <input type="hidden" name="level" value="<?php $data['levelKey'] ?>">
    </form>

    <script>
        window.onload = function() {
            document.getElementById("form").submit();
        };
    </script>

<?php
} else {
    echo "idKey not found";
}