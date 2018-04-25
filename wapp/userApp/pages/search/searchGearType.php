<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 23.
 * Time: PM 5:06
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<script>
    $(document).ready(function(){
        $(".gearItem").click(function(){
            if($(this).hasClass("on"))
                $(this).removeClass("on");
            else
                $(this).addClass("on");
        });

        $(".attachmentItem").click(function(){
            if($(this).hasClass("on"))
                $(this).removeClass("on");
            else
                $(this).addClass("on");
        });
    });
</script>

<div class="header">
    <img src="../../img/top_logo.png" class="headerLogo">
    <a class="tool_left"><img src="../../img/btn_drawer.png" /></a>
    <a class="tool_right" style="margin-right: 30px;"><img src="../../img/btn_phone.png" /></a>
</div>

<div class="body">
    <div class="gear">
        <p style="margin-top: 4vh;">장비선택</p>
        <div class="table">
            <div class="gearItem"><text>굴삭기</text></div>
            <div class="gearItem"><text>미니<br>굴삭기</text></div>
            <div class="gearItem"><text>크레인</text></div>
            <div class="gearItem"><text>스카이</text></div>
            <div class="gearItem"><text>지게차</text></div>

            <div class="gearItem"><text>바브캣</text></div>
            <div class="gearItem"><text>사다리<br>차</text></div>
            <div class="gearItem"><text>덤프<br>트럭</text></div>
            <div class="gearItem"><text>펌프카</text></div>
            <div class="gearItem"><text>살수차</text></div>

            <div class="gearItem"><text>롤러</text></div>
            <div class="gearItem"><text>불도저</text></div>
        </div>

        <div class="gearType">
            <span>굴삭기</span>
            <span>타이머</span>
            <span>03W(55W)</span>
        </div>
    </div>

    <div class="attachment">
        <p>어태치먼트</p>
        <div class="attachmentItem on"><text>뿌레카</text></div>
        <div class="attachmentItem"><text>집게</text></div>
        <div class="attachmentItem"><text>니퍼</text></div>
        <div class="attachmentItem"><text>채바가지</text></div>
        <div class="attachmentItem"><text>딱다구리</text></div>
    </div>

    <div class="center">
        <a href="#" id="next"></a>
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

