<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-14
 * Time: 오후 5:39
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php"; ?>

<script>
    $(document).ready(function(){
        $(function (){
            $(".tabContent").hide();
            $(".tabContent:first").show();

            $("ul.tabmenu li").click(function(){
                $(".tabList").removeClass("on");
                $(this).addClass("on");
                $(".tabContent").hide();
                let activeTab = $(this).attr("rel");
                $("#" + activeTab).fadeIn();
            });
        });
        setHeaderTitle("급여");
        initDatepicker(".datepicker");

        let original = 192300000;
        $("#real").html(original.toLocaleString());
    });
</script>

<form id="form">
    <div class="popup_area01">
        <div class="motor_pop">
            <ul class="pop_tab clearfix tabs">
                <nav>
                    <ul class="tabmenu">
                        <li class="on tabList" rel="tabs-1">기간별 급여</li>
                        <li class="tabList" rel="tabs-2">월별 급여</li>
                    </ul>
                    <div class="area_tabmenu"></div>
                </nav>
            </ul>

            <div class="pop_content">
                <div class="tabContent" id="tabs-1">
                    <div class="bg_search clearfix">
                        <input type="text" class="inputbox center datepicker" id="periodStartDate" style="width:calc(38% - 30px);" value="" readonly />
                        ~
                        <input type="text" class="inputbox center datepicker" id="periodEndDate" style="width:calc(38% - 30px);" value="" readonly />
                        <button type="button" class="btn_search"><img src="/userApp/image/btn_search.png"> 조회</button>
                    </div>

                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="paytable">
                        <colgroup>
                            <col width="35%">
                            <col width="25%">
                            <col width="40%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>월 <img src="/userApp/image/ic_bar.png" class="f_r bg_white mt5" width="1"></th>
                            <th>구분 <img src="/userApp/image/ic_bar.png" class="f_r bg_white mt5" width="1"></th>
                            <th>금액</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td rowspan="3">
                                <p>2017년 12월</p>
                                <button type="button" class="btn_blue btn_bigh mt5" onclick="location.href='pay_month_hr_view.html';">상세보기</button>
                            </td>
                            <td class="tbold">실수령액</td>
                            <td><strong class="orange tbold" id="real"></strong> 원</td>
                        </tr>
                        <tr>
                            <td>지급액</td>
                            <td>2,000,000 원</td>
                        </tr>
                        <tr>
                            <td>공제액</td>
                            <td>400,000 원</td>
                        </tr>
                        <tr>
                            <td rowspan="3">
                                <p>2017년 11월</p>
                                <button type="button" class="btn_blue btn_bigh mt5" onclick="location.href='pay_month_view.html';">상세보기</button>
                            </td>
                            <td class="tbold">실수령액</td>
                            <td><strong class="orange tbold">1,900,000</strong> 원</td>
                        </tr>
                        <tr>
                            <td>지급액</td>
                            <td>2,000,000 원</td>
                        </tr>
                        <tr>
                            <td>공제액</td>
                            <td>400,000 원</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="tab02 clearfix tabContent" id="tabs-2">
                    <div class="bg_search clearfix">
                        <input type="text" class="inputbox center datepicker" id="monthlyStartDate" style="width:calc(38% - 30px);" value="" readonly />
                        ~
                        <input type="text" class="inputbox center datepicker" id="monthlyEndDate" style="width:calc(38% - 30px);" value="" readonly />
                        <button type="button" class="btn_search"><img src="/userApp/image/btn_search.png"> 조회</button>
                    </div>

                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="paytable">
                        <colgroup>
                            <col width="35%">
                            <col width="25%">
                            <col width="40%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>월 <img src="/userApp/image/ic_bar.png" class="f_r bg_white mt5" width="1"></th>
                            <th>구분 <img src="/userApp/image/ic_bar.png" class="f_r bg_white mt5" width="1"></th>
                            <th>금액</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td rowspan="3">
                                <p>2017년 12월</p>
                                <button type="button" class="btn_blue btn_bigh mt5" onclick="location.href='pay_month_view.html';">상세보기</button>
                            </td>
                            <td class="tbold">실수령액</td>
                            <td><strong class="orange tbold">1,900,000</strong> 원</td>
                        </tr>
                        <tr>
                            <td>(급여)지급액</td>
                            <td>2,000,000 원</td>
                        </tr>
                        <tr>
                            <td>공제액</td>
                            <td>400,000 원</td>
                        </tr>

                        <tr>
                            <td rowspan="3">
                                <p>2017년 11월</p>
                                <button type="button" class="btn_blue btn_bigh mt5" onclick="location.href='pay_month_hr_view.html';">상세보기</button>
                            </td>
                            <td class="tbold">실수령액</td>
                            <td><strong class="orange tbold">1,900,000</strong> 원</td>
                        </tr>
                        <tr>
                            <td>(급여)지급액</td>
                            <td>2,000,000 원</td>
                        </tr>
                        <tr>
                            <td>공제액</td>
                            <td>400,000 원</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</form>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/footerNavigation.php" ;?>