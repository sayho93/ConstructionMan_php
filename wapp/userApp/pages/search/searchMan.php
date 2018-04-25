<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 23.
 * Time: PM 4:57
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<style>
    .ui-datepicker{ font-size: 1.5em; width: 50vw;}
    .ui-datepicker select.ui-datepicker-month{ width:30%; font-size: 1.5em; }
    .ui-datepicker select.ui-datepicker-year{ width:40%; font-size: 1.5em; }
</style>
<script>
    $(function(){
        $(".datepicker").datepicker({
            showMonthAfterYear:true,
            inline: true,
            changeMonth: true,
            changeYear: true,
            dateFormat : 'yy-mm-dd',
            dayNamesMin:['일', '월', '화', '수', '목', '금', ' 토'],
            monthNames:['1월','2월','3월','4월','5월','6월','7 월','8월','9월','10월','11월','12월'],
            monthNamesShort:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            showButtonPanel: true, currentText: '오늘 ' , closeText: '닫기',
            onSelect: function(selectedDate) {
            }
        });
    } );
</script>

<div class="header">
    <img src="../../img/top_logo.png" class="headerLogo">
    <a class="tool_left"><img src="../../img/btn_drawer.png" /></a>
    <a class="tool_right" style="margin-right: 30px;"><img src="../../img/btn_phone.png" /></a>
</div>

<div class="body">
    <div class="career">
        <p>경력정보 등록</p>
        <div class="list">
            <div class="jobItem"><text>콘크리트공</text></div>
            <select>
                <option>근로년수 선택</option>
                <option>5년 이하</option>
                <option>5년 이상</option>
                <option>10년 이상</option>
            </select>
        </div>

        <div class="list">
            <div class="jobItem"><text>콘크리트공</text></div>
            <select>
                <option>근로년수 선택</option>
                <option>5년 이하</option>
                <option>5년 이상</option>
                <option>10년 이상</option>
            </select>
        </div>

        <div class="line"></div>

        <p>현장위치</p>
        <div class="wrapper">
            <select class="selectBlue">
                <option>시/군/구</option>
            </select>

            <select class="selectBlue" style="margin-left: 3vw;">
                <option>읍/면/동/리</option>
            </select>
        </div>

        <p>작업내용</p>
        <div class="wrapper">
            <input type="text" class="inputBlue" />
        </div>

        <p>작업기간</p>
        <div class="wrapper">
            <input type="text" class="datepicker" />
            <input type="text" class="datepicker" />
        </div>

        <p>숙소제공</p>
        <input type="radio" id="r1" name="rr" />
        <label for="r1">유</label>
        <input type="radio" id="r2" name="rr" />
        <label for="r2">무</label>
        <br>

        <p>단가</p>
        <div class="wrapper">
            <input type="number" class="inputBlueSmall"/> 원
            <input type="checkbox" id="chk" style="margin-left: 8vw;"/>
            <label for="chk"></label>
            <h3>추후협의</h3>
        </div>

        <input type="button" value="신청하기"/>
    </div>

    <div class="footer" style="margin-top: 44vh;">
        <span>휴넵스/건설인</span>
        <br>
        <p>대표 : 이화수 / 사업자등록번호 : 111-222-3333333</p>
        <p>주소 : 대전광역시 유성구 봉명동 1111</p>
        <p>TEL : 1644-1111 / MAIL : geonseolin@geonseolin.com</p>
        <br><br>
        <p>ⓒ휴넵스 All rights reserved.</p>
    </div>
</div>

