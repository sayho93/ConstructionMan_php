<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 23.
 * Time: PM 4:57
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
    .ui-datepicker{ font-size: 0.8em; width: 60vw;}
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
            onSelect: function(selectedDate) {
            }
        });
    });

    $(document).ready(function(){
        $(".jPhone").click(function(){
            location.href = "tel:010-9719-1105";
        });

        var workArr = $("[name='workArr']").val();
        getWorkList();

        function getWorkList(){
            var param = new sehoMap().put("work", workArr);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.getWorkInfo", false, "json", param);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    console.log(data.data);
                    for(var i=0; i<data.data.length; i++){
                        var template = $(".template").html();
                        if(data.data[i].id === 16) template = $(".specialTemplate").html();

                        template = template.replace("#{no}", data.data[i].id);
                        template = template.replace("#{text}", data.data[i].name);
                        $(".career").append(template);
                    }
                }
                else{
                    alert("");
                }
            });
        }

        function collectCareer(){
            var careerArr = $(".list");
            var toRet = [];

            for(var i=2; i<careerArr.length; i++){
                var no = $(".jobItem").eq(i).attr("no");
                console.log(no);
                var value = $(".listValue").eq(i).val();
                toRet.push(value);

                if(no == "16"){
                    $("[name='welderType']").val($(".welderType").eq(1).val());
                }
            }
            return toRet;
        }

        function getGugunList(sidoId){
            var params = new sehoMap().put("sidoID", sidoId);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.getGugunList", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    $("#gugun").empty();
                    $("#gugun").append("<option value=\"\">구/군</option>")
                    $("#gugun").append("<option value='" + (sidoId * -1) + "'>" + "전체" + "</option>")
                    for(var i=0; i<data.data.length; i++){
                        $("#gugun").append("<option value='" + data.data[i].gugunID + "'>" + data.data[i].description + "</option>")
                    }
                }
                else
                    alert("구/군 리스트 조회 실패");
            });
        }

        $("#sido").change(function(){
            var sidoId = $("#sido").val();
            getGugunList(sidoId);
        });

        $(".discussLater").change(function(){
            var attr = $(this).prop("checked");
            if(attr == true){
                $("[name='discussLater']").val("1");
            }
            else{
                $("[name='discussLater']").val("0");
            }
        });

        $(".jAdd").click(function(){
            $("[name='careerArr']").val(collectCareer());
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
        });
    });

</script>


<div class="template" style="display:none;">
    <div class="list">
        <div class="jobItem" no="#{no}"><text>#{text}</text></div>
        <select class="listValue">
            <option value="0">근로년수 선택</option>
            <option value="1">5년 이하</option>
            <option value="2">5년 이상</option>
            <option value="3">10년 이상</option>
        </select>
    </div>
</div>

<div class="specialTemplate" style="display:none;">
    <div class="list">
        <div class="jobItem" no="#{no}"><text>#{text}</text></div>
        <select class="listValue">
            <option value="0">근로년수 선택</option>
            <option value="1">5년 이하</option>
            <option value="2">5년 이상</option>
            <option value="3">10년 이상</option>
        </select>
        <select class="welderType">
            <option value="">선택</option>
            <option value="알곤">알곤</option>
            <option value="전기">전기</option>
            <option value="산소">산소</option>
        </select>
    </div>
</div>

<div class="header">
    <img src="../../img/top_logo.png" class="headerLogo">
    <a class="tool_left"><img src="../../img/btn_drawer.png" class="leftLogo" /></a>
    <a class="tool_right"><img src="../../img/btn_phone.png" class="rightLogo jPhone" /></a>
</div>

<div class="body">
    <form name="form">
        <input type="hidden" name="type" value="M"/>
        <input type="hidden" name="workArr" value="<?=$_REQUEST["workArr"]?>"/>
        <input type="hidden" name="careerArr" value=""/>
        <input type="hidden" name="welderType" value=""/>
        <input type="hidden" name="pushKey" value=""/>
        <input type="hidden" name="discussLater" value=""/>


    <div class="career">
        <p>현장정보 등록</p>
    </div>

    <div class="searchManWrapper">
        <div class="line"></div>

        <p style="font-weight: bold">현장위치</p>
        <div class="wrapper">
            <select class="selectBlue" id="sido" name="sidoId" style="font-size: 2.0em">
                <option value="">시/도</option>
                <?for($i=0; $i<sizeof($regionList); $i++){?>
                    <option value="<?=$regionList[$i]->sidoID?>"><?=$regionList[$i]->abbreviation?></option>
                <?}?>
            </select>

            <select class="selectBlue" id="gugun" name="gugunId" style="margin-left: 3vw; font-size: 2.0em">
                <option value="">구/군</option>
            </select>
        </div>

        <p style="font-weight: bold">현장명</p>
        <div class="wrapper">
            <input type="text" name="name" class="inputBlue" />
        </div>

        <p style="font-weight: bold">작업기간</p>
        <div class="wrapper">
            <input type="text" name="startDate" placeholder="시작일" class="datepicker" readonly style="font-size: 2.0em"/>
            <input type="text" name="endDate" placeholder="마감일" class="datepicker" readonly style="font-size: 2.0em"/>
        </div>

        <div class="wrapper" style="width: 80vw;">
            <p style="width: 20vw; display: inline-block; font-size: 2.0em; margin-right: 1vw; font-weight: bold;">숙소제공</p>
            <input type="radio" name="lodging" id="r1" value="1"/> <label for="r1">유</label>
            <input type="radio" name="lodging" id="r2" value="0"/> <label for="r2">무</label>
        </div>

        <p style="font-weight: bold">단가</p>
        <div class="wrapper">
            <input type="number" name="price" class="inputBlueSmall" style="font-size: 2.0em"/> 원
            <input type="checkbox" class="discussLater" id="chk" style="margin-left: 8vw;"/>
            <label for="chk"></label>
            <h3>추후협의</h3>
        </div>

        <input type="button" class="searchBtn jAdd" value="신청하기"/>
    </div>

    </form>

    <div class="footer" style="margin-top: 10vh;">
        <span>휴넵스/건설인</span>
        <br>
        <p>특허 제 10-1705485 호 / 사업자등록번호 461-14-00804</p>
        <p>직업정보제공사업신고번호 J1700020180005호 / 통신판매업신고 제 2018-대전유성-0240 호</p>
        <p>mail : huneps71@gmail.com / tel : </p>
        <br>
        <p>ⓒ 휴넵스 All rights reserved.</p>
    </div>
</div>

