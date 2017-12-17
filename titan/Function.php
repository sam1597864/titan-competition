<?php

session_start();
$func_name = $_POST["func"];
$func_name();

//運動種類
function Select_Exercise() {
    include 'Public_Function.php';
    $sql = "SELECT * FROM sportcal ";
    $result = doSQL($sql);
    if ($result) {
        //登入成功
        echo json_encode($result);
    } else {
        //登入失敗
        echo "Error";
    }
}

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

//重新定位健康站
Function Select_HealthLocation_L() {
    include 'Public_Function.php';
    $sql = "SELECT healthspot.HealthSpot_ID,healthspot.Address,area.Area_Name,healthspotclass.Spot_Class_Name,healthspot.Spot_Name,healthspot.Lat,healthspot.Lng ";
    $sql .= "FROM healthspot INNER JOIN area ON healthspot.Area_ID = area.Area_ID INNER JOIN healthspotclass ON healthspot.Spot_Class_ID = healthspotclass.Spot_Class_ID ";
    $result = doSQL($sql);
    if ($result) {
        //成功
        echo json_encode($result);
    } else {
        //失敗
        echo "Error";
    }
}

//健康站
Function Select_HealthLocation() {
    include 'Public_Function.php';
    $sql = "SELECT healthspot.HealthSpot_ID,healthspot.Address,area.Area_Name,healthspotclass.Spot_Class_Name,healthspot.Spot_Name,healthspot.Lat,healthspot.Lng ";
    $sql .= "FROM healthspot INNER JOIN area ON healthspot.Area_ID = area.Area_ID INNER JOIN healthspotclass ON healthspot.Spot_Class_ID = healthspotclass.Spot_Class_ID WHERE healthspot.Lat is not null";
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

