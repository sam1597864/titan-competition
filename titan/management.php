<!DOCTYPE HTML>

<html>

    <head>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

        <!-- jquery測試-->		
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <?php
        session_start();
        ?>
        <script>
            var user_id = <?php
        if (@$_SESSION["User_ID"] != null) {
            echo $_SESSION["User_ID"];
        } else {
            echo "\"\";";
            echo "alert('請先登入!'); location.href='/17gogo/index.php';";
        }
        ?>;

            function InsertDiary() {
                if (error == "" && error2 == "" && error3 == "") {
                    var date = document.getElementById("date");
                    var diary_name = document.getElementById("diary_name");
                    var diary_time = document.getElementById("time");
                    var time = date.value + " " + diary_time.value;
                    $.ajax({
                        type: "POST",
                        url: "http://localhost/17gogo/Function_Diary.php",
                        data: {"func": "Insert_Diary", "Time": time, "Meal_Name": diary_name.value, "User_ID": user_id},
                        error: function (result) {
                            alert('Service call failed: ' + result.status + '' + result.statusText);
                        }, success: function (result) {
                            if (result.includes("Error"))
                            {
                                alert("新增錯誤!");
                            } else {
                                alert("新增成功!");
                                Select_Diary();
                            }
                        }
                    });
                } else {
                    alert("表單尚未填寫完整!");
                }
            }
            var error = "";
            function check_data() {
                var date = document.getElementById("date");
                var diary_name = document.getElementById("diary_name");
                if (date.value == "") {
                    error = "<font color=\"red\">日期不可為空白!!!</font> <br />";
                } else {
                    error = "";
                }
                document.getElementById("errorcall").innerHTML = error;
            }
            var error2 = "";
            function check_name() {
                var diary_name = document.getElementById("diary_name");
                if (diary_name.value == "") {
                    error2 = "<font color=\"red\">名稱不可為空白!!!</font> <br />";
                } else {
                    error2 = "";
                }
                document.getElementById("errorcall2").innerHTML = error2;
            }
            var error3 = "";
            function check_time() {
                var diary_time = document.getElementById("time");
                if (diary_time.value == "") {
                    error3 = "<font color=\"red\">時間不可為空白!!!</font> <br />";
                } else {
                    error3 = "";
                }
                document.getElementById("errorcall3").innerHTML = error3;
            }



        </script>
    </head>

    <body>


        <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="assets/css/management.css" />
        <div class="pagediv">
            <div class="wrapper"  align="center" style="margin: 0px auto;" >
                <h1>MANAGE YOUR DIARY</h1>
                <p>管理您的日誌吧!</p>
                <fieldset>
                    <legend color="white">新增日誌</legend>
                    <table>
                        <tbody width="100%">


                            <tr>
                                <td class="td1">
                                    <font color="#6E6E6E" face="monospace" align="right" size="4">日期：</font>
                                </td>
                                <td class="td2">
                                    <input type="date" id="date" onfocusout="check_data();">
                                </td>  

                            </tr>          
                            <tr>
                                <td class="td1">
                                    <font color="#6E6E6E" face="monospace" align="right" size="4">時間：</font>
                                </td>
                                <td class="td2">
                                    <input type="time" id="time" onfocusout="check_time();">
                                </td>  

                            </tr>   
                            <tr>
                                <td class="td1">
                                    <font color="#6E6E6E" face="monospace" align="right" size="4">名稱：</font>
                                </td>
                                <td class="td2">
                                    <input type="text" id="diary_name" onfocusout="check_name();">
                                </td>  
                            </tr>



                            <tr>
                                <td class="td1">

                                </td>
                                <td class="td3">
                                    <input type="button" class="submit style2 fit" value="新增" onclick="InsertDiary();" >
                                </td>  
                            </tr>        

                        </tbody>
                    </table>      
                    <div id="errorcall"></div>
                    <div id="errorcall3"></div>
                    <div id="errorcall2"></div>
                </fieldset>

                <br>


                <fieldset>
                    <legend color="white">管理日誌</legend>
                    <table id="day1">
                        <tbody width="100%">


                            <tr>
                                <td class="td5">
                                    <select id="day" placeholder="day_show" onchange="Select_Diary();">
                                        <option value="15" selected="selected">顯示15日內</option>
                                        <option value="30">顯示30日內</option>
                                        <option value="60">顯示60日內</option>
                                    </select>
                                </td>            
                            </tr>           
                        </tbody>
                    </table>           

                </fieldset>  
            </div>
            <p class="optimize">
                17GoGo!!
            </p>
        </div>
    </body>
    <script>
        var json;
        function Select_Diary() {

            var day = document.getElementById("day").value;

            $.ajax({
                type: "POST",
                url: "http://localhost/17gogo/Function_Diary.php",
                data: {"func": "Select_Diary", "Day": day, "User_ID": user_id},
                error: function (result) {
                    alert('Service call failed: ' + result.status + '' + result.statusText);
                }, success: function (result) {
                    var num = document.getElementById("day1").rows.length;
                    for (var i = 1; i < num; i++) {
                        document.getElementById("day1").deleteRow(-1);
                    }
                    if (!result.includes("Error"))
                    {
                        json = JSON.parse(result);
                        for (var i = 0; i < json.length; i++) {
                            num = document.getElementById("day1").rows.length;
                            //建立新的tr 因為是從0開始算 所以目前的row數剛好為目前要增加的第幾個tr
                            var Tr = document.getElementById("day1").insertRow(num);
                            Tr.innerHTML = "<td class=\"td1\"><font color=\"#6E6E6E\" face=\"monospace\" align=\"left\" size=\"4\">" + json[i].Time + "</font></td>";
                            Tr = document.getElementById("day1").insertRow(num + 1);
                            var htmltext = " <td class=\"td2\"><font color=\"#6E6E6E\" face=\"monospace\" align=\"right\" size=\"4\">日誌名稱：" + json[i].Meal_Name + "</font></td>";
                     //       htmltext + = " <td class=\"td2\"><font color=\"#6E6E6E\" face=\"monospace\" align=\"right\" size=\"4\">日誌名稱：" + json[i].Meal_Name + "</font></td>";
                            htmltext += " <td class=\"td4\" > <input type=\"button\"  class=\"submit style3 fit\" value=\"管理\" onclick=\"SetMealSession(" + i + ");\" ></td>"
                            Tr.innerHTML = htmltext;
                        }
                    } else {
                        alert("系統錯誤!");
                    }
                }
            });

        }
        Select_Diary();

        function SetMealSession(index) {

            //     document.location.href = "/17gogo/detail.php";
            $.ajax({
                type: "POST",
                url: "http://localhost/17gogo/Function_Diary.php",
                data: {"func": "Set_Diary_Session", "Meal_Name": json[index].Meal_Name, "Time": json[index].Time, "Diary_ID": json[index].Diary_ID},
                error: function (result) {
                    alert('Service call failed: ' + result.status + '' + result.statusText);
                }, success: function (result) {
                    location.href = "http://localhost/17gogo/detail.php";
                }});

        }
    </script>
</html>