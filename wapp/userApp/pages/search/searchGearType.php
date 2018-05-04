<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 23.
 * Time: PM 5:06
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<script>
    $(document).ready(function(){
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

        $(".jClose").click(function(){
            $(".popBG").hide();
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

        function collectAttachement(){
            var attachmentArr = $(".attachmentItem.on");
            var toRet = [];
            for(var i=0; i<attachmentArr.length; i++){
                var value = attachmentArr.eq(i).find("text").html();
                toRet.push(value);
            }
            return toRet;
        }

        $("#next").click(function(){
            var gearId = $(".third").attr("no");
            var attachmentArr = collectAttachement();
            attachmentArr = attachmentArr.join();
            $("[name='gearId']").val(gearId);
            $("[name='attachment']").val(attachmentArr);

            var str = $("[name='form']").serialize();

            location.href = "/userApp/pages/search/searchGear.php?" + str;

        });
    });
</script>

<div class="header">
    <img src="../../img/top_logo.png" class="headerLogo">
    <a class="tool_left"><img src="../../img/btn_drawer.png" class="leftLogo"/></a>
    <a class="tool_right"><img src="../../img/btn_phone.png" class="rightLogo"/></a>
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
        <input type="hidden" name="gearId"/>
        <input type="hidden" name="attachment"/>
    </form>

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

    <div class="attachment">
        <p>어태치먼트</p>
    </div>

    <br/>

    <div class="center" style="margin-top: 20vh;">
        <a href="#" id="next"></a>
    </div>

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

