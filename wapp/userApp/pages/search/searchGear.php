<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 23.
 * Time: PM 5:06
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
    $obj = new WebUser($_REQUEST);
    $regionList = $obj->getSidoList();
    $regionList = json_decode($regionList)->data;
?>

<style>
    .ui-datepicker{ font-size: 0.8em; width: 60vw; position: relative; z-index: 100000;}
    .ui-datepicker select.ui-datepicker-month{ width:30%; font-size: 1.0em; }
    .ui-datepicker select.ui-datepicker-year{ width:40%; font-size: 1.0em; }
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
            onSelect: function(selectedDate){
            }
        });
    });

    $(document).ready(function(){
        $(".jPhone").click(function(){
            location.href = "tel:010-9719-1105";
        });

        $("#sido").change(function(){
            var sidoId = $("#sido").val();
            getGugunList(sidoId);
        });

        function getGugunList(sidoId){
            var params = new sehoMap().put("sidoID", sidoId);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.getGugunList", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    $("#gugun").empty();
                    $("#gugun").append("<option value=\"\">구/군</option>");
                    for(var i=0; i<data.data.length; i++){
                        $("#gugun").append("<option value='" + data.data[i].gugunID + "'>" + data.data[i].description + "</option>")
                    }
                }
                else
                    alert("구/군 리스트 조회 실패");
            });
        }

        $(".jAdd").click(function(){
            var params = $("[name='form']").serialize();
            $.ajax({
                url: "/action_front.php?cmd=WebUser.registerSearch",
                async: false,
                cache: false,
                dataType: "json",
                data: params,
                success: function(data){
                    console.log(data.data);
                    alert("공고가 등록되었습니다.");
                    location.href = "/userApp/pages/search/searchMain.php";
                }
            });
        })
    });
</script>

<div class="header">
    <img src="../../img/top_logo.png" class="headerLogo">
    <a class="tool_left"><img src="../../img/btn_drawer.png" class="leftLogo"/></a>
    <a class="tool_right"><img src="../../img/btn_phone.png" class="rightLogo jPhone"/></a>
</div>

<div class="body">
    <form name="form">
        <input type="hidden" name="gearId" value="<?=$_REQUEST["gearId"]?>"/>
        <input type="hidden" name="attachment" value="<?=$_REQUEST["attachment"]?>"/>
        <input type="hidden" name="type" value="G"/>

        <div class="career">
            <p>현장위치</p>
            <div class="wrapper">
                <select class="selectBlue" id="sido" name="sidoId">
                    <option value="">시/도</option>
                    <?for($i=0; $i<sizeof($regionList); $i++){?>
                        <option value="<?=$regionList[$i]->sidoID?>"><?=$regionList[$i]->abbreviation?></option>
                    <?}?>
                </select>

                <select class="selectBlue" id="gugun" name="gugunId" style="margin-left: 3vw;">
                    <option>구/군</option>
                </select>
            </div>

            <p>현장명</p>
            <div class="wrapper">
                <input type="text" name="name" class="inputBlue" style="font-size: 1.8em;"/>
            </div>

            <p>작업기간</p>
            <div class="wrapper">
                <input type="text" name="startDate" class="datepicker" placeholder="시작일" readonly style="font-size: 2.0em;position: relative; z-index: 100000"/>
                <input type="text" name="endDate" class="datepicker" placeholder="마감일" readonly style="font-size: 2.0em;position: relative; z-index: 100000"/>
            </div>

            <input type="button" class="searchBtn jAdd" value="신청하기"/>
        </div>
    </form>

    <div class="footer" style="margin-top: 20vw;">
        <span>휴넵스/건설인</span>
        <br>
        <p>특허 제 10-1705485 호 / 사업자등록번호 461-14-00804</p>
        <p>직업정보제공사업신고번호 J1700020180005호 / 통신판매업신고 제 2018-대전유성-0240 호</p>
        <p>mail : huneps71@gmail.com / Tel. 010-9719-1105 </p>
        <br>
        <p>ⓒ 휴넵스 All rights reserved.</p>
    </div>
</div>
