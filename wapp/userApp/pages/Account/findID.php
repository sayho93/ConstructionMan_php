<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 23.
 * Time: PM 3:52
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>

<script>
    $(document).ready(function(){
        $("#findPW").click(function(){
            location.href = "/userApp/pages/Account/findPW.php";
        });
    });
</script>

<div class="header">
    <h2>아이디 찾기</h2>
</div>

<div class="body">
    <div class="form">

        <div class="mid">
            아이디를 잊으셨나요? <br>회원정보에 등록된 이름, 휴대폰번호를 입력해 주세요
        </div>

        <input type="text" placeholder="  이름"/>
        <input type="number" placeholder="  휴대폰 번호(- 제외)"/>

        <input type="button" value="확인"/>
        <div class="line"></div>

        <div class="toPW">
            <p>비밀번호를 모르시나요?</p>
            <a id="findPW">비밀번호 찾기 바로가기▶</a>
        </div>
    </div>

    <div class="footer" style="margin-top: 20vh;">
        <span>휴넵스/건설인</span>
        <br>
        <p>대표 : 이화수 / 사업자등록번호 : 111-222-3333333</p>
        <p>주소 : 대전광역시 유성구 봉명동 1111</p>
        <p>TEL : 1644-1111 / MAIL : geonseolin@geonseolin.com</p>
        <br><br>
        <p>ⓒ휴넵스 All rights reserved.</p>
    </div>

</div>

