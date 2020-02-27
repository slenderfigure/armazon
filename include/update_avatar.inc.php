<?php

if (!isset($_POST['update-avatar'])) {
    header('Location: ../userpage.php');
    exit();
}

require '../classes/DBRequest.class.php';

$request = new DBRequest();
$login   = $_POST['userlogin'];
$avatar  = (object)$_FILES['avatar'];

$name      = "../data/userdefined/acct_avatar___$login";
$ext       = pathinfo($avatar->name, PATHINFO_EXTENSION);
$size      = $avatar->size;
$temp_path = $avatar->tmp_name;
$error     = $avatar->error;

foreach(glob("$name.*") as $match) {
    unlink($match);
}

$server_path = "$name.$ext";
$avatar      = explode('../', $server_path)[1];

move_uploaded_file($temp_path, $server_path);
$request->updateAvatar($login, $avatar);

header('Location: ../userpage.php?avatar+updated');