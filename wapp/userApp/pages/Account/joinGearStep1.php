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
$regionList = $obj->getSidoList();
$regionList = json_decode($regionList)->data;
?>

<script>
    var regionArr = [];
    $(document).ready(function(){
        $(".jBack").click(function(){history.go(-1)});

        $(".popBody").niceScroll({autohidemode:'false'});

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

                    var template = $(".listTemplate").html();
                    template = template.replace("#{no}", data.data[0].sidoID * -1);
                    template = template.replace("#{text}", "전체");
                    template = template.replace("#{prt}", data.data[0].sidoID);
                    $(".popBody").append(template);

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

        function collectAttachment(){
            var attachmentArr = $(".attachmentItem.on");
            var toRet = [];
            for(var i=0; i<attachmentArr.length; i++){
                var value = attachmentArr.eq(i).find("text").html();
                toRet.push(value);
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

            $(".first").html("");
            $(".second").html("");
            $(".third").html("");
            $(".third").attr("no", "");
            $(".attachment").empty();

            if($(this).hasClass("on"))
                $(this).removeClass("on");
            else {
                $(".gearItem").removeClass("on");
                $(this).addClass("on");
                var text = $(this).find("text").html();
                text = text.replace("<br>", "");
                setFirst(text);
                $(".second").trigger("click");
            }
        });

        $(".second").click(function(){
            var name = $(".gearItem.on").find("text").html().replace("<br>", "");
            getGearOption1(name);
        });

        $(".addGear").click(function(){
            showForm();
        });

        $(document).on("click", ".gearItem1", function(){
            var detail = $(this).attr("detail");
            var name = $(this).attr("name");
            setSecond(detail);
            $(".popBG").hide();
            $(".third").trigger("click");
        });

        $(".third").click(function(){
            var name = $(".gearItem.on").find("text").html().replace("<br>", "");
            var detail = $(".second").html();
            getGearOption2(name, detail);
        });

        $(document).on("click", ".gearItem2", function(){
            var id = $(this).attr("no");
            var size = $(this).attr("size");
            var attachment = $(this).attr("attachment");
            $(".third").attr("no", id);
            setThird(size);
            $(".popBG").hide();
            setAttachment(attachment);
        });

        $("#prevt").click(function(){
            history.go(-1);
        });

        $(document).on("click", ".attachmentItem", function(){
            if($(this).hasClass("on"))
                $(this).removeClass("on");
            else{
                $(this).addClass("on");
            }
        });

        $(document).on("click", ".delGearList", function(){
            globalArray.splice($(this).attr("no"), 1);
            notifyDataSetChanged();
        });

        function isDuplicateGear(gid){
            for(var e = 0; e < globalArray.length; e++){
                if(globalArray[e].id == gid) return true;
            }
            return false;
        }

        function getGearOption1(name){
            $(".popBody").empty();
            var params = new sehoMap().put("name", name);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.getGearOption1", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    $(".popHeader").html("옵션 선택");
                    for(var i=0; i<data.data.length; i++){
                        if(data.data[i].detail == "-") {
                            // alert("선택할 항목이 없습니다.");
                            setSecond("-");
                            $(".third").trigger("click");
                            return;
                        }
                        else{
                            var template = $(".listTemplateForGear1").html();
                            template = template.replace("#{name}", name);
                            template = template.replace("#{detail}", data.data[i].detail);
                            template = template.replace("#{text}", data.data[i].detail);
                            $(".popBody").append(template);
                        }
                    }
                    $(".popBG").show();
                }
            });
        }

        function getGearOption2(name, detail){
            $(".popBody").empty();
            var params = new sehoMap().put("name", name).put("detail", detail);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.getGearOption2", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    $(".popHeader").html("옵션 선택");
                    for(var i=0; i<data.data.length; i++){
                        if(data.data[i].size == "-"){
                            alert("선택할 항목이 없습니다.");
                            setThird("-");
                            $(".third").attr("no",data.data[i].id);
                            return;
                        }
                        else{
                            var template = $(".listTemplateForGear2").html();
                            template = template.replace("#{no}", data.data[i].id);
                            template = template.replace("#{size}", data.data[i].size);
                            template = template.replace("#{attachment}", data.data[i].attachment);
                            template = template.replace("#{text}", data.data[i].size);
                            $(".popBody").append(template);
                        }
                    }
                    $(".popBG").show();
                }
            });
        }

        function setAttachment(attachment){
            var arrAttachment = attachment.split(",");
            $(".attachment").empty();
            if(arrAttachment[0] != "-") $(".attachment").append("<p>어태치먼트</p>");
            for(var i=0; i<arrAttachment.length; i++){
                console.log(arrAttachment[i]);
                if(arrAttachment[i] == "-"){
                    return;
                }
                else{
                    var template = $(".attachmentTemplate").html();
                    template = template.replace("#{text}", arrAttachment[i]);
                    $(".attachment").append(template);
                }
            }
        }

        function GearBody(nid, nattr){
            this.id = nid;
            this.attach = nattr;
            this.name = "";
            this.detail = "";
            this.size = "";
        }

        var globalArray = [];

        function resetForm(){
            $(".gearItem").removeClass("on");
            setFirst("");
            setSecond("");
            setThird("");
            $(".third").attr("no", "");
        }

        function showForm(){
            resetForm();
            $(".gearWrapper").fadeIn();
        }

        function hideForm(){
            $(".gearWrapper").fadeOut();
        }

        $(".jAdd").click(function(){
            var name = $(".first").html();
            var detail = $(".second").html();
            var size = $(".third").html();
            var no = $(".third").attr("no");
            var attachment = collectAttachment();
            attachment = attachment.join();

            console.log(name + "::" + detail + "::" + size + "::" + no + "::" + attachment);

            var added = addForm(name, detail, size, no, attachment);
            if(added) hideForm();
        });

        function notifyDataSetChanged(){
            var gearList = $(".gearList");
            gearList.empty();
            for(var e = 0; e < globalArray.length; e++){
                var tmp = gearList.html();
                var toAdd = convert(".gearListItemTemplate",
                    ["#{number}", "#{name}", "#{detail}", "#{size}", "#{attachment}"],
                    [e, globalArray[e].name, globalArray[e].detail, globalArray[e].size, globalArray[e].attach]
                );
                gearList.html(tmp + toAdd)
            }
        }

        function addForm(name, detail, size, id, att){
            if(isDuplicateGear(id)){
                alert("중복된 장비가 존재합니다.");
                return false;
            }

            var gBody = new GearBody(id, att);
            gBody.name = name;
            gBody.detail = detail;
            gBody.size = size;
            globalArray.push(gBody);
            notifyDataSetChanged();
            return true;
        }

        function convert(selector, marks, contents){
            var origin = $(selector).html();
            for(var e = 0; e < marks.length; e++){
                origin = origin.replace(marks[e], contents[e]);
            }

            return origin;
        }

        function setFirst(text){$(".first").html(text);}
        function setSecond(text){$(".second").html(text);}
        function setThird(text){$(".third").html(text);}

        function getPushKey(){
            location.href = "pickle://getPushKey";
        }

        $(".end").click(function(){
            var regionArr = collectGugunId();
            var gearInfo = JSON.stringify(globalArray);
            regionArr = regionArr.join();
            $("[name='regionArr']").val(regionArr);
            $("[name='gearInfo']").val(gearInfo);

            var pushKey = getPushKey();
        });
    });



    function getPushKeyCallBack(pushKey){
        console.log("getPushKeyCallBack called :::::::::::::::::::::::::");
        $("[name='pushKey']").val(decodeURI(pushKey));
        var params = $("[name='form']").serialize();
        $.ajax({
            url: "/action_front.php?cmd=WebUser.joinUser",
            async: false,
            cache: false,
            dataType: "json",
            data: params,
            success: function(data){
                console.log(data.data);
                location.href = "/userApp/pages/Account/joinComplete.php";
                // alert("가입 완료되었습니다.");
                // location.href = "/userApp/pages/search/searchMain.php";
            }
        });
    }

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

            </div>
        </div>
        <div class="popBody">

        </div>
    </div>
</div>

<div class="gearListItemTemplate" style="display: none;">
    <div>
        <p><text style="color:#00BCD4;">■</text> #{name}[#{detail}] - #{size} /
            <text style="color: #777777; font-size: 0.5em">#{attachment}</text>
            <a href="#" no="#{number}" class="delGearList"><img src="../../img/btn_del.png" width="20px"/></a>
        </p>
    </div>
</div>

<div class="listTemplate" style="display: none;">
    <div class="listItem regionListItem" no="#{no}" parentId="#{prt}"><span>#{text}</span></div>
</div>

<div class="listTemplateForGear1" style="display: none">
    <div class="listItem gearItem1" name="#{name}" detail="#{detail}"><span>#{text}</span></div>
</div>

<div class="listTemplateForGear2" style="display: none">
    <div class="listItem gearItem2" no="#{no}" size="#{size}" attachment="#{attachment}"><span>#{text}</span></div>
</div>

<div class="attachmentTemplate" style="display: none">
    <div class="attachmentItem"><text>#{text}</text></div>
</div>

<div class="body">
    <form name="form">
        <input type="hidden" name="account" value="<?=$_REQUEST["account"]?>"/>
        <input type="hidden" name="password" value="<?=$_REQUEST["password"]?>"/>
        <input type="hidden" name="name" value="<?=$_REQUEST["name"]?>"/>
        <input type="hidden" name="age" value="<?=$_REQUEST["age"]?>"/>
        <input type="hidden" name="sex" value="<?=$_REQUEST["sex"]?>"/>
        <input type="hidden" name="residence" value="<?=$_REQUEST["residence"]?>"/>
        <input type="hidden" name="phone" value="<?=$_REQUEST["phone"]?>"/>
        <input type="hidden" name="type" value="G"/>
        <input type="hidden" name="regionArr"/>
        <input type="hidden" name="gearInfo"/>
    </form>

    <div class="region">
        <p>희망지역<span>(중복선택가능)</span></p>
        <div id="table">
            <ul>
                <?for($i=0; $i<5; $i++){?>
                    <li class="regionItem" no="<?=$regionList[$i]->sidoID?>" gugunId=""><text><?=$regionList[$i]->abbreviation?></text><div id="box">-</div></li>
                <?}?>

            </ul>
            <ul>
                <?for($i=5; $i<10; $i++){?>
                    <li class="regionItem" no="<?=$regionList[$i]->sidoID?>" gugunId=""><text><?=$regionList[$i]->abbreviation?></text><div id="box">-</div></li>
                <?}?>
            </ul>
            <ul>
                <?for($i=10; $i<15; $i++){?>
                    <li class="regionItem" no="<?=$regionList[$i]->sidoID?>" gugunId=""><text><?=$regionList[$i]->abbreviation?></text><div id="box">-</div></li>
                <?}?>
            </ul>
            <ul>
                <li class="regionItem" no="<?=$regionList[15]->sidoID?>" gugunId=""><text><?=$regionList[15]->abbreviation?></text><div id="box">-</div></li>
<!--                <li class="regionItem" no="0" gugunId=""><text>전국</text></li>-->
            </ul>
        </div>
    </div>

    <div class="addGearForm">
        <div style="text-align: center; vertical-align:middle;border: 1px solid #777777;">
            <p class="addGear">+ 장비추가</p>
        </div>
        <div class="gearList">
        </div>
    </div>

    <div class="gearWrapper" style="display:none;">
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
                <span class="third" no=""></span>
            </div>
        </div>

        <div class="attachment" str="">
            <p>어태치먼트</p>
        </div>

        <input class="recButton jAdd" type="button" value="추가"/>

    </div>

    <input class="end" type="button" value="가입하기"/>

    <div class="footer">
        <span>휴넵스/건설인</span>
        <br>
        <p>특허 제 10-1705485 호 / 사업자등록번호 461-14-00804</p>
        <p>직업정보제공사업신고번호 J1700020180005호 / 통신판매업신고 제 2018-대전유성-0240 호</p>
        <p>mail : huneps71@gmail.com / Tel. 010-9719-1105 </p>
        <br>
        <p>ⓒ 휴넵스 All rights reserved.</p>
    </div>
</div>

