<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 25.
 * Time: PM 2:03
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
$obj = new WebUser($_REQUEST);
$regionList = $obj->getSidoList();
$regionList = json_decode($regionList)->data;
?>
<script>
    var regionArr = [];
    var workArr = [];


    $(document).ready(function(){
        $(".jBack").click(function(){history.go(-1)});

        $(".regionItem").click(function(){
            var regionID = $(this).attr("no");

            if(regionID == "0"){
                if($(this).hasClass("on")){
                    $(this).removeClass("on");
                    regionArr.splice(regionArr.indexOf("0"), 1);
                }
                else{
                    $(".regionItem").removeClass("on");
                    $(".regionItem").attr("gugunId", "");
                    $(".regionItem").find("#box").html("-");

                    $(this).addClass("on");
                    regionArr.push("0");
                }
            }
            else{
                if(regionArr.indexOf("0") > -1){
                    alert("전국 선택시 다른 지역은 선택이 불가합니다.");
                    return;
                }
                else{

                    if($(this).hasClass("on")){
                        $(this).removeClass("on");
                        $(this).attr("gugunId", "");
                        $(this).find("#box").html("-");
                        regionArr.splice(regionArr.indexOf(regionID), 1);
                    }
                    else{
                        getGugunList(regionID);
                        regionArr.push(regionID);
                    }
                }
            }
        });

        function getGugunList(sidoId){
            $(".popBody").empty();
            var params = new sehoMap().put("sidoID", sidoId);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.getGugunList", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode == 1){
                    for(var i=0; i<data.data.length; i++){
                        var template = $(".listTemplate").html();
                        template = template.replace("#{no}", data.data[i].gugunID);
                        template = template.replace("#{text}", data.data[i].description);
                        template = template.replace("#{prt}", data.data[i].sidoID);
                        $(".popBody").append(template);
                    }
                    $(".popBG").show();
                }
                else
                    alert("구/군 리스트 조회 실패");
            });
        }

        function collectGugunId(){
            var regionArr = $(".regionItem");
            var toRet = [];
            var cursor = 0;
            for(var e = 0; e < regionArr.length; e++){
                var value = regionArr.eq(e).attr("gugunId");
                if(value != "" && value != null) toRet[cursor++] = value;
            }
            return toRet;
        }

        function collectWorkId(){
            var workArr = $(".jobItem.on");
            var toRet = [];
            for(var i=0; i<workArr.length; i++){
                var value = workArr.eq(i).attr("no");
                toRet.push(value);
            }
            return toRet;
        }

        $(document).on("click", ".listItem", function(){
            var text = $(this).find("span").html();

            var thisId = $(this).attr("no");
            var parentId = $(this).attr("parentId");
            var parentObj = $(".regionItem[no="+ parentId +"]");
            if(parentObj == null) {
                return;
            }

            parentObj.attr("gugunId", thisId);
            parentObj.addClass("on");

            parentObj.find("#box").html(text);
            parentObj.find("#box").show();
            $(".popBG").hide();
        });


        $(".jClose").click(function(){
            $(".popBG").hide();
        });

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

        $("#next").click(function(){
            var regionArr = collectGugunId();
            var workArr = collectWorkId();

            regionArr = regionArr.join();
            if(regionArr == "") regionArr = "0";
            workArr = workArr.join();
            $("[name='regionArr']").val(regionArr);
            $("[name='workArr']").val(workArr);

            var str = $("[name='form']").serialize();

            location.href = "joinManStep2.php?" + str;
        });
    });

</script>

<div class="header">
    <a class="tool_left"><img src="../../img/btn_prev.png" class="back_btn jBack"/></a>
    <h2>회원가입</h2>
</div>

<div class="popBG" style="display: none;">
    <div class="popIcon jClose"></div>
    <div class="popArea">
        <div class="popHeaderWrap">
            <div class="popHeader">
                지역 선택
            </div>
        </div>
        <div class="popBody">

        </div>
    </div>
</div>

<div class="listTemplate" style="display: none;">
    <div class="listItem" no="#{no}" parentId="#{prt}"><span>#{text}</span></div>
</div>

<div class="body">
    <form name="form">
        <input type="hidden" name="account" value="<?=$_REQUEST["account"]?>"/>
        <input type="hidden" name="password" value="<?=$_REQUEST["password"]?>"/>
        <input type="hidden" name="name" value="<?=$_REQUEST["name"]?>"/>
        <input type="hidden" name="age" value="<?=$_REQUEST["age"]?>"/>
        <input type="hidden" name="residence" value="<?=$_REQUEST["residence"]?>"/>
        <input type="hidden" name="phone" value="<?=$_REQUEST["phone"]?>"/>
        <input type="hidden" name="regionArr"/>
        <input type="hidden" name="workArr"/>
    </form>


    <div class="region">
        <p>희망지역<span>(중복선택가능)</span></p>
        <div id="table">
            <ul>
                <li class="regionItem" no="0" gugunId=""><text>전국</text></li>
                <?for($i=0; $i<sizeof($regionList); $i++){?>
                    <li class="regionItem" no="<?=$regionList[$i]->sidoID?>" gugunId=""><text><?=$regionList[$i]->abbreviation?></text><div id="box">-</div></li>
                <?}?>
            </ul>
        </div>
    </div>

    <div class="jobClass">
        <p>직종선택</p>
        <div id="itemWrapper">
            <div class="item on" rel="tab1"><text>건축</text></div>
            <div class="item" rel="tab2"><text>기계설비</text></div>
            <div class="item" rel="tab3"><text>전기<br>통신<br>소방</text></div>
            <div class="item" rel="tab4"><text>인테리어</text></div>
            <div class="item" rel="tab5"><text>공통</text></div>
        </div>

        <div class="align_center">
            <a href="#" id="middleArea"></a>
        </div>

        <div class="jobTable">
            <div class="tabContent" id="tab1">
                <div class="jobItem" no="1"><text>콘크리트공</text></div>
                <div class="jobItem" no="2"><text>철근공</text></div>
                <div class="jobItem" no="3"><text>조적공</text></div>
                <div class="jobItem" no="4"><text>석공</text></div>
                <div class="jobItem" no="5"><text>타일공</text></div>
                <div class="jobItem" no="6"><text>수장공</text></div>
                <div class="jobItem" no="7"><text>방수공</text></div>
                <div class="jobItem" no="8"><text>비계공</text></div>
                <div class="jobItem" no="9"><text>미장공</text></div>
                <div class="jobItem" no="10"><text>견출공</text></div>
                <div class="jobItem" no="11"><text>도장공</text></div>
                <div class="jobItem" no="12"><text>부대토목공</text></div>
                <div class="jobItem" no="13"><text>형틀목공</text></div>
                <div class="jobItem" no="14"><text>지붕및홈통공</text></div>
                <div class="jobItem" no="45"><text>공사관리자</text></div>
                <div class="jobItem" no="46"><text>공무관리자</text></div>
                <div class="jobItem" no="47"><text>설계관리자</text></div>
            </div>

            <div class="tabContent" id="tab2">
                <div class="jobItem" no="15"><text>배관공</text></div>
                <div class="jobItem" no="16"><text>용접공</text></div>
                <div class="jobItem" no="57"><text>보온공</text></div>
                <div class="jobItem" no="17"><text>덕트설비공(공조,냉동,보일러)</text></div>
                <div class="jobItem" no="18"><text>위생설비공(변기,세면기,욕조)</text></div>
                <div class="jobItem" no="19"><text>소화설비공(소화전,스프링쿨러)</text></div>
                <div class="jobItem" no="20"><text>도비공(기계설치공)</text></div>
                <div class="jobItem" no="48"><text>공사관리자</text></div>
                <div class="jobItem" no="49"><text>공무관리자</text></div>
                <div class="jobItem" no="50"><text>설계관리자</text></div>
            </div>

            <div class="tabContent" id="tab3">
                <div class="jobItem" no="21"><text>송전공</text></div>
                <div class="jobItem" no="22"><text>배전공</text></div>
                <div class="jobItem" no="23"><text>내선공</text></div>
                <div class="jobItem" no="24"><text>플랜트공(제어공)</text></div>
                <div class="jobItem" no="25"><text>계장공</text></div>
                <div class="jobItem" no="26"><text>통신공</text></div>
                <div class="jobItem" no="27"><text>소방전기공</text></div>
                <div class="jobItem" no="28"><text>케이블포설공</text></div>
                <div class="jobItem" no="51"><text>공사관리자</text></div>
                <div class="jobItem" no="52"><text>공무관리자</text></div>
                <div class="jobItem" no="53"><text>설계관리자</text></div>
            </div>

            <div class="tabContent" id="tab4">
                <div class="jobItem" no="33"><text>도배공(장판)</text></div>
                <div class="jobItem" no="34"><text>목공(내장)</text></div>
                <div class="jobItem" no="35"><text>전기통신소방</text></div>
                <div class="jobItem" no="36"><text>타일공</text></div>
                <div class="jobItem" no="37"><text>미장공</text></div>
                <div class="jobItem" no="38"><text>간판공(실사)</text></div>
                <div class="jobItem" no="39"><text>냉난방시설공</text></div>
                <div class="jobItem" no="40"><text>샷시공</text></div>
                <div class="jobItem" no="41"><text>도장공</text></div>
                <div class="jobItem" no="54"><text>공사관리자</text></div>
                <div class="jobItem" no="55"><text>공무관리자</text></div>
                <div class="jobItem" no="56"><text>설계관리자</text></div>
            </div>

            <div class="tabContent" id="tab5">
                <div class="jobItem" no="42"><text>안전관리자</text></div>
                <div class="jobItem" no="43"><text>보통인부</text></div>
            </div>
        </div>
    </div>

    <div class="center" style="margin-top: 10vh;">
        <a href="#" id="next"></a>
    </div>

    <div class="footer">
        <<span>휴넵스/건설인</span>
        <br>
        <p>특허 제 10-1705485 호 / 사업자등록번호 461-14-00804</p>
        <p>직업정보제공사업신고번호 J1700020180005호 / 통신판매업신고 제 2018-대전유성-0240 호</p>
        <p>Tmail : huneps71@gmail.com / tel : </p>
        <br>
        <p>ⓒ 휴넵스 All rights reserved.</p>
    </div>
</div>
