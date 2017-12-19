<?php

session_start();
$func_name = $_POST["func"];
$func_name();

function LoginUser() {
    include 'GOGODB.php';
    $arr = array("'", "--", "*/", "/*");
    $user_email = str_replace($arr, "", $_POST["user_email"]);
    $user_password = str_replace($arr, "", $_POST["user_password"]);
    $sql = "SELECT * FROM member WHERE Email='$user_email' AND Pwd='$user_password'";
    $result = doSelectSQL($sql);
    if ($result) {
        //登入成功
        $_SESSION["User_ID"] = $result[0]["User_ID"];
        echo json_encode($result);
    } else {
        //登入失敗
        echo "NO Member";
    }
}

?>