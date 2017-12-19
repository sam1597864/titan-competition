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
        <style>
            .no-close .ui-dialog-titlebar-close {
                display: none;
            }

        </style>
    </head>
    <script>
        var Diary_ID = <?php
        if (@$_SESSION["Diary_ID"] != null) {
            echo $_SESSION["Diary_ID"];
        }   else {
            echo "\"\";";
            echo "alert('請先登入!'); location.href='/17gogo/index.php';";
        }
        ?>;
        var Time = <?php
        if (@$_SESSION["Time"] != null) {
            echo "\"" . $_SESSION["Time"] . "\"";
        } else {
            echo "\"\"";
        }
        ?>;
        var Meal_Name = <?php
        if (@$_SESSION["Meal_Name"] != null) {
            echo "\"" . $_SESSION["Meal_Name"] . "\"";
        } else {
            echo "\"\"";
        }
        ?>;

        function init() {
            document.getElementById("time").innerHTML = "<font color=\"#6E6E6E\" face=\"monospace\" align=\"center\" size=\"4\">" + Time + "</font>";
            document.getElementById("name").innerHTML = "<font color=\"#6E6E6E\" face=\"monospace\" align=\"center\" size=\"4\"> 日誌名稱:" + Meal_Name + "</font>";
            //食物大類
            $.ajax({
                type: "POST",
                url: "http://localhost/17gogo/Function.php",
                data: {"func": "Select_FoodcalclassL"},
                error: function (result) {
                    alert('Service call failed: ' + result.status + '' + result.statusText);
                }, success: function (result) {

                    if (!result.includes("Error"))
                    {
                        var json = JSON.parse(result);
                        var htmltext = "";
                        for (var i = 0; i < json.length; i++) {
                            htmltext += "<option value=\"" + json[i].ClassL_ID + "\">" + json[i].ClassL_Name + "</option> "
                        }
                        $("#foodcalclassl").html(htmltext);
                    } else {
                        alert("系統錯誤");
                    }

                }
            });
            //食物小類
            $.ajax({
                type: "POST",
                url: "http://localhost/17gogo/Function.php",
                data: {"func": "Select_FoodcalclassS", "ClassL_ID": "1"},
                error: function (result) {
                    alert('Service call failed: ' + result.status + '' + result.statusText);
                }, success: function (result) {

                    if (!result.includes("Error"))
                    {
                        //   alert(result);
                        var json = JSON.parse(result);
                        var htmltext = "";
                        for (var i = 0; i < json.length; i++) {
                            htmltext += "<option value=\"" + json[i].ClassS_ID + "\">" + json[i].ClassS_Name + "</option> "
                        }
                        $("#foodcalclasss").html(htmltext);
                    } else {
                        alert("系統錯誤");
                    }

                }
            });
            //食物
            $.ajax({
                type: "POST",
                url: "http://localhost/17gogo/Function.php",
                data: {"func": "Select_Food", "ClassS_ID": "1"},
                error: function (result) {
                    alert('Service call failed: ' + result.status + '' + result.statusText);
                }, success: function (result) {

                    if (!result.includes("Error"))
                    {
                        //   alert(result);
                        var json = JSON.parse(result);
                        var htmltext = "";
                        for (var i = 0; i < json.length; i++) {
                            htmltext += "<option value=\"" + json[i].FoodCal_ID + "\">" + json[i].Food_Name + "  單位:" + json[i].Unit + "  重量:" + json[i].Weight + "</option> "
                        }
                        $("#food").html(htmltext);
                    } else {
                        alert("系統錯誤");
                    }

                }
            });
            SelectMealList();
            Count_Meal_Cal();
        }
        window.onload = init;
        function Select_FoodcalclassS() {
            $.ajax({
                type: "POST",
                url: "http://localhost/17gogo/Function.php",
                data: {"func": "Select_FoodcalclassS", "ClassL_ID": $("#foodcalclassl").val()},
                error: function (result) {
                    alert('Service call failed: ' + result.status + '' + result.statusText);
                }, success: function (result) {

                    if (!result.includes("Error"))
                    {
                        //   alert(result);
                        var json = JSON.parse(result);
                        var htmltext = "";
                        for (var i = 0; i < json.length; i++) {
                            htmltext += "<option value=\"" + json[i].ClassS_ID + "\">" + json[i].ClassS_Name + "</option> "
                        }
                        $("#foodcalclasss").html(htmltext);
                        Select_Foods();
                    } else {
                        alert("系統錯誤");
                    }

                }
            });

        }
        function Select_Foods() {
            $.ajax({
                type: "POST",
                url: "http://localhost/17gogo/Function.php",
                data: {"func": "Select_Food", "ClassS_ID": $("#foodcalclasss").val()},
                error: function (result) {
                    alert('Service call failed: ' + result.status + '' + result.statusText);
                }, success: function (result) {

                    if (!result.includes("Error"))
                    {
                        //   alert(result);
                        var json = JSON.parse(result);
                        var htmltext = "";
                        for (var i = 0; i < json.length; i++) {
                            htmltext += "<option value=\"" + json[i].FoodCal_ID + "\">" + json[i].Food_Name + "  單位:" + json[i].Unit + "  重量:" + json[i].Weight + "</option> "
                        }
                        $("#food").html(htmltext);
                    } else {
                        alert("系統錯誤");
                    }

                }
            });
        }
        /* function test(){
         
         document.getElementById("foodcalclasss").selectedIndex = "1"; 
         Select_Foods();
         }*/
        function InsertFood() {
            if ($("#Quantity").val() == "") {
                alert("數量不可為空值!!");
            } else if ($("#Quantity").val() <= 0) {
                alert("數量不可為小等於0!!");
            } else {
                $.ajax({
                    type: "POST",
                    url: "http://localhost/17gogo/Function_Diary.php",
                    data: {"func": "Insert_Food", "Quantity": $("#Quantity").val(), "FoodCal_ID": $("#food").val(), "Diary_ID": Diary_ID},
                    error: function (result) {
                        alert('Service call failed: ' + result.status + '' + result.statusText);
                    }, success: function (result) {

                        if (!result.includes("Error"))
                        {
                            SelectMealList();
                            Count_Meal_Cal();
                            alert("新增成功");
                        } else {
                            alert("新增失敗!");
                        }

                    }
                });
            }
        }
        function SelectMealList() {
            $.ajax({
                type: "POST",
                url: "http://localhost/17gogo/Function_Diary.php",
                data: {"func": "Select_Meal_List", "Diary_ID": Diary_ID},
                error: function (result) {
                    alert('Service call failed: ' + result.status + '' + result.statusText);
                }, success: function (result) {

                    if (!result.includes("Error"))
                    {
                        var json = JSON.parse(result);
                        var num = document.getElementById("foodlist").rows.length;
                        for (var i = 0; i < num; i++) {
                            document.getElementById("foodlist").deleteRow(-1);
                        }
                        for (var i = 0; i < json.length; i++) {
                            var num = document.getElementById("foodlist").rows.length;
                            //建立新的tr 因為是從0開始算 所以目前的row數剛好為目前要增加的第幾個tr
                            var Tr = document.getElementById("foodlist").insertRow(num);
                            var htmltext = "";
                            htmltext += "<tr><td class=\"td2\"> <font color=\"#6E6E6E\" face=\"monospace\" align=\"center\" size=\"4\">" + json[i].ClassL_Name + "</font> </td> ";
                            htmltext += "<td class=\"td2\"> <font color=\"#6E6E6E\" face=\"monospace\" align=\"center\" size=\"4\">" + json[i].ClassS_Name + "</font> </td> ";
                            htmltext += "<td class=\"td2\"> <font color=\"#6E6E6E\" face=\"monospace\" align=\"center\" size=\"4\">" + json[i].Food_Name + "  單位:" + json[i].Unit + "  重量:" + json[i].Weight + "</font> </td> ";
                            htmltext += "<td class=\"td3\"> <font color=\"#6E6E6E\" face=\"monospace\" align=\"center\" size=\"4\">X</font> </td> ";
                            htmltext += " <td class=\"td2\"><input id=\"Quantity" + i + "\" type=\"number\" value=\"" + json[i].Quantity + "\"></td>   ";
                            htmltext += "<td class=\"td2\"><input type=\"submit\" class=\"submit style3 fit\" value=\"修改\" onclick=\"Update_Meal(" + num + "," + json[i].Meal_ID + "," + json[i].Quantity + ");\"> <input  type=\"submit\" class=\"submit style3 fit\" value=\"刪除\"  onclick=\"Delete_Meal(" + (num - 1) + "," + json[i].Meal_ID + ");\"></td> </tr>";
                            Tr.innerHTML = htmltext;
                        }

                    } 

                }
            });
        }
        function Delete_Meal(index, id) {

            $("#dialog").html("確定要刪除嗎?");
            $("#dialog").dialog({
                autoOpen: false,
                height: 180,
                width: 200,
                modal: true,
                buttons: {
                    "確定": function () {
                        $.ajax({
                            type: "POST",
                            url: "http://localhost/17gogo/Function_Diary.php",
                            data: {"func": "Delete_Meal", "Meal_ID": id},
                            error: function (result) {
                                alert('Service call failed: ' + result.status + '' + result.statusText);
                            }, success: function (result) {

                                if (!result.includes("Error"))
                                {


                                    SelectMealList();
                                    Count_Meal_Cal();
                                    document.getElementById("foodlist").deleteRow(index);
                                    alert("刪除成功!");
                                    $("#dialog").dialog("close");

                                } else {
                                    alert("刪除失敗!");
                                    $("#dialog").dialog("close");

                                }

                            }
                        });
                    },
                    "取消": function () {
                        $("#dialog").dialog("close");
                    }
                }
            });
            $("#dialog").dialog("open");
            //document.getElementById("foodlist").deleteRow(index);
        }
        function Update_Meal(index, id, Q) {
            var inputname = "Quantity" + index;
            var Quantity = document.getElementById(inputname).value;
            if (Quantity == "") {
                alert("數量不可為空值!!");
            } else if (Quantity <= 0) {
                alert("數量不可為小等於0!!");
            } else {
                $("#dialog").html("確定要修改嗎?");
                $("#dialog").dialog({
                    autoOpen: false,
                    height: 180,
                    width: 200,
                    modal: false,
                    dialogClass: "no-close",
                    buttons: {
                        "確定": function () {
                            $.ajax({
                                type: "POST",
                                url: "http://localhost/17gogo/Function_Diary.php",
                                data: {"func": "Updata_Meal", "Meal_ID": id, "Quantity": Quantity},
                                error: function (result) {
                                    alert('Service call failed: ' + result.status + '' + result.statusText);
                                }, success: function (result) {

                                    if (!result.includes("Error"))
                                    {
                                        Count_Meal_Cal();
                                        alert("修改成功!");

                                        $("#dialog").dialog("close");

                                    } else {
                                        alert("修改失敗!");
                                        document.getElementById(inputname).value = Q;
                                        $("#dialog").dialog("close");

                                    }

                                }
                            });
                        },
                        "取消": function () {
                            document.getElementById(inputname).value = Q;
                            $("#dialog").dialog("close");
                        }
                    }
                });
                $("#dialog").dialog("open");
            }


        }
        function Count_Meal_Cal() {
            $.ajax({
                type: "POST",
                url: "http://localhost/17gogo/Function_Diary.php",
                data: {"func": "Count_Meal_Cal", "Diary_ID": Diary_ID},
                error: function (result) {
                    alert('Service call failed: ' + result.status + '' + result.statusText);
                }, success: function (result) {

                    if (!result.includes("NO Meal"))
                    {
                        var json = JSON.parse(result);
                        document.getElementById("cal").innerHTML = "<font color=\"#6E6E6E\" face=\"monospace\" align=\"center\" size=\"4\"> 總共攝取 :" + json[0].Cal + " 大卡</font>";

                    } else {
                        document.getElementById("cal").innerHTML = "<font color=\"#6E6E6E\" face=\"monospace\" align=\"center\" size=\"4\"> 總共攝取 :0 大卡</font>";

                    }

                }
            });
        }
    </script>
    <body>


        <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="assets/css/detail.css" />
        <div class="pagediv">
            <div class="wrapper"  align="center" style="margin: 0px auto;" >
                <h1>MANAGE YOUR DIARY</h1>
                <p>管理您的日誌吧!</p>

                <fieldset>
                    <legend color="white">新增餐點</legend>

                    <table align="center">
                        <tr>
                            <td class="td1" id="time">
                                <font color="#6E6E6E" face="monospace" align="center" size="4">YYYY/MM/DD</font>
                            </td>
                            <td class="td1" id="name">
                                <font color="#6E6E6E" face="monospace" align="center" size="4">顯示日誌名稱</font>
                            </td>  
                            <td class="td1" id="cal">
                                <font color="#6E6E6E" face="monospace" align="center" size="4">總共攝取</font>
                            </td>  
                        </tr>  
                    </table> 

                    <br>

                    <table Padding-right:"-15px" style="width: 950px;">
                           <tr>
                            <td class="td2">
                                <select id="foodcalclassl" placeholder="食物大類" align="right" onchange="Select_FoodcalclassS()">
                                    <option value="" selected="selected">各種食物</option>
                                    <option value="">各種食物</option>
                                </select>              
                            </td>
                            <td  class="td2">
                                <select id="foodcalclasss" placeholder="食物小類" align="right" onchange="Select_Foods()">
                                    <option value="" selected="selected">各種食物</option>
                                    <option value="">各種食物</option>
                                </select>              
                            </td>
                            <td class="td2">
                                <select id="food" placeholder="食物" align="right">
                                    <option value="" selected="selected">各種食物</option>
                                    <option value="">各種食物</option>
                                </select>              
                            </td>
                            <td class="td3">
                                <font color="#6E6E6E" face="monospace" align="center" size="4">X</font>
                            </td>  
                            <td class="td2">
                                <input type="number" id="Quantity">
                            </td>   
                            <td class="td2">
                                <input type="submit" class="submit style2 fit" value="新增" onclick="InsertFood();">
                            </td>                      
                        </tr>        
                    </table>          

                </fieldset>

                <br>








                <fieldset>
                    <legend color="white">餐點明細</legend>

                    <table id="foodlist" style="width: 950px;">

                    </table>                 




                </fieldset>





            </div>
            <div id="dialog" title="確認通知" style="display:none;"></div>
            <p class="optimize">
                17GoGo!!
            </p>
        </div>
    </body>

</html>