<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Web.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php" ;?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>ConstructionMan</title>
    <link href="/userApp/css/style.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="/userApp/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="/modules/ajaxCall/ajaxClass.js"></script>
<script type="text/javascript" src="/modules/sehoMap/sehoMap.js"></script>
<script type="text/javascript" src="/modules/valueSetter/sayhoValueSetter.js"></script>

<script>
    $(document).ready(function(){
        $("#findID").click(function(){
            location.href="/userApp/pages/Account/findID.php";
        });

        $("#findPW").click(function(){
            location.href="/userApp/pages/Account/findPW.php";
        });

        $("#join").click(function(){
            location.href="/userApp/pages/Account/memberJoin.php";
        });

        $(".jLogin").click(function(){
            var account = $("#account").val();
            var password = $("#password").val();
            var isAuto = $("#chk").prop("checked");

            var params = new sehoMap();
            params.put("account", account);
            params.put("password", password);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.userLogin", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode == 1){
                    location.href = "/userApp/pages/search/searchMain.php";
                    console.log(data);
                }
                else{
                    alert("일치하는 계정정보가 없습니다");
                }
            });
        });
    });



</script>

<body>
<div class="header">

    <h2>로그인</h2>
</div>

<div class="body">
    <div class="form">

        <img src="./img/logo_blue.png" class="logoBlue">

        <input type="text" id="account" placeholder="  아이디"/>
        <input type="text" id="password" placeholder="  비밀번호"/>

        <input type="button" value="로그인" class="jLogin"/>
        <div class="line"></div>
        <div class="left">
            <input type="checkbox" id="chk"/>
            <label for="chk"></label>
            <h3>로그인 상태유지</h3>
        </div>
        <div class="right">
            <span id="findID">아이디 찾기</span> / <span id="findPW">비밀번호 찾기</span> / <span id="join">회원가입</span>
        </div>
    </div>

    <div class="footer" style="margin-top: 20vh;">
        <span>휴넵스/건설인</span>
        <br>
        <p>대표 : 이화수 / 사업자등록번호 : 111-222-3333333</p>
        <p>주소 : 대전광역시 유성구 봉명동 1111</p>
        <p>TEL : 1644-1111 / MAIL : geonseolin@geonseolin.com</p>
        <br>
        <p>ⓒ휴넵스 All rights reserved.</p>
    </div>

</div>

</body>
</html>

