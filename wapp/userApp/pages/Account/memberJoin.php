<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-08
 * Time: 오후 2:44
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>

<script>
    $(document).ready(function(){
        $("#man").click(function(){
            location.href = "/userApp/pages/Account/phoneAuth.php?type=M";
        });

        $("#gear").click(function(){
            location.href = "/userApp/pages/Account/phoneAuth.php?type=G";
        });

        $("#normal").click(function(){
            location.href = "/userApp/pages/Account/phoneAuth.php?type=N";
        });

        $(".jBack").click(function(){
            history.go(-1);
        });
    });
</script>

<div class="header">
    <h2>회원가입</h2>
    <a class="tool_left"><img src="../../img/btn_prev.png" class="jBack back" /></a>
    <a class="hide tool_right"><img src="../../img/btn_prev.png" /></a>
</div>

<div class="body">
    <div class="typeWrapper">
        <a href="#" id="man"></a>
        <a href="#" id="gear"></a>
        <a href="#" id="normal"></a>
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
