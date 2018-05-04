<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 5. 4.
 * Time: PM 3:17
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
    $obj = new WebUser($_REQUEST);
    $userInfo = $obj->getUserInfo();
    $userInfo = json_decode($userInfo)->data;
    $regionInfo = $userInfo->userRegion;
    $workInfo = $userInfo->workInfo;
    $name = $userInfo->name;

    $regionList = $obj->getSidoList();
    $regionList = json_decode($regionList)->data;
?>

<script>
    var regionArr = [];

    $(document).ready(function(){
        var userRegion = '<?=json_encode($regionInfo)?>';
        var userWork = '<?=json_encode($workInfo)?>';
        userRegion = JSON.parse(userRegion);
        userWork = JSON.parse(userWork);

        //유저 지역정보 표시
        if(userRegion != null){
            for(var i=0; i<userRegion.length; i++){
                if(userRegion[i].gugunId === 0){
                    $(".regionItem[no='0']").addClass("on");
                }
                else{
                    var target = $(".regionItem[no='" + userRegion[i].sidoId + "']");
                    target.addClass("on");
                    target.attr("gugunId", userRegion[i].gugunId);
                    target.find("#box").html(userRegion[i].gugunTxt);
                }
            }
        }

        //유저 직종 표시
        console.log(userWork);
        if(userWork != null){
            for(var i=0; i<userWork.length; i++){
                var target = $(".jobItem[no='" + userWork[i].id + "']");
                target.addClass("on");
            }
        }


        $(".jBack").click(function(){
            history.go(-1);
        });

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

        function getWorkList(workArr){
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

        //경력정보 버튼 선택시
        $(".jCareer").click(function(){
            var workArr = collectWorkId();
            workArr = workArr.join();
            getWorkList(workArr);

            $(".career").show();
            $(".jSubmitMan").show();
            $(this).hide();
        });

        function collectCareer(){
            var careerArr = $(".list");
            var toRet = [];

            for(var i=2; i<careerArr.length; i++){
                var no = $(".jobItemC").eq(i).attr("no");
                console.log(no);
                var value = $(".listValue").eq(i).val();
                toRet.push(value);

                if(no == "16"){
                    $("[name='welderType']").val($(".welderType").eq(1).val());
                }
            }
            return toRet;
        }

        $(".jSubmitMan").click(function(){
            var regionArr = collectGugunId();
            var workArr = collectWorkId();
            var career = collectCareer();

            regionArr = regionArr.join();
            workArr = workArr.join();
            career = career.join();

            $("[name='regionArr']").val(regionArr);
            $("[name='workArr']").val(workArr);
            $("[name='careerArr']").val(career);

            console.log(regionArr);
            console.log(workArr);
            console.log(career);
        });


        ////////////////////end of manType

        
    });
</script>

<div class="template" style="display:none;">
    <div class="list">
        <div class="jobItem jobItemC" no="#{no}"><text>#{text}</text></div>
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
        <div class="jobItem jobItemC" no="#{no}"><text>#{text}</text></div>
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

<div class="mypageHeader">
    <h2>개인정보</h2>
    <a class="tool_left"><img src="../../img/btn_prev.png" class="back_btn jBack"/></a>
<!--    <a class="tool_right"><img src="../../img/btn_confirm.png" class="ok_btn"/></a>-->

    <div style="text-align: center">
        <img src="../../img/person_head.png" class="profileImg"/>
        <br>
        <img src="../../img/btn_photo.png" class="img_btn" style="margin-bottom: 2vh">
    </div>
</div>

<div class="mypageTitleHeader">
    <table width="100%" height="100%">
        <tr class="tableRowInfo">
            <td width="20%"><a class="subject">이름</a></td>
            <td width="70%"><a class="content"><?=$name?></a></td>
            <td width="10%"><img src="../../img/btn_edit.png" class="mod_btn" style="float: right"></td>
        </tr>
        <tr class="tableRowInfo">
            <td><a class="subject">전화번호</a></td>
            <td><a class="content"><?=$userInfo->phone?></a></td>
            <td></td>
        </tr>
    </table>
</div>

<?if($_REQUEST["type"] == "M"){?>

<form name="form">
    <input type="hidden" name="regionArr"/>
    <input type="hidden" name="workArr"/>
    <input type="hidden" name="careerArr" value=""/>
    <input type="hidden" name="welderType" value=""/>
</form>

<div class="mypageBody">
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

    <input type="button" class="end jCareer" value="경력정보 선택" style="margin-top: 2vh!important;"/>

    <div class="career" style="display: none;">
        <p>경력정보 등록</p>
    </div>
    <?}else if($_REQUEST["type"] == "G"){?>
<!--        TODO 장비타입 -->
    <?}?>

    <input type="button" class="end jSubmitMan" value="저장하기" style="margin-top: 2vh!important; display: none;"/>

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

