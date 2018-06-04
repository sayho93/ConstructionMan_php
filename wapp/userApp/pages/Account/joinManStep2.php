<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 26.
 * Time: PM 4:24
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>

<script>
    $(document).ready(function(){
        $(".jBack").click(function(){history.go(-1)});
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
                    if($(".welderType").eq(1).val() == ""){
                        alert("용접공 종류를 입력해 주세요");
                        return;
                    }
                    $("[name='welderType']").val($(".welderType").eq(1).val());
                }
            }
            return toRet;
        }

        $(".end").click(function(){
            $("[name='careerArr']").val(collectCareer());
            var pushKey = getPushKey();


        });

        function getPushKey(){
            location.href = "pickle://getPushKey";
        }


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
                if(data.returnCode === 1){
                    console.log(data.data);
                    location.href = "/userApp/pages/Account/joinComplete.php";
                }
                else{
                    alert("가입 실패!");
                }

                // alert("가입 완료되었습니다.");
                // location.href = "/userApp/pages/search/searchMain.php";
            }
        });
    }
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
    <a class="tool_left"><img src="../../img/btn_prev.png" class="back_btn jBack"/></a>
    <h2>회원가입</h2>
</div>

<div class="body">
    <form name="form">
        <input type="hidden" name="type" value="M"/>
        <input type="hidden" name="account" value="<?=$_REQUEST["account"]?>"/>
        <input type="hidden" name="password" value="<?=$_REQUEST["password"]?>"/>
        <input type="hidden" name="name" value="<?=$_REQUEST["name"]?>"/>
        <input type="hidden" name="age" value="<?=$_REQUEST["age"]?>"/>
        <input type="hidden" name="residence" value="<?=$_REQUEST["residence"]?>"/>
        <input type="hidden" name="phone" value="<?=$_REQUEST["phone"]?>"/>
        <input type="hidden" name="regionArr" value="<?=$_REQUEST["regionArr"]?>"/>
        <input type="hidden" name="workArr" value="<?=$_REQUEST["workArr"]?>"/>
        <input type="hidden" name="careerArr" value=""/>
        <input type="hidden" name="welderType" value=""/>
        <input type="hidden" name="pushKey" value=""/>
    </form>

    <div class="career">
        <p>현장정보 등록</p>
    </div>

    <div style="text-align: center">
        <input class="end" type="button" value="가입하기"/>
    </div>

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
