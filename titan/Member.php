<?php
session_start();
$func_name = $_POST["func"];
$func_name();

function Logout(){
    session_destroy();
}
function LoginUser() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $user_email = str_replace($arr, "", $_POST["user_email"]);
    $user_password = str_replace($arr, "", $_POST["user_password"]);
    $sql = "SELECT * FROM member WHERE Email='$user_email' AND Pwd='$user_password'";
    $result = doSQL($sql);
    if ($result) {
          $_SESSION["User_ID"] = $result[0]["User_ID"];
          $_SESSION["User_Name"] = $result[0]["User_Name"];
        //登入成功
        echo json_encode($result);
    } else {
        //登入失敗
        echo "NO Member";
    }
}

function CheckUser() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $user_email = str_replace($arr, "", $_POST["user_email"]);
    $sql = "SELECT * FROM member WHERE Email='$user_email'";
    $result = doSQL($sql);
    if ($result) {
        //登入成功
        echo "User have been Insert ";
    } else {
        //登入失敗
        echo "Insert OK";
    }
}

function InsertUser() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $user_email = str_replace($arr, "", $_POST["user_email"]);
    $user_password = str_replace($arr, "", $_POST["user_password"]);
    $user_name = str_replace($arr, "", $_POST["user_name"]);
    $user_height = str_replace($arr, "", $_POST["user_height"]);
    $user_weight = str_replace($arr, "", $_POST["user_weight"]);
    $user_birth = str_replace($arr, "", $_POST["user_birth"]);
    $user_sex = str_replace($arr, "", $_POST["user_sex"]);
    $sql = "INSERT INTO member (User_Name,Sex,Height,Weight,Birth,Email,Pwd) VALUES('$user_name','$user_sex','$user_height','$user_weight','$user_birth','$user_email','$user_password') ";
    $result = doSQL($sql);
    if ($result) {

        echo "Insert Error";
    } else {

        echo "Insert OK";
    }
}

function FindUser() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $user_id = str_replace($arr, "", $_POST["user_id"]);
    $sql = "SELECT * FROM member WHERE User_ID ='$user_id'";
    $result = doSQL($sql);
    if ($result) {

         echo json_encode($result);
    } else {

        echo "error";
    }
}

function UpdateUser() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $user_id = str_replace($arr, "", $_POST["user_id"]);
    $user_email = str_replace($arr, "", $_POST["user_email"]);
    $user_password = str_replace($arr, "", $_POST["user_password"]);
    $user_name = str_replace($arr, "", $_POST["user_name"]);
    $user_height = str_replace($arr, "", $_POST["user_height"]);
    $user_weight = str_replace($arr, "", $_POST["user_weight"]);
    $user_birth = str_replace($arr, "", $_POST["user_birth"]);
    $user_sex = str_replace($arr, "", $_POST["user_sex"]);
    $sql = "UPDATE member SET User_Name='$user_name',Sex='$user_sex',Height='$user_height',Weight='$user_weight',Birth='$user_birth',Email='$user_email',Pwd='$user_password' WHERE User_ID ='$user_id' ";
    $result = doSQL($sql);
    if ($result) {

        echo "Insert Error";
    } else {

        echo "Insert OK";
    }
}
?>