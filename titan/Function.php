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

//重新定位運動場所
Function Select_Location_L() {
    include 'Public_Function.php';
    $sql = "SELECT sportplace.SportP_ID, sportplace.Lat,sportplace.Lng,sportplace.SportP_Name,sportplace.Address,sportplaceclass.SportP_Class_Name,sportplaceclass.SportP_Class_Type,area.Area_Name ";
    $sql .= "FROM sportplace INNER JOIN sportplaceclass ON sportplace.SportP_Class_ID = sportplaceclass.SportP_Class_ID INNER JOIN area ON sportplace.Area_ID = area.Area_ID ";
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

Function Select_Location() {
    include 'Public_Function.php';
    $sql = "SELECT sportplace.SportP_ID, sportplace.Lat,sportplace.Lng,sportplace.SportP_Name,sportplace.Address,sportplaceclass.SportP_Class_Name,sportplaceclass.SportP_Class_Type,area.Area_Name ";
    $sql .= "FROM sportplace INNER JOIN sportplaceclass ON sportplace.SportP_Class_ID = sportplaceclass.SportP_Class_ID INNER JOIN area ON sportplace.Area_ID = area.Area_ID WHERE sportplace.Lat is not null";
    $result = doSQL($sql);
    if ($result) {
        //成功
        echo json_encode($result);
    } else {
        //失敗
        echo "Error";
    }
}

//運動場所
Function Update_Location() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $Lat = str_replace($arr, "", $_POST["Lat"]);
    $Lng = str_replace($arr, "", $_POST["Lng"]);
    $google_Address = str_replace($arr, "", $_POST["google_Address"]);
    $SportP_ID = str_replace($arr, "", $_POST["SportP_ID"]);
    $sql = "UPDATE sportplace SET Lat='$Lat' ,Lng='$Lng',google_Address='$google_Address' WHERE SportP_ID='$SportP_ID'";
    $result = doSQL($sql);
    if ($result) {
        //成功
        echo "Error";
    } else {
        //失敗
        echo "OK";
    }
}

//運動場所
Function Update_HealthLocation() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $Lat = str_replace($arr, "", $_POST["Lat"]);
    $Lng = str_replace($arr, "", $_POST["Lng"]);
    $google_Address = str_replace($arr, "", $_POST["google_Address"]);
    $HealthSpot_ID = str_replace($arr, "", $_POST["HealthSpot_ID"]);
    $sql = "UPDATE HealthSpot SET Lat='$Lat' ,Lng='$Lng',google_Address='$google_Address' WHERE HealthSpot_ID='$HealthSpot_ID'";
    $result = doSQL($sql);
    if ($result) {
        //失敗
        echo "Error";
    } else {
        //成功
        echo "OK";
    }
}


?>

