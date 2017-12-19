<?php
session_start();
$func_name = $_POST["func"];
$func_name();
//新增日誌
Function Insert_Diary() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $Time = str_replace($arr, "", $_POST["Time"]);
    $Meal_Name = str_replace($arr, "", $_POST["Meal_Name"]);
    $User_ID = str_replace($arr, "", $_POST["User_ID"]);
    $sql = "INSERT INTO diary (User_ID,Meal_Name,Time) Values('$User_ID','$Meal_Name','$Time')";
    $result = doSQL($sql);
    if ($result) {
        //成功
        echo "Error";
    } else {
        //失敗
        echo "OK";
    }
}

//找尋日誌
Function Select_Diary() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $User_ID = str_replace($arr, "", $_POST["User_ID"]);
    $Day = str_replace($arr, "", $_POST["Day"]);
    $sql = " SELECT * FROM diary WHERE DATEDIFF(NOW(),Time) <= $Day AND User_ID='$User_ID' ORDER BY diary.Time DESC";
    $result = doSQL($sql);
    if ($result) {
        //成功
        echo json_encode($result);
    } else {
        //失敗
        echo "Error";
    }
}

//設定日誌session
Function Set_Diary_Session() {
    $arr = array("'", "--", "*/", "/*");
    $Meal_Name = str_replace($arr, "", $_POST["Meal_Name"]);
    $Time = str_replace($arr, "", $_POST["Time"]);
    $Diary_ID = str_replace($arr, "", $_POST["Diary_ID"]);
    $_SESSION["Meal_Name"] = $Meal_Name;
    $_SESSION["Time"] = $Time;
    $_SESSION["Diary_ID"] = $Diary_ID;
}

//新增食物
Function Insert_Food() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $Quantity = str_replace($arr, "", $_POST["Quantity"]);
    $FoodCal_ID = str_replace($arr, "", $_POST["FoodCal_ID"]);
    $Diary_ID = str_replace($arr, "", $_POST["Diary_ID"]);
    $sql = "INSERT INTO meal (Quantity,FoodCal_ID,Diary_ID) Values('$Quantity','$FoodCal_ID','$Diary_ID')";
    $result = doSQL($sql);
    if ($result) {
        //失敗
        echo "Error";
    } else {
        //成功
        echo "OK";
    }
}

//查詢食物列表
Function Select_Meal_List() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $Diary_ID = str_replace($arr, "", $_POST["Diary_ID"]);
    $sql = "SELECT foodcalclassl.ClassL_Name,foodcalclasss.ClassS_Name,foodcal.Food_Name,meal.Quantity,foodcal.Unit,foodcal.Weight,meal.Meal_ID ";
    $sql .= "FROM foodcalclassl INNER JOIN foodcalclasss ON foodcalclasss.ClassL_ID = foodcalclassl.ClassL_ID ";
    $sql .= "INNER JOIN foodcal ON foodcal.ClassS_ID = foodcalclasss.ClassS_ID INNER JOIN meal ON meal.FoodCal_ID = foodcal.FoodCal_ID WHERE meal.Diary_ID='$Diary_ID'";
    $result = doSQL($sql);
    if ($result) {
        //成功
        echo json_encode($result);
    } else {
        //失敗
        echo "Error";
    }
}

//刪除餐點
function Delete_Meal() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $Meal_ID = str_replace($arr, "", $_POST["Meal_ID"]);
    $sql = "DELETE FROM meal WHERE Meal_ID = $Meal_ID";
    $result = doSQL($sql);
    if ($result) {
        //失敗
        echo "Error";
    } else {
        //成功
        echo "OK";
    }
}

//修改餐點
function Updata_Meal() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $Meal_ID = str_replace($arr, "", $_POST["Meal_ID"]);
    $Quantity = str_replace($arr, "", $_POST["Quantity"]);
    $sql = "UPDATE meal SET Quantity='$Quantity'  WHERE Meal_ID='$Meal_ID'";
    $result = doSQL($sql);
    if ($result) {
        //失敗
        echo "Error";
    } else {
        //成功
        echo "OK";
    }
}

//查詢總卡路里
function Count_Meal_Cal() {
    include 'Public_Function.php';
    $arr = array("'", "--", "*/", "/*");
    $Diary_ID = str_replace($arr, "", $_POST["Diary_ID"]);
    $sql = "SELECT T1.Diary_ID,sum(T1.Quantity*foodcal.Cal) AS Cal FROM(SELECT * FROM meal WHERE meal.Diary_ID = '$Diary_ID') AS T1 INNER JOIN foodcal ON T1.FoodCal_ID = foodcal.FoodCal_ID GROUP BY T1.Diary_ID";
    $result = doSQL($sql);
    if ($result) {
        //成功
        echo json_encode($result);
    } else {
        //成功
        echo "NO Meal";
    }
}
?>

