<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 5. 17.
 * Time: PM 1:38
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<script>
    $(document).ready(function(){
       $(".done").click(function(){
           location.href = "/userApp/pages/search/searchMain.php";
       });
    });
</script>

<div class="headerLess">
    <img src="../../img/logo_black_large.png" class="logoBig" align="middle">
    <img src="../../img/caption_welcome.png" class="finishMsg" align="middle">

    <h3>신뢰할 수 있는 건설인에서 확인하세요!</h3>

    <input type="button" class="done" value="확인" />

    <div class="footer">
        <span>휴넵스/건설인</span>
        <br>
        <p>특허 제 10-1705485 호 / 사업자등록번호 461-14-00804</p>
        <p>직업정보제공사업신고번호 J1700020180005호 / 통신판매업신고 제 2018-대전유성-0240 호</p>
        <p>mail : huneps71@gmail.com / tel : </p>
        <br>
        <p>ⓒ 휴넵스 All rights reserved.</p>
    </div>
</div>
