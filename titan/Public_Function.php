<?php

function Connect_DB() {
    $serverName = "localhost";
    $uid = "root";
    $pwd = "";
    $conn = mysqli_connect($serverName, $uid, $pwd);
    mysqli_select_db($conn, "gogo");
    if (!$conn) {
        die(print_r("Connection Error : " . mysqli_connect_error(), true));
    } else {
        return $conn;
    }
}

//執行SQL
function doSQL($sql) {
    
    $conn = Connect_DB();
    if ($conn) {
        $result = mysqli_query($conn, $sql) or die("Query Error : " . print_r(mysqli_error($con)));
        //由於$line每次只會抓一筆資料 超過一筆使用$value來承接 $value事實上可看成2為陣列
        $value = array();
        //取出所有的欄位之後，可以利用mysql_fetch_assoc函數，將取出的欄位變成一組associate array，便可容易的以表格顯示
        for ($i = 0; $line = mysqli_fetch_assoc($result); $i++) { //黃色警告是指說$line = mysql_fetch_assoc($result)是轉讓方式 用來做判斷是可能有風險
            $value[$i] = $line;
        }
        mysqli_close($conn);
        return $value;
    } else {
        // echo "Connection could not be established Error. <br>";
        // echo "資料庫不存在";
        die(print_r("Connection Error : " . sqlsrv_errors(), true));
        mysqli_close($conn);
    }
}

?>