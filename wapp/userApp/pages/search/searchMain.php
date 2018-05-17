<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 23.
 * Time: PM 4:23
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>

<script>
    $(document).ready(function(){
        getPushKey();

        $(".jPhone").click(function(){
            location.href = "tel:010-9719-1105";
        });
    });

    function getPushKey(){
        location.href = "pickle://getPushKey";
    }

    function getPushKeyCallBack(pushKey){
        console.log("getPushKeyCallBack called :::::::::::::::::::::::::");
        var pushKey = decodeURI(pushKey);
        var ajax = new AjaxSender("/action_front.php?cmd=WebUser.updatePushKey", true, "json", new sehoMap().put("pushKey", pushKey));
        ajax.send(function(data){
            if(data.data.returnCode === 1){
                alert("pushKey updated");
            }
        });
    }
</script>

<div class="header">
    <img src="../../img/top_logo.png" class="headerLogo">
    <a href="/userApp/pages/mypage/mypageMain.php" class="tool_left"><img src="../../img/btn_drawer.png" class="leftLogo"/></a>
    <a class="tool_right"><img src="../../img/btn_phone.png" class="rightLogo jPhone"/></a>
</div>

<div class="body">
    <div class="typeWrapper">
        <a href="/userApp/pages/search/searchManType.php" id="manf"></a>
        <a href="/userApp/pages/search/searchGearType.php" id="gearf"></a>
    </div>

    <div class="footer">
        <span>휴넵스/건설인</span>
        <br>
        <p>특허 제 10-1705485 호 / 사업자등록번호 461-14-00804</p>
        <p>직업정보제공사업신고번호 J1700020180005호 / 통신판매업신고 제 2018-대전유성-0240 호</p>
        <p>Tmail : huneps71@gmail.com / tel : </p>
        <br>
        <p>ⓒ 휴넵스 All rights reserved.</p>
    </div>
</div>


</body>