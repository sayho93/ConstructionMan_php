<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 23.
 * Time: PM 4:52
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<script>
    $(function (){
        $(".tabContent").hide();
        $(".tabContent:first").show();

        $(".item").click(function(){
            $(".item").removeClass("on");
            $(this).addClass("on");
            $(".tabContent").hide();
            var activeTab = $(this).attr("rel");
            $("#" + activeTab).show();
        });

        $(".jobItem").click(function(){
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
    <div class="jobClass">
        <p>직종선택</p>
        <div id="itemWrapper">
            <div class="item on" rel="tab1"><text>건축</text></div>
            <div class="item" rel="tab2"><text>기계설비</text></div>
            <div class="item" rel="tab3"><text>전기<br>통신<br>소방</text></div>
            <div class="item" rel="tab4"><text>관리자</text></div>
            <div class="item" rel="tab5"><text>인테리어</text></div>
        </div>

        <div class="align_center">
            <a href="#" id="middleArea"></a>
        </div>

        <div class="jobTable">
            <div class="tabContent" id="tab1">
                <div class="jobItem"><text>콘크리트공</text></div>
                <div class="jobItem"><text>철근공</text></div>
                <div class="jobItem"><text>조적공</text></div>
                <div class="jobItem"><text>석공</text></div>
                <div class="jobItem"><text>타일공</text></div>
                <div class="jobItem"><text>수장공</text></div>
                <div class="jobItem"><text>방수공</text></div>
                <div class="jobItem"><text>비계공</text></div>
                <div class="jobItem"><text>미장공</text></div>
                <div class="jobItem"><text>견출공</text></div>
                <div class="jobItem"><text>도장공</text></div>
                <div class="jobItem"><text>부대토목공</text></div>
                <div class="jobItem"><text>형틀목공</text></div>
                <div class="jobItem"><text>지붕및홈통공</text></div>
            </div>

            <div class="tabContent" id="tab2">
                <div class="jobItem"><text>배관공</text></div>
                <div class="jobItem"><text>용접공</text></div>
                <div class="jobItem"><text>보온공</text></div>
                <div class="jobItem"><text>덕트설비공(공조,냉동,보일러)</text></div>
                <div class="jobItem"><text>위생설비공(변기,세면기,욕조)</text></div>
                <div class="jobItem"><text>소화설비공(소화전,스프링쿨러)</text></div>
                <div class="jobItem"><text>도비공(기계설치공)</text></div>
            </div>

            <div class="tabContent" id="tab3">
                <div class="jobItem"><text>송전공</text></div>
                <div class="jobItem"><text>배전공</text></div>
                <div class="jobItem"><text>내선공</text></div>
                <div class="jobItem"><text>플랜트공(제어공)</text></div>
                <div class="jobItem"><text>계장공</text></div>
                <div class="jobItem"><text>통신공</text></div>
                <div class="jobItem"><text>소방전기공</text></div>
                <div class="jobItem"><text>케이블포설공</text></div>
            </div>

            <div class="tabContent" id="tab4">
                <div class="jobItem"><text>공사관리자</text></div>
                <div class="jobItem"><text>공무관리자</text></div>
                <div class="jobItem"><text>설계관리자</text></div>
                <div class="jobItem"><text>안전관리자</text></div>
            </div>

            <div class="tabContent" id="tab5">
                <div class="jobItem"><text>도배공(장판)</text></div>
                <div class="jobItem"><text>목공(내장)</text></div>
                <div class="jobItem"><text>전기통신소방</text></div>
                <div class="jobItem"><text>타일공</text></div>
                <div class="jobItem"><text>미장공</text></div>
                <div class="jobItem"><text>간판공(실사)</text></div>
                <div class="jobItem"><text>냉난방시설공</text></div>
                <div class="jobItem"><text>샷시공</text></div>
                <div class="jobItem"><text>도장공</text></div>
            </div>
        </div>
    </div>

    <div class="center">
        <a href="/userApp/pages/search/searchMan.php" id="next"></a>
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

</body>
</html>
