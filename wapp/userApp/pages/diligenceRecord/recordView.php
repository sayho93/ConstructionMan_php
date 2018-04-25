<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-14
 * Time: 오후 5:49
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php"; ?>
<script>
    $(document).ready(function(){
        initDatepicker(".datepicker");
        $(function(){
            $(".tabContent").hide();
            $(".tabContent:first").show();
            $("ul.tabmenu li").click(function () {
                $(".tabList").removeClass("on");
                $(this).addClass("on");
                $(".tabContent").hide();
                let activeTab = $(this).attr("rel");
                $("#" + activeTab).fadeIn();
            });
        });
        setHeaderTitle("근태");
    });
</script>

<form id="form">
    <div class="popup_area01">
        <div class="motor_pop">
            <ul class="pop_tab clearfix tabs">
                <nav>
                    <ul class="tabmenu">
                        <li class="on tabList" rel="tabs-1">근태 기록</li>
                        <li class="tabList" rel="tabs-2">근태 일정</li>
                    </ul>
                    <div class="area_tabmenu"></div>
                </nav>
            </ul>

            <div class="pop_content">
                <div class="tabContent" id="tabs-1">
                    <div class="bg_search clearfix">
                        <input type="text" class="inputbox center datepicker" id="recordStartDate" style="width:calc(37.5% - 30px);" value="" readonly />
                        ~
                        <input type="text" class="inputbox center datepicker" id="recordEndDate" style="width:calc(37.5% - 30px);" value="" readonly />
                        <button type="button" class="btn_search"><img src="/userApp/image/btn_search.png"> 조회</button>
                    </div>

                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="timelist">
                        <colgroup>
                            <col width="50%">
                            <col width="50%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>출근 <img src="/userApp/image/ic_bar.png" class="f_r bg_white mt5" width="1"></th>
                            <th>퇴근</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr onclick="location.href='work_record_view.html';">
                            <td>06.10(금) 09:00</td>
                            <td>06.10(금) 18:00</td>
                        </tr>
                        <tr>
                            <td>출근 미체크</td>
                            <td>06.09(목) 18:00</td>
                        </tr>
                        <tr>
                            <td>06.08(수) 09:00</td>
                            <td>06.08(수) 18:00</td>
                        </tr>
                        <tr>
                            <td>06.07(화) 09:00</td>
                            <td>퇴근 미체크</td>
                        </tr>
                        <tr>
                            <td>06.06(월) 09:00</td>
                            <td>06.06(월) 18:00</td>
                        </tr>
                        <tr>
                            <td>휴무</td>
                            <td>휴무</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="tab02 clearfix tabContent" id="tabs-2">
                    <div class="bg_search clearfix">
                        <input type="text" class="inputbox center datepicker" id="appointedStartDate" style="width:calc(38% - 30px);" value="" readonly />
                        ~
                        <input type="text" class="inputbox center datepicker" id="appointedEndDate" style="width:calc(38% - 30px);" value="" readonly />
                        <button type="button" class="btn_search"><img src="/userApp/image/btn_search.png"> 조회</button>
                    </div>

                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="timelist">
                        <colgroup>
                            <col width="50%">
                            <col width="50%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>출근 <img src="/userApp/image/ic_bar.png" class="f_r bg_white mt5" width="1"></th>
                            <th>퇴근</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>06.10(금) 09:00</td>
                            <td>06.10(금) 18:00</td>
                        </tr>
                        <tr>
                            <td>06.09(목) 09:00</td>
                            <td>06.09(목) 18:00</td>
                        </tr>
                        <tr>
                            <td>06.08(수) 09:00</td>
                            <td>06.08(수) 18:00</td>
                        </tr>
                        <tr>
                            <td>06.07(화) 09:00</td>
                            <td>06.07(화) 18:00</td>
                        </tr>
                        <tr>
                            <td>휴무</td>
                            <td>휴무</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</form>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/footerNavigation.php" ;?>