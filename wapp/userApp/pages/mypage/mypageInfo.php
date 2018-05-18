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

    if($userInfo->type == "G"){
        $gearInfo = json_encode($userInfo->gearInfo);
    }

    $imgPath = $userInfo->imgPath;
?>

<script>
    var id = "<?=$userInfo->id?>";
    var type = "<?=$userInfo->type?>";
    var regionArr = [];

    $(document).ready(function(){

        $(".modifyForm").hide();
        $(".nm").val("<?=$userInfo->name?>");

        $(".modifyFormPhone").hide();
        $(".modifyFormPhoneNext").hide();
        $(".ph").val("<?=$userInfo->phone?>");

        //휴대폰 변경
        $(".jModPhone").click(function(){
            $(".modifyFormPhone").fadeIn();
            $(".alterModifyFormPhone").hide();
        });

        $(".jHideModifyFormPhone").click(function(){
            $(".alterModifyFormPhone").fadeIn();
            $(".modifyFormPhone").hide();
            $(".modifyFormPhoneNext").hide();

        });

        $(".jSendAuth").click(function(){
            var phone = $(".ph").val();

            var params = new sehoMap();
            params.put("phone", phone);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.sendAuth", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode == 1){
                    alert("인증번호를 입력해 주세요");
                    $(".modifyFormPhone").hide();
                    $(".modifyFormPhoneNext").fadeIn();
                }
                else
                    alert("인증문자 발송 실패! 관리자에게 연락 바랍니다.");
            });
        });

        $(".jSubmitPhone").click(function(){
            var phone = $(".ph").val();
            var id = "<?=$userInfo->id?>";
            var params =  new sehoMap().put("id", id).put("phone", phone);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.updatePhone", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.reload();
                }
            });
        });

        //이름 변경
        $(".jModName").click(function(){
            $(".modifyForm").fadeIn();
            $(".alterModifyForm").hide();
        });

        $(".jHideModifyForm").click(function(){
            $(".modifyForm").hide();
            $(".alterModifyForm").fadeIn();
        });

        $(".jSubmitName").click(function(){
            var inputName = $(".border").val();
            var params = new sehoMap().put("name", inputName);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.updateUserName", true, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.reload();
                }
            });
        });

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

        if(type === "M"){
            var workList = '<?=json_encode($workInfo)?>';
            var indexedWorkList = [];
            workList = JSON.parse(workList);

            for(var q = 0; q < workList.length; q++){
                indexedWorkList[workList[q].id] = workList[q].career;
            }

            initWork(workList);
        }

        function initWork(workList){
            var workArr = collectWorkId();
            workArr = workArr.join();
            getWorkList(workArr);

            for(var i=0; i<workList.length; i++){
                $(".listValue").eq(i + 2).find("[value='" + workList[i].career + "']").prop("selected", true);

                if(workList[i].id === 16){
                    $(".welderType").eq(1).val(workList[i].welderType);
                }
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


            var workArr = collectWorkId();
            workArr = workArr.join();
            getWorkList(workArr);

            $(".career").show();
            $(".jSubmitMan").show();
            // $(this).hide();


        });

        function getWorkList(workArr){
            $(".career").empty();
            $(".career").append("<p>경력정보 등록</p>")

            var param = new sehoMap().put("work", workArr);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.getWorkInfo", false, "json", param);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    // console.log(data.data);
                    for(var i=0; i<data.data.length; i++){

                        var template = $(".template").html();
                        if(data.data[i].id === 16) template = $(".specialTemplate").html();
                        template = template.replace(/#{no}/gi, data.data[i].id);
                        template = template.replace("#{text}", data.data[i].name);
                        var eee = $(".career").append(template);

                        console.log(eee.find('.listValue').eq(i).val(indexedWorkList[data.data[i].id]).prop("selected", true));

                        // inserted.find('option [value=' + indexedWorkList[data.data[i].id] + ']').prop("selected", true);
                    }

                }
                else{
                    alert("");
                }
            });
        }

        //경력정보 버튼 선택시
        // $(".jCareer").click(function(){
        //     var workArr = collectWorkId();
        //     workArr = workArr.join();
        //     getWorkList(workArr);
        //
        //     $(".career").show();
        //     $(".jSubmitMan").show();
        //     $(this).hide();
        // });

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
            if(regionArr == "") regionArr = "0";
            workArr = workArr.join();
            career = career.join();

            $("[name='regionArr']").val(regionArr);
            $("[name='workArr']").val(workArr);
            $("[name='careerArr']").val(career);

            console.log(regionArr);
            console.log(workArr);
            console.log(career);

            var params = $("[name='form']").serialize();
            $.ajax({
                url: "/action_front.php?cmd=WebUser.updateUserInfo",
                async: false,
                cache: false,
                dataType: "json",
                data: params,
                success: function(data){
                    console.log(data.data);
                    alert("변경되었습니다.");
                    location.href = "/userApp/pages/mypage/mypageMain.php";
                }
            });
        });


        ////////////////////end of manType
        var globalArray = [];

        if(type === "G"){
            var gearList = '<?=$gearInfo?>';
            gearList = JSON.parse(gearList);
            initGear(gearList);
        }

        function initGear(gearList){
            for(var i=0; i<gearList.length; i++){
                var params = new sehoMap().put("gearId", gearList[i].gearId);
                var ajax = new AjaxSender("/action_front.php?cmd=WebUser.getGearInfo", false, "json", params);
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        addForm(data.data.name, data.data.detail, data.data.size, data.data.id, gearList[i].attachment);
                    }
                });
            }
        }

        $(".tabContent").hide();
        $(".tabContent:first").show();


        $(".gearItem").click(function(){
            if($(this).hasClass("on"))
                $(this).removeClass("on");
            else {
                $(".gearItem").removeClass("on");
                $(this).addClass("on");
                var text = $(this).find("text").html();
                text = text.replace("<br>", "");
                setFirst(text);
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

        function collectAttachment(){
            var attachmentArr = $(".attachmentItem.on");
            var toRet = [];
            for(var i=0; i<attachmentArr.length; i++){
                var value = attachmentArr.eq(i).find("text").html();
                toRet.push(value);
            }
            return toRet;
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
                            alert("선택할 항목이 없습니다.");
                            setSecond("-");
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
            $(".attachment").append("<p>어태치먼트</p>");
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

        function setFirst(text){$(".first").html(text);}
        function setSecond(text){$(".second").html(text);}
        function setThird(text){$(".third").html(text);}

        function GearBody(nid, nattr){
            this.id = nid;
            this.attach = nattr;
            this.name = "";
            this.detail = "";
            this.size = "";
        }

        $(".addGear").click(function(){
            showForm();
        });

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

        function isDuplicateGear(gid){
            for(var e = 0; e < globalArray.length; e++){
                if(globalArray[e].id == gid) return true;
            }
            return false;
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

        function convert(selector, marks, contents){
            var origin = $(selector).html();
            for(var e = 0; e < marks.length; e++){
                origin = origin.replace(marks[e], contents[e]);
            }

            return origin;
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

        $(".jSubmitGear").click(function(){
            var regionArr = collectGugunId();
            var gearInfo = JSON.stringify(globalArray);

            regionArr = regionArr.join();

            $("[name='regionArr']").val(regionArr);
            $("[name='gearInfo']").val(gearInfo);

            console.log(regionArr);

            var params = $("[name='form']").serialize();
            $.ajax({
                url: "/action_front.php?cmd=WebUser.updateUserInfo",
                async: false,
                cache: false,
                dataType: "json",
                data: params,
                success: function(data){
                    console.log(data.data);
                    alert("변경되었습니다.");
                    location.href = "/userApp/pages/mypage/mypageMain.php";
                }
            });
        })

        //--------------------------img
        $(".jImg").click(function(){
            $(".popHeader").html("프로필 사진 설정");
            $(".popBody").empty();
            var template = $(".photoListTemplate").html();
            template = template.replace("#{type}", "1");
            template = template.replace("#{text}", "기본 이미지로 변경");
            $(".popBody").append(template);
            template = $(".photoListTemplate").html();
            template = template.replace("#{type}", "2");
            template = template.replace("#{text}", "이미지 선택");
            $(".popBody").append(template);
            $(".popBG").show();
        });

        $(".popBody").niceScroll({autohidemode:'false'});

        $(document).on("click", ".photoItem", function(){
            var type = $(this).attr("type");
            if(type == "1"){
                var params = new sehoMap().put("id", id);
                var ajax = new AjaxSender("/action_front.php?cmd=WebUser.deleteImg", true, "json", params);
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        location.reload();
                    }
                });
            }
            else if(type == "2"){
                location.href = "pickle://cropImage";
            }

            $(".popBG").hide();
        });

    });

    function recvImageMeta(imagePath){
        var params = new sehoMap().put("imgPath", imagePath);
        var ajax = new AjaxSender("/action_front.php?cmd=WebUser.updateUserImg", true, "json", params);
        ajax.send(function(data){
            if(data.returnCode === 1){
                location.reload();
            }
        });
    }


</script>

<div class="template" style="display:none;">
    <div class="list">
        <div class="jobItem jobItemC" no="#{no}"><text>#{text}</text></div>
        <select class="listValue" no="#{no}">
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
        <select class="listValue" no="#{no}">
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

<div class="photoListTemplate" style="display: none;">
    <div class="photoItem" type="#{type}"><span>#{text}</span></div>
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
    <div class="listItem" no="#{no}" parentId="#{prt}"><span>#{text}</span></div>
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




<div class="mypageHeader">
    <h2>개인정보</h2>
    <a class="tool_left"><img src="../../img/btn_prev.png" class="back_btn jBack"/></a>
<!--    <a class="tool_right"><img src="../../img/btn_confirm.png" class="ok_btn"/></a>-->

    <div style="text-align: center">
        <? if($imgPath == ""){ ?>
            <img src="../../img/person_head.png" class="profileImg"/>
        <? }else{ ?>
            <img src="<?=$obj->IMG_DIR.$imgPath?>" class="profileImg"/>
        <? } ?>
        <br>
        <img src="../../img/btn_photo.png" class="img_btn jImg" style="margin-bottom: 2vh">
    </div>
</div>

<div class="mypageTitleHeader">
    <table width="100%" height="100%">
        <tr class="tableRowInfo">
            <td width="20%"><a class="subject">이름</a></td>
            <td width="70%" class="alterModifyForm"><a class="content"><?=$userInfo->name?></a></td>
            <td width="70%" class="modifyForm"><input type="text" class="border nm" value="<?=$userInfo->name?>" /></td>
            <td width="10%" class="alterModifyForm"><img src="../../img/btn_edit.png" class="mod_btn jModName" style="float: right"></td>
            <td width="10%" class="modifyForm">
                <input type="button" class="jSubmitName" value="확인" style="margin-top: 2vh!important;"/>
                <input type="button" class="jHideModifyForm" value="취소" style="margin-top: 2vh!important;"/>
            </td>
        </tr>
        <tr class="tableRowInfo">
            <td><a class="subject">전화번호</a></td>
            <td class="alterModifyFormPhone"><a class="content"><?=$userInfo->phone?></a></td>
            <td width="10%" class="alterModifyFormPhone"><img src="../../img/btn_auth.png" class="auth_btn jModPhone" style="float: right"></td>
            <td width="70%" class="modifyFormPhone"><input type="number" class="border ph" /></td>
            <td width="70%" class="modifyFormPhoneNext"><input type="number" class="border" placeholder="인증번호" /></td>
            <td width="10%" class="modifyFormPhone">
                <input type="button" class="jSendAuth" value="전송" style="margin-top: 2vh!important;"/>
                <input type="button" class="jHideModifyFormPhone" value="취소" style="margin-top: 2vh!important;"/>
            </td>
            <td width="10%" class="modifyFormPhoneNext">
                <input type="button" class="jSubmitPhone" value="확인" style="margin-top: 2vh!important;"/>
                <input type="button" class="jHideModifyFormPhone" value="취소" style="margin-top: 2vh!important;"/>
            </td>
        </tr>
    </table>
</div>

<?if($_REQUEST["type"] == "M"){?>

<form name="form">
    <input type="hidden" name="type" value="M"/>
    <input type="hidden" name="regionArr" value=""/>
    <input type="hidden" name="workArr" value=""/>
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
            <div class="item" rel="tab5"><text>보통인부<br/>안전관리자</text></div>
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

<!--    <input type="button" class="end jCareer" value="경력정보 선택" style="margin-top: 2vh!important;"/>-->

    <div class="career">
        <p>경력정보 등록</p>
    </div>

    <input type="button" class="end jSubmitMan" value="저장하기" style="margin-top: 2vh!important;"/>
    <?}else if($_REQUEST["type"] == "G"){?>
    <form name="form">
        <input type="hidden" name="type" value="G"/>
        <input type="hidden" name="regionArr" value=""/>
        <input type="hidden" name="gearInfo"/>
    </form>

    <div class="mypageBody">
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

        <input type="button" class="end jSubmitGear" value="저장하기" style="margin-top: 2vh!important;"/>
    <?}?>

    <div class="footer">
        <span>휴넵스/건설인</span>
        <br>
        <p>특허 제 10-1705485 호 / 사업자등록번호 461-14-00804</p>
        <p>직업정보제공사업신고번호 J1700020180005호 / 통신판매업신고 제 2018-대전유성-0240 호</p>
        <p>mail : huneps71@gmail.com / tel : </p>
        <br>
        <p>ⓒ 휴넵스 All rights reserved.</p>
    </div>

</div>

