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
    <a class="tool_left"><img src="../../img/btn_prev.png" class="jBack" /></a>
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
        <p>대표 : 이화수 / 사업자등록번호 : 111-222-3333333</p>
        <p>주소 : 대전광역시 유성구 봉명동 1111</p>
        <p>TEL : 1644-1111 / MAIL : geonseolin@geonseolin.com</p>
        <br><br>
        <p>ⓒ휴넵스 All rights reserved.</p>
    </div>
</div>
