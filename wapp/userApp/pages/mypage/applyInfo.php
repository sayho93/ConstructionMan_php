<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 5. 8.
 * Time: PM 2:42
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>

<div class="header">
    <h2>구인 리스트</h2>
</div>

<div class="body">
    <div class="listWrapper">
        <table width="100%" border="0" cellpadding="0" cellspacing="6vw" class="doorlist" style="border-bottom: 1px solid gray; margin-top: 2vh;">
            <colgroup>
                <col width="20%">
                <col width="20%">
                <col width="20%">
                <col width="20%">
                <col width="20%">
            </colgroup>
            <tr class="">
                <td rowspan="3">
                    <img src="../../img/list_person.png" style="width: 15vw; height: 15vw;">
                </td>
                <td style="font-size: 1.0em" colspan="2">홍길동</td>
                <td colspan="2">
                    <img src="../../img/btn_email.png" style="width: 8vw; height: 8vw; float: right">
                    <!--<img src="./img/btn_sms.png" style="float: right">-->
                </td>
            </tr>
            <tr>
                <td class="subject">희망지역</td>
                <td class="content">서울, 대전</td>
                <td class="subject">직종</td>
                <td class="content">건축/콘크리트공, 철근공</td>
            </tr>
            <tr style="margin-bottom: 2vh;">
                <td class="subject">경력정보</td>
                <td class="content">12년</td>
            </tr>
        </table>

        <table width="100%" border="0" cellpadding="0" cellspacing="4vh" class="doorlist" style="border-bottom: 1px solid gray;margin-top: 2vh;">
            <colgroup>
                <col width="20%">
                <col width="20%">
                <col width="20%">
                <col width="20%">
                <col width="20%">
            </colgroup>
            <tr class="">
                <td rowspan="3">
                    <img src="../../img/list_person.png" style="width: 15vw; height: 15vw;">
                </td>
                <td style="font-size: 1.0em" colspan="2">홍길동</td>
                <td colspan="2">
                    <img src="../../img/btn_email.png" style="width: 8vw; height: 8vw; float: right;">
                    <!--<img src="./img/btn_sms.png" style="float: right">-->
                </td>
            </tr>
            <tr>
                <td class="subject">희망지역</td>
                <td class="content">서울, 대전</td>
                <td class="subject">직종</td>
                <td class="content">건축/콘크리트공, 철근공</td>
            </tr>
            <tr>
                <td class="subject">경력정보</td>
                <td class="content">12년</td>
            </tr>
        </table>
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



