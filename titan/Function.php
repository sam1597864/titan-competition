<?php

session_start();
$func_name = $_POST["func"];
$func_name();



//食物大類
Function Select_FoodcalclassL() {
    include 'Public_Function.php';
    $sql = "SELECT * FROM foodcalclassl ";
    $result = doSQL($sql);
    if ($result) {
        //成功
        echo json_encode($result);
    } else {
        //失敗
        echo "Error";
    }
}

//食物小類
Function Select_FoodcalclassS() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $ClassL_ID = str_replace($arr, "", $_POST["ClassL_ID"]);
    $sql = "SELECT * FROM foodcalclasss WHERE ClassL_ID='$ClassL_ID'";
    $result = doSQL($sql);
    if ($result) {
        //成功
        echo json_encode($result);
    } else {
        //失敗
        echo "Error";
    }
}

//食物
Function Select_Food() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $ClassS_ID = str_replace($arr, "", $_POST["ClassS_ID"]);
    $sql = "SELECT * FROM foodcal WHERE ClassS_ID='$ClassS_ID'";
    $result = doSQL($sql);
    if ($result) {
        //成功
        echo json_encode($result);
    } else {
        //失敗
        echo "Error";
    }
}




?>

