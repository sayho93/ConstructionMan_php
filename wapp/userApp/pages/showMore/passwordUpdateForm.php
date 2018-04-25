<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-10
 * Time: 오후 5:25
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php"; ?>
<?
    $obj = new WebUser($_REQUEST);
    $id = $obj->webUser->id;
    $email = $obj->webUser->email;
?>
<script>
    $(document).ready(function(){
        setHeaderTitle("비밀번호 변경");
        let map = new sehoMap().put("id", "<?=$id?>").put("email", "<?=$email?>");

        $(".jUpdate").click(function(){
            let currentPw = $("#currentPw").val();
            let newPw = $("#newPw").val();
            let newPwConfirm = $("#newPwConfirm").val();
            map.put("currentPw", currentPw);

            if(newPw !== newPwConfirm){
                map.put("popText", "변경할 비밀번호가 일치하지 않습니다");
                showPop(map);
            }
            if(newPw.length < 6 || newPw.search(/[a-z]/i) < 0 || newPw.search(/[0-9]/) < 0){
                map.put("popText", "변경할 비밀번호 형식이 틀렸습니다");
                showPop(map);
                return;
            }
            map.put("password", newPw);
            let ajax = new AjaxSender(action + "WebUser.checkUserPwd", false, "json", map);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    let ajax = new AjaxSender(action + "WebUser.updateUserPwd", false, "json", map);
                    ajax.send(function(data){
                        if(data.returnCode === 1) showPop(map.put("popText", "비밀번호가 변경되었습니다"));
                    });
                }
                else showPop(map.put("popText", "현재 비밀번호가 일치하지 않습니다"));
            });
        });

        $(".jCancel").click(function(){window.history.back();});
    });
</script>

<div class="bg_search">
    <h3>현재 비밀번호</h3>
    <input type="text" id="currentPw" class="inputbox" placeholder="현재 비밀번호 입력">
</div>
<hr>
<hr class="mt10">
<div class="bg_search">
    <h3>새로운 비밀번호</h3>
    <input type="text" id="newPw" class="inputbox" placeholder="새로운 비밀번호 입력(8~16자리)">
    <input type="text" id="newPwConfirm" class="inputbox mt5" placeholder="비밀번호 재입력">
    <h5 class="left gray mt5">※ 비밀번호는 8~16자의 영문 대소문자, 숫자, 특수문자를 조합하여 설정해주세요.</h5>
</div>
<hr>
<div class="bg_btn">
    <button type="button" class="btn_blue btn_bigh jUpdate" style="width:calc(50% - 5px);">확인</button>
    <button type="button" class="btn_gray btn_bigh ml5 jCancel" style="width:calc(50% - 5px);"">취소</button>
</div>

<div class="popArea">   </div>

