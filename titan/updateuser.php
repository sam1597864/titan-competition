<!DOCTYPE HTML>

<html>

    <head>

    </head>


    <body>

        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

        <!-- jquery測試-->		
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="assets/css/register.css" />
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
            window.onload = Find_User;

            function Find_User() {
                $.ajax({
                    type: "POST",
                    url: "http://localhost/17gogo/Member.php",
                    data: {"func": "FindUser", "user_id": user_id},
                    error: function (result) {
                        alert('Service call failed: ' + result.status + '' + result.statusText);
                    }, success: function (result) {
                        if (result.includes("error"))
                        {
                            alert("!!!");

                        } else {
                            //  alert(result);
                            var json = JSON.parse(result);
                            document.getElementById("name").value = json[0].User_Name;
                            document.getElementById("email").value = json[0].Email;
                            document.getElementById("password").value = json[0].Pwd;
                            //var pw2 = document.getElementById("password").value;
                            document.getElementById("height").value = json[0].Height;
                            document.getElementById("weight").value = json[0].Weight;
                            document.getElementById("birthday").value = json[0].Birth.split(" ")[0];
                            if (json[0].Sex == "M") {
                                document.getElementById("sex").selectedIndex = 0;
                            } else if (json[0].Sex == "F") {
                                document.getElementById("sex").selectedIndex = 1;
                            } else {
                                document.getElementById("sex").selectedIndex = 2;
                            }

                        }
                    }
                });
            }
            function Update_User() {
                var email = document.getElementById("email").value;
                var pw1 = document.getElementById("password").value;
                var pw2 = document.getElementById("password2").value;
                var name = document.getElementById("name").value;
                var height = document.getElementById("height").value;
                var weight = document.getElementById("weight").value;
                var birth = document.getElementById("birthday").value;
                var sex = document.getElementById("sex").value;
                var errorcall1 = "";
                var errorcall2 = "";
                var errorcall3 = "";
                var errorcall4 = "";
                var errorcall5 = "";
                // var  document.getElementById("SearchButton").style.display = "block";
                var error = "";
                //信箱格式判斷
                if (email == "") { //是否為空值
                    errorcall1 = "<font color=\"red\">信箱不可為空白!!!</font>";
                    document.getElementById("error1").innerHTML = errorcall1;
                }
                if (!email == "") {//是否為空值
                    if (!email.includes("@")) {
                        errorcall1 = "<font color=\"red\">這不是一個信箱格式!!!</font> <br/>";
                        document.getElementById("error1").innerHTML = errorcall1;
                    }
                }
                if (pw1 == "" || pw2 == "") {
                    errorcall2 = "<font color=\"red\">密碼不可為空白!!!</font>";
                    document.getElementById("error12").innerHTML = errorcall2;
                }
                if (name == "") {
                    errorcall3 = "<font color=\"red\">姓名不可為空白!!!</font>";
                    document.getElementById("error2").innerHTML = errorcall3;
                }
                if (height == "") {
                    errorcall4 = "<font color=\"red\">身高不可為0!!!</font>";
                    document.getElementById("error21").innerHTML = errorcall4;
                }
                if (weight == "") {
                    errorcall5 = "<font color=\"red\">體重不可為0!!!</font>";
                    document.getElementById("error22").innerHTML = errorcall5;
                }
                /*if (birth == "") {
                 error += "<font color=\"red\">生日不可為空白!!!</font>";
                 errorcall.innerHTML = error;
                 errorcall.style.display = "block";
                 }*/
                /*if (sex == "") {
                 error += "<font color=\"red\">性別不可為空白!!!</font>";
                 errorcall.innerHTML = error;
                 errorcall.style.display = "block";
                 }*/
                if (checkEmailerrorcall=="" && errorcall1 == "" && errorcall2 == "" && errorcall3 == "" && errorcall4 == "" && errorcall5 == "") {
                    ///alert();
                    $.ajax({
                        type: "POST",
                        url: "http://localhost/17gogo/Member.php",
                        data: {"func": "UpdateUser", "user_id":user_id, "user_email": email, "user_password": pw1, "user_name": name, "user_height": height, "user_weight": weight, "user_birth": birth, "user_sex": sex},
                        error: function (result) {
                            alert('Service call failed: ' + result.status + '' + result.statusText);
                        }, success: function (result) {
                            if (result.includes("Insert Error"))
                            {
                                alert("修改失敗，請再重新輸入!");
                            } else
                            {
                                alert("修改成功!");
                                location.href ='http://localhost/17gogo/index.php';
                                
                            }
                        }
                    });
                }

            }
            var checkEmailerrorcall = ""
            function checkEmail() {
                var email = document.getElementById("email").value;

                if (email == "") {
                    checkEmailerrorcall = "<font color=\"red\">信箱不可以空白!!!</font> <br/>";
                } else if (!email.includes("@")) {
                    checkEmailerrorcall = "<font color=\"red\">這不是一個信箱格式!!!</font> <br/>";
                } else {
                    checkEmailerrorcall = "";
                    $.ajax({
                        type: "POST",
                        url: "http://localhost/17gogo/Member.php",
                        data: {"func": "CheckUser", "user_email": email},
                        error: function (result) {
                            alert('Service call failed: ' + result.status + '' + result.statusText);
                        }, success: function (result) {
                            if (result.includes("User have been Insert"))
                            {
                                checkEmailerrorcall = "<font color=\"red\">此信箱已被使用!!!</font>";
                            } else
                            {
                                checkEmailerrorcall = "";
                            }
                            document.getElementById("error1").innerHTML = checkEmailerrorcall;
                        }
                    });
                }
                document.getElementById("error1").innerHTML = checkEmailerrorcall;
            }
            function checkPassword() {
                var pw1 = document.getElementById("password").value;
                var pw2 = document.getElementById("password2").value;
                if (pw1 == "" || pw2 == "" ) {
                    errorcall = "<font color=\"red\">密碼不可為空白!!!</font>";
                } else {
                    errorcall = "";
                }
                document.getElementById("error12").innerHTML = errorcall;
            }
            function checkName() {
                var name = document.getElementById("name").value;
                if (name == "") {
                    errorcall = "<font color=\"red\">姓名不可為空白!!!</font>";
                } else {
                    errorcall = "";
                }
                document.getElementById("error2").innerHTML = errorcall;
            }
            function checkHeight() {
                var height = document.getElementById("height").value;
                if (height <= 0) {
                    errorcall = "<font color=\"red\">身高輸入錯誤!!!</font>";
                } else {
                    errorcall = "";
                }
                document.getElementById("error21").innerHTML = errorcall;
            }
            function checkWeight() {
                var weight = document.getElementById("weight").value;
                if (weight <= 0) {
                    errorcall = "<font color=\"red\">體重輸入錯誤!!!</font>";
                } else {
                    errorcall = "";
                }
                document.getElementById("error22").innerHTML = errorcall;
            }

        </script>
        <div class="pagediv">
            <div class="wrapper"  align="center" style="margin: 0px auto;" >
                <h1>Edit Your Account</h1>
                <p>請輸入以下資訊以修改您的帳戶</p>

                <fieldset>
                    <legend color="white">帳戶設置:</legend>
                    <input id="email" type="email" class="email" placeholder="Email" onfocusout="checkEmail();" disabled>
                    <div id="error1"></div>

                    <div>
                        <p class="emailhelp">Please enter your current email address.</p>
                    </div>

                    <input type="password" class="" placeholder="Password" id="password" onfocusout="checkPassword()" >
                    <div>
                        <p class="emailhelp">Please enter your password.</p>
                    </div>

                    <input type="password" class="" placeholder="Check Password" id="password2" onfocusout="checkPassword()" >
                    <div>
                        <p class="emailhelp">Please check your password again.</p>
                    </div>          

                    <div id="error12"></div>
                </fieldset>

                <br>


                <fieldset>
                    <legend color="white">個人資訊:</legend>
                    <input id="name" type="text" class="name" placeholder="Name" onfocusout="checkName()">
                    <div id="error2"></div>
                    <div>
                        <p class="namehelp">Please enter your first and last name.</p>
                    </div>  

                    <font color="#6E6E6E" face="monospace" align="left" >Please enter your height.</font>
                    <input id="height" type="number" class="height" placeholder=0 onfocusout="checkHeight()">
                    <div id="error21"></div>
                    <div>
                        <p class="namehelp">Please enter your height.</p>
                    </div>              

                    <font color="#6E6E6E" face="monospace" align="left">Please enter your weight.</font>
                    <input id="weight" type="number" class="weight" placeholder=0 onfocusout="checkWeight()">
                    <div id="error22"></div>
                    <div>
                        <p class="namehelp">Please enter your weight.</p>
                    </div>

                    <font color="#6E6E6E" face="monospace" align="left">Please enter your birthday.</font>
                    <input id="birthday" type="date" class="weight" placeholder="Birthday">
                    <div>
                        <p class="namehelp">Please enter your birthday.</p>
                    </div>          

                    <font color="#6E6E6E" face="monospace" align="left">Please enter your sex.</font>
                    <select id="sex" placeholder="性別">
                        <option value="men" >Male</option>
                        <option value="women">Female</option>
                        <option value="other" selected="selected">Others</option>
                    </select>
                </fieldset>

                <br>



                <input onclick="Update_User();" type="submit" class="submit style2 fit" value="UpdateUser"  >
            </div>
            <p class="optimize">
                17GoGo!!
            </p>
        </div>
    </body>

</html>