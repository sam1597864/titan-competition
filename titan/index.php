<!DOCTYPE HTML>
<!--
        Full Motion by TEMPLATED
        templated.co @templatedco
        Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
    <?php
    session_start();
    ?>

    <head>
        <title>17 GoGo</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

        <!-- jquery測試-->		
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <!-- 登入的方法 -->
        <script>
            var user_id = <?php
    if (@$_SESSION["User_ID"] != null) {
        echo $_SESSION["User_ID"];
    } else {
        echo "\"\"";
    }
    ?>;
            var User_Name = <?php
    if (@$_SESSION["User_Name"] != null) {
        echo"\"" . $_SESSION["User_Name"] . "\"";
    } else {
        echo "\"\"";
    }
    ?>;

            function Login_User() {
                var htmldata = "<table bgcolor=\"white\"> ";
                htmldata += "<tr><td bgcolor=\"white\"><font color=\"black\" face=\"monospace\">帳號</font></td>";
                htmldata += "<td bgcolor=\"white\"><input type=\"text\" name=\"account\" id=\"account\" class=\"text ui-widget-content ui-corner-all\" /></td></tr>";
                htmldata += "<tr><td><font color=\"black\" face=\"monospace\">密碼<font></td>";
                htmldata += "<td valign=\"middle\"><input type=\"password\" name=\"pwd\" id=\"password\" value=\"\" class=\"text ui-widget-content ui-corner-all\" /> </td></tr>";
                htmldata += "</table>  <div id=\"errorcall\"></div>";
                $("#dialogLogin").html(htmldata);
                $("#dialogLogin").dialog({
                    autoOpen: false,
                    height: 350,
                    width: 520,
                    modal: true,
                    buttons: {
                        "Ok": function () {
                            var acc = document.getElementById("account").value;
                            var pw = document.getElementById("password").value;
                            var errorcall = document.getElementById("errorcall");
                            // var  document.getElementById("SearchButton").style.display = "block";
                            var error = "";
                            //信箱格式判斷
                            if (!acc.includes("@")) {
                                error = "<font color=\"red\">這不是一個信箱格式!!!</font> <br/>";
                            }
                            //是否為空值
                            if (acc == "" || pw == "") {
                                error += "<font color=\"red\">帳號密碼不可為空白!!!</font>";
                            }
                            if (error == "") {
                                ///alert();
                                $.ajax({
                                    type: "POST",
                                    url: "http://localhost/17gogo/Member.php",
                                    data: {"func": "LoginUser", "user_email": acc, "user_password": pw},
                                    error: function (result) {
                                        alert('Service call failed: ' + result.status + '' + result.statusText);
                                    }, success: function (result) {
                                        if (result.includes("NO Member"))
                                        {
                                            error += "<font color=\"red\">帳號密碼錯誤!!!</font>";
                                            errorcall.innerHTML = error;
                                            errorcall.style.display = "block";
                                        } else {
                                            //  alert(result);
                                            var json = JSON.parse(result);
                                            document.getElementById("banner").style.display = "none";
                                            alert(json[0].User_Name + "，歡迎登入!");
                                            user_id = json[0].User_ID;
                                            document.getElementById("logout").innerHTML = "<font color=\"white\">歡迎! &nbsp&nbsp&nbsp" + json[0].User_Name + "&nbsp&nbsp</font> <a href=\"\\17gogo\\updateuser.php\" >修改會員資料</a>  &nbsp&nbsp&nbsp <a href=\"#\" onclick=\"loginout();\">登出</a>";
                                            document.getElementById("logout").style.display = "block";
                                            $("#dialogLogin").dialog("close");
                                        }
                                    }
                                });
                            } else {
                                errorcall.innerHTML = error;
                                errorcall.style.display = "block";
                            }
                        },
                        Cancel: function () {
                            $("#dialogLogin").dialog("close");
                        }
                    },
                    close: function () {
                        // allFields.val( "" ).removeClass( "ui-state-error" );   
                    }
                });
                $("#dialogLogin").dialog("open");
            }
            function loginout() {
                user_id = "";
                $.ajax({
                    type: "POST",
                    url: "http://localhost/17gogo/Member.php",
                    data: {"func": "Logout"},
                    error: function (result) {
                        alert('Service call failed: ' + result.status + '' + result.statusText);
                    }, success: function (result) {
                        alert("掰掰!!");
                    }
                });
                document.getElementById("banner").style.display = "block";
                document.getElementById("logout").style.display = "none";
            }
        </script>

        <!-- 註冊的方法 -->
        <script>
            function Insert_User() {
                $("#dialogRegister").html("<form>  <fieldset>  <label for=\"name\" width(20)>Name</label> <input type=\"text\" name=\"name\" id=\"name\" class=\"text ui-widget-content ui-corner-all\" /> <br><br> <label for=\"email\" width(20)>Email</label>  <input type=\"text\" name=\"email\" id=\"email\" value=\"\" class=\"text ui-widget-content ui-corner-all\" /> </fieldset>  </form> ");
                $("#dialogRegister").dialog({
                    autoOpen: false,
                    height: 400,
                    width: 450,
                    modal: true,
                    buttons: {
                        "Ok": function () {
                            //   alert("name: "+name.val()+", email: "+email.val());   
                        },
                        Cancel: function () {
                            $(this).dialog("close");
                        }
                    },
                    close: function () {
                        // allFields.val( "" ).removeClass( "ui-state-error" );   
                    }
                });
                $("#dialogRegister").dialog("open");
            }
        </script>

        <!-- 查詢運動場所的方法 -->
        <script>
            function Select_Location() {
                window.open("/17gogo/setLocation.html");
            }
        </script>

        <!-- 查詢健康站的方法 -->
        <!--<iframe src="www.dr2ooo.com/tools/maps/maps.php?zoom=13&width=500&height=266&ll=40.705563,-74.013429&" width="500" height="266"></iframe>
<script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyDE56YtAdHbQg5_cUjhSyxwaKlPcuMgQ5M"></script>

        -->
        <script>
            function Select_HealthLocation() {
                window.open("/17gogo/setHealthLocation.html");
            }
        </script>    	

        <!-- 查詢運動消耗熱量的方法 -->
        <script>
            function Select_Exercise() {
                $("#dialogExerciseHot").html("<table bgcolor=\"white\"><tr><td bgcolor=\"white\"><font color=\"black\" face=\"monospace\">體重(KG)：</font></td><td bgcolor=\"white\"><input type=\"number\" value='0' onfocusout=\"Count_Cal()\" type=\"text\" name=\"weight\" id=\"weight\" class=\"text ui-widget-content ui-corner-all\" /></td></tr><tr><td bgcolor=\"white\"><font color=\"black\" face=\"monospace\">運動類型：</font></td><td bgcolor=\"white\"><select onchange=\"Count_Cal()\" id=\"Exercise\"></select></td></tr><tr><td bgcolor=\"white\"><font color=\"black\" face=\"monospace\">消耗熱量：</font></td><td id=\"result\" bgcolor=\"white\"> </td></table> <div id=\"errorcall2\"></div>");
                $.ajax({
                    type: "POST",
                    url: "http://localhost/17gogo/Function.php",
                    data: {"func": "Select_Exercise"},
                    error: function (result) {
                        alert('Service call failed: ' + result.status + '' + result.statusText);
                    }, success: function (result) {

                        if (!result.includes("Error"))
                        {
                            var json = JSON.parse(result);
                            var htmltext = "";
                            for (var i = 0; i < json.length; i++) {
                                htmltext += "<option value=\"" + json[i].Reduce_Cal + "\">" + json[i].Sport_Item + "</option> ";
                            }
                            $("#Exercise").html(htmltext);
                        } else {
                            alert("系統錯誤");
                        }

                    }
                });
                $("#dialogExerciseHot").dialog({
                    autoOpen: false,
                    height: 330,
                    width: 470,
                    modal: true,

                });
                $("#dialogExerciseHot").dialog("open");
            }
            function Count_Cal() {
                var cal = document.getElementById("Exercise").value;
                var weight = document.getElementById("weight").value;
                var errorcall = document.getElementById("errorcall2");
                var result = document.getElementById("result");
                var error = "";
                if (weight == "") {
                    error = "<font color=\"red\">體重不可為空白!!!</font>";
                } else if (weight < 0 || weight == 0) {
                    error = "<font color=\"red\">體重必須要大於0!!!</font>";
                } else {
                    error = "";
                    var CountC = weight * cal;
                    result.innerHTML = "<font color=\"black\" face=\"monospace\">大約可消耗 " + CountC + " 大卡</font>";
                }

                errorcall.innerHTML = error;
                errorcall.style.display = "block";
            }
        </script>  

        <!-- 查詢食物熱量的方法 -->
        <script>
            function Select_Food() {
                var htmlt = "<table bgcolor=\"white\"> ";
                htmlt += "<tr><td bgcolor=\"white\"><font color=\"black\"face=\"monospace\">大類：</font> ";
                htmlt += "<td bgcolor=\"white\"><select onchange=\"Select_FoodcalclassS()\" id=\"foodcalclassl\"></select></td></tr>";
                htmlt += "<tr><td bgcolor=\"white\"><font color=\"black\"face=\"monospace\">小類：</font> ";
                htmlt += "<td bgcolor=\"white\"><select onchange=\"Select_Foods()\" id=\"foodcalclasss\"></select></td></tr>";
                htmlt += "<tr><td bgcolor=\"white\"><font color=\"black\" face=\"monospace\">食物名稱：</font></td>";
                htmlt += "<td bgcolor=\"white\"><select onchange=\"CountFoodCal()\" id=\"food\"></select =\"food\"></td></tr>";
                htmlt += "<tr><td bgcolor=\"white\"><font color=\"black\" face=\"monospace\">數量：</font></td>";
                htmlt += "<td bgcolor=\"white\"><input onfocusout=\"CountFoodCal()\" type=\"number\" placeholder=\"0\" name=\"foodnum\" id=\"foodnum\" class=\"text ui-widget-content ui-corner-all\" /></td></tr>";
                htmlt += "<tr><td bgcolor=\"white\"><font color=\"black\" face=\"monospace\">熱量：</font></td>";
                htmlt += "<td id=\"foodresult\" bgcolor=\"white\"></td></tr></table> <div id=\"errorcall3\"></div>";
                $("#dialogFoodHot").html(htmlt);
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
                                htmltext += "<option value=\"" + json[i].Cal + "\">" + json[i].Food_Name + "  單位:" + json[i].Unit + "  重量:" + json[i].Weight + "</option> "
                            }
                            $("#food").html(htmltext);
                        } else {
                            alert("系統錯誤");
                        }

                    }
                });
                $("#dialogFoodHot").dialog({
                    autoOpen: false,
                    height: 450,
                    width: 500,
                    modal: true
                });
                $("#dialogFoodHot").dialog("open");
            }
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
                                htmltext += "<option value=\"" + json[i].Cal + "\">" + json[i].Food_Name + "  單位:" + json[i].Unit + "  重量:" + json[i].Weight + "</option> "
                            }
                            $("#food").html(htmltext);
                        } else {
                            alert("系統錯誤");
                        }

                    }
                });
            }
            function CountFoodCal() {
                var cal = document.getElementById("food").value;
                var foodnum = document.getElementById("foodnum").value;
                var errorcall = document.getElementById("errorcall3");
                var foodresult = document.getElementById("foodresult");
                var error = "";
                if (foodnum == "") {
                    error = "<font color=\"red\">數量不可為空白!!!</font>";
                } else if (foodnum < 0 || foodnum == 0) {
                    error = "<font color=\"red\">數量必須要大於0!!!</font>";
                } else {
                    error = "";
                    var CountC = foodnum * cal;
                    foodresult.innerHTML = "<font color=\"black\" face=\"monospace\">大約攝取 " + CountC + " 大卡</font>";
                }

                errorcall.innerHTML = error;
                errorcall.style.display = "block";
            }

        </script>

        <!-- 查詢天氣的方法 -->
        <script>
            function Select_Weather() {

                $("#dialogWeather").html("<table bgcolor=\"white\">  <tr><td bgcolor=\"white\"><font color=\"black\" face=\"monospace\">選擇縣市：</font></td><td bgcolor=\"white\"><select onChange=\"GetAir();\" id=\"city\"><option selected value=\"taipei_city\">臺北市</option><option value=\"new_taipei_city\">新北市</option><option value=\"taichung_city\">臺中市</option><option value=\"tainan_city\">臺南市</option><option value=\"kaohsiung_city\">高雄市</option><option value=\"keelung_city\">基隆市</option><option value=\"taoyuan_country\">桃園市</option><option value=\"hsinchu_city\">新竹市</option><option value=\"hsinchu_country\">新竹縣</option><option value=\"miaoli_country\">苗栗縣</option><option value=\"changhua_country\">彰化縣</option><option value=\"nantou_country\">南投縣</option><option value=\"yunlin_country\">雲林縣</option><option value=\"chiayi_city\">嘉義市</option><option value=\"chiayi_country\">嘉義縣</option><option value=\"pingtung_country\">屏東縣</option><option value=\"yilan_country\">宜蘭縣</option><option value=\"hualien_country\">花蓮縣</option><option value=\"taitung_country\">臺東縣</option><option value=\"penghu_country\">澎湖縣</option><option value=\"kinmen_country\">金門縣</option><option value=\"lienchiang_country\">連江縣</option></select></td></tr><tr><td valign=\"middle\" colspan=\"2\"><textarea id=\"air\" cols=\"50\" rows=\"4\"></textarea></td></tr> <tr><td bgcolor=\"white\"><font color=\"black\" face=\"monospace\">查看天氣：</font></td><td bgcolor=\"white\" id=\"WeatherURL\"><font color=\"black\" face=\"monospace\">呈現URL</font></td></table>");
                $("#dialogWeather").dialog({
                    autoOpen: false,
                    height: 400,
                    width: 500,
                    modal: true,

                });
                GetAir();
                $("#dialogWeather").dialog("open");

            }
            function GetCityName()
            {
                var sel = document.getElementById("city");
                return  sel.options[sel.selectedIndex].text;
            }
            function GetAir() {
                var CityName = GetCityName();
                var sel = document.getElementById("city");
                //alert(CityName);
                var airText = "";
                $.getJSON("http://opendata2.epa.gov.tw/AQX.json", function (result) {
                    for (var i = 0; i < result.length; i++) {
                        if (result[i].County == CityName) {
                            airText += "站名: " + result[i].SiteName + " 空氣污染指標: " + result[i].PSI + " 狀態: " + result[i].Status + " \n";
                            airText += "PM10濃度: " + result[i].PM10 + "μg/m3 PM2.5濃度: " + result[i]["PM2.5"] + " μg/m3 \n";
                        }
                    }
                    document.getElementById("air").innerHTML = airText;
                    document.getElementById("WeatherURL").innerHTML = "<a Target=\"_new\" href=\"http://weather.json.tw/#" + sel.value + "\"> 查看" + CityName + "</a>";
                }).error(function () {
                    alert("Server Error");
                });
            }
        </script>

        <!-- 成人建議熱量的方法 -->
        <script>
            function Advise_Calories() {
                $("#dialogAdultHot").html("<table bgcolor=\"white\">  <tr><td bgcolor=\"white\"><font color=\"black\" face=\"monospace\">活動強度：</font></td><td bgcolor=\"white\"><select onchange=\"CountAdviseCal()\" id=\"AdviseType\"><option value=\"40\">高強度</option><option value=\"35\">一般強度</option><option value=\"30\">低強度</option></select></td><tr><td bgcolor=\"white\"><font color=\"black\" face=\"monospace\">體重(KG)：</font></td><td bgcolor=\"white\"><input onfocusout=\"CountAdviseCal()\" type=\"number\" name=\"weight\" id=\"Adviseweight\" class=\"text ui-widget-content ui-corner-all\" /></td></tr><tr><td bgcolor=\"white\"><font color=\"black\" face=\"monospace\">建議熱量：</font></td><td id=\"adviseresult\" bgcolor=\"white\"></td></table>  <div id=\"errorcall4\"></div>");
                $("#dialogAdultHot").dialog({
                    autoOpen: false,
                    height: 350,
                    width: 450,
                    modal: true,
                });
                $("#dialogAdultHot").dialog("open");
            }

            function CountAdviseCal() {
                var cal = document.getElementById("AdviseType").value;
                var Adviseweight = document.getElementById("Adviseweight").value;
                var errorcall = document.getElementById("errorcall4");
                var adviseresult = document.getElementById("adviseresult");
                var error = "";
                if (Adviseweight == "") {
                    error = "<font color=\"red\">體重不可為空白!!!</font>";
                } else if (Adviseweight < 0 || Adviseweight == 0) {
                    error = "<font color=\"red\">體重必須要大於0!!!</font>";
                } else {
                    error = "";
                    var CountC = Adviseweight * cal;
                    adviseresult.innerHTML = "<font color=\"black\" face=\"monospace\">每日建議攝取熱量 " + CountC + " 大卡</font>";
                }

                errorcall.innerHTML = error;
                errorcall.style.display = "block";
            }
        </script> 
        <!-- 日誌管理 -->
        <script>
            function   Diary_Management() {
                if (user_id == "") {
                    alert("請先登入");
                } else {

                    window.open("/17gogo/management.php");
                }
            }
            function checklogin() {
                if (user_id == "") {
                    document.getElementById("banner").style.display = "block";
                    document.getElementById("logout").style.display = "none";
                    // alert("請先登入");
                } else {
                    document.getElementById("banner").style.display = "none";
                    document.getElementById("logout").innerHTML = "<font color=\"white\">歡迎! &nbsp&nbsp&nbsp" + User_Name + "&nbsp&nbsp</font> <a href=\"\\17gogo\\updateuser.php\" >修改會員資料</a>  &nbsp&nbsp&nbsp <a href=\"#\" onclick=\"loginout();\">登出</a>";
                    document.getElementById("logout").style.display = "block";
                    // window.open("/17gogo/management.php");
                }
            }
             window.onload = checklogin;      
        </script>    		  	
        <!-- jquery測試完-->	

    </head>
    <body id="top">

        <!-- Banner -->
        <!--
                To use a video as your background, set data-video to the name of your video without
                its extension (eg. images/banner). Your video must be available in both .mp4 and .webm
                formats to work correctly.
        -->
        <section id="banner" data-video="images/banner" >
            <div class="inner">
                <header>
                    <h1>17 GoGo</h1>
                    <p>有健康的身體才有精彩的人生</p>
                    <button class="button style1re fit"  onclick="Login_User()">登入</button></br>
                    <div id="dialogLogin" title="login" style="display:none;"></div>
                    <a href="register.html" class="button style2re fit">註冊</a>
                    <!--<button class="button style2 fit">註冊</button>
                    <div id="dialogRegister" title="register" style="display:none;"></div>	-->				
                </header>
                <a href="#main" class="more">Learn More</a>
            </div>
        </section>

        <!-- Main -->
        <div id="main">
            <div id="logout" style=" position: absolute;right: 80px; top: 20px;" >  </div>

            <div class="inner">

                <!-- Boxes -->
                <div class="thumbnails">

                    <div class="box">
                        <a  class="image fit"><img src="images/pic01.jpg" alt="" /></a>
                        <div class="inner">
                            <h3>查詢運動場所</h3>
                            <p>可以顯示室內或室外的運動場所</p>
                            <button class="button fit" onclick="Select_Location()">Search</button>
                            <div id="dialogShowExerciseLocation" title="location" style="display:none;"></div>									
                        </div>
                    </div>

                    <div class="box">
                        <a  class="image fit"><img src="images/pic02.jpg" alt="" /></a>
                        <div class="inner">
                            <h3>健康站位置</h3>
                            <p>可以得知量測健康的地點</p>
                            <button class="button style2 fit" onclick="Select_HealthLocation()" >Search</button>
                            <div id="dialogShowHealthLocation" title="location" style="display:none;"></div>									
                        </div>
                    </div>

                    <div class="box">
                        <a  class="image fit"><img src="images/pic03.jpg" alt="" /></a>
                        <div class="inner">
                            <h3>查詢運動消耗熱量</h3>
                            <p>可以查詢各類運動所消耗的熱量</p>
                            <button class="button style3 fit" onclick="Select_Exercise()">Search</button>
                            <div id="dialogExerciseHot" title="exercise" style="display:none;"></div>									
                        </div>
                    </div>

                    <div class="box">
                        <a  class="image fit"><img src="images/pic04.jpg" alt="" /></a>
                        <div class="inner">
                            <h3>查詢食物熱量</h3>
                            <p>可以查詢各類食物的熱量 </p>
                            <button class="button style2 fit" onclick="Select_Food()">Search</button>
                            <div id="dialogFoodHot" title="food" style="display:none;"></div>									
                        </div>
                    </div>

                    <div class="box">
                        <a  class="image fit"><img src="images/pic05.jpg" alt="" /></a>
                        <div class="inner">
                            <h3>查看天氣</h3>
                            <p>可以查詢天氣狀況</p>
                            <button class="button style3 fit" onclick="Select_Weather();" >Search</button>
                            <div id="dialogWeather" title="weather" style="display:none;"></div>									
                        </div>
                    </div>


                    <div class="box">
                        <a  class="image fit"><img src="images/pic07.jpg" alt="" /></a>
                        <div class="inner">
                            <h3>查詢成人熱量建議</h3>
                            <p>可以查詢成人熱量攝取建議</p>
                            <button class="button fit" onclick="Advise_Calories()" >Search</button>
                            <div id="dialogAdultHot" title="advice" style="display:none;"></div>									
                        </div>
                    </div>

                    <div class="box">
                        <a  class="image fit"><img src="images/pic06.jpg" alt="" /></a>
                        <div class="inner">
                            <h3>管理日誌</h3>
                            <p>登入後可進行日誌的管理</p>
                            <a onclick="Diary_Management()" class="button fit">Enter</a>
                        </div>
                    </div>                    
                    <!--正在測試-->

                    <div class="box">
                        <a  class="image fit"><img src="images/pic08.jpg" alt="" /></a>
                        <!--<div class="inner">
                                <h3>xxx</h3>
                                <p>xxxxxx</p>
                                <a  class="button fit" data-poptrox="youtube,800x400">Search</a>
                        </div>-->
                    </div>


                    <div class="box">
                        <a  class="image fit"><img src="images/pic09.jpg" alt="" /></a>
                        <!-- <div class="inner">
                                <h3>xxx</h3>
                                <p>xxxxx</p>
                                <a  class="button fit" data-poptrox="youtube,800x400">Search</a>
                        </div>-->
                    </div>

                </div>


            </div>
            <script src="assets/js/jquery.min.js"></script> 
            <script src="assets/js/jquery.scrolly.min.js"></script>
            <script src="assets/js/jquery.poptrox.min.js"></script>
            <script src="assets/js/skel.min.js"></script>
            <script src="assets/js/util.js"></script>
            <script src="assets/js/main.js"></script>


    </body>
</html>