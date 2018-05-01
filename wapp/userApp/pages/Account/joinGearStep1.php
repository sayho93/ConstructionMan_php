<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 25.
 * Time: PM 2:04
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
$obj = new WebUser($_REQUEST);
$regionList = $obj->getRegionList();
$regionList = json_decode($regionList)->data;
?>

<script>
    var regionArr = [];
    $(document).ready(function(){
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
                    $(".popHeader").html("지역 선택");

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

        $(document).on("click", ".regionListItem", function(){
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


        $(".gearItem").click(function(){
            if($(this).hasClass("on"))
                $(this).removeClass("on");
            else {
                $(".gearItem").removeClass("on");
                $(this).addClass("on");
                var text = $(this).find("text").html();
                // getGearOption1(text);
                setFirst(text);
            }
        });

        $(".second").click(function(){
            var name = $(".gearItem.on").find("text").html().replace("<br>", "");
            getGearOption1(name);
        });

        $(".attachmentItem").click(function(){
            if($(this).hasClass("on"))
                $(this).removeClass("on");
            else{
                $(".attachmentItem").removeClass("on");
                $(this).addClass("on");
            }
        });

        function getGearOption1(name){
            $(".popBody").empty();
            var params = new sehoMap().put("name", name);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.getGearOption1", true, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    for(var i=0; i<data.data.length; i++){
                        if(data.data[i].detail == "-") break;
                        else{
                            var template = $(".listTemplateForGear1").html();
                            template = template.replace("#{name}", name);
                            template = template.replace("#{detail}", data.data[i].detail);
                            template = template.re
                            $(".popBody").append(template);
                        }
                    }
                    $(".popBG").show();
                }
                else{
                    alert("");
                }
            });
        }

        function getGearOption2(name){

        }

        function getAttachment(){

        }

        function setFirst(text){$(".first").html(text);}
        function setSecond(text){$(".second").html(text);}
        function setThird(text){$(".third").html(text);}

    });

</script>


<div class="header">
    <h2>회원가입</h2>
</div>

<div class="popBG" style="display: none;">
    <div class="popIcon jClose"></div>
    <div class="popArea">
        <div class="popHeaderWrap">
            <div class="popHeader">

            </div>
        </div>
        <div class="popBody">

        </div>
    </div>
</div>

<div class="listTemplate" style="display: none;">
    <div class="listItem regionListItem" no="#{no}" parentId="#{prt}"><span>#{text}</span></div>
</div>

<div class="listTemplateForGear1" style="display: none">
    <div class="listItem gearItem1" name="#{name}" detail="#{detail}"><span>#{text}</span></div>
</div>


<div class="body">
    <div class="region">
        <p>희망지역<span>(중복선택가능)</span></p>
        <div id="table">
            <ul>
                <?for($i=0; $i<sizeof($regionList); $i++){?>
                    <li class="regionItem" no="<?=$regionList[$i]->sidoID?>" gugunId=""><text><?=$regionList[$i]->abbreviation?></text><div id="box">-</div></li>
                <?}?>
            </ul>
        </div>
    </div>

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
            <span class="first"></span>
            <span class="second"></span>
            <span class="third"></span>
        </div>

        <!--<input type="button" value="가입하기"/>-->
    </div>

    <div class="attachment">
        <p>어태치먼트</p>
        <div class="attachmentItem on"><text>뿌레카</text></div>
        <div class="attachmentItem"><text>집게</text></div>
        <div class="attachmentItem"><text>니퍼</text></div>
        <div class="attachmentItem"><text>채바가지</text></div>
        <div class="attachmentItem"><text>딱다구리</text></div>
    </div>


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

    </div>

    <input class="end" type="button" value="가입하기"/>

    <div class="footer">
        <span>휴넵스/건설인</span>
        <br>
        <p>대표 : 이화수 / 사업자등록번호 : 111-222-3333333</p>
        <p>주소 : 대전광역시 유성구 봉명동 1111</p>
        <p>TEL : 1644-1111 / MAIL : geonseolin@geonseolin.com</p>
        <br>
        <p>ⓒ휴넵스 All rights reserved.</p>
    </div>
</div>

