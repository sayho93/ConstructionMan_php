<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-10
 * Time: 오전 11:29
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php"; ?>
<?
    $obj = new WebUser($_REQUEST);
    $user = $obj->webUser;
?>
<script>
    $(document).ready(function(){
        setHeaderTitle("마이페이지");
        let map = new sehoMap().put("id", "<?=$user->id?>");

        $(".jUpdateName").click(function(){
            let name = $("#name").val();
            map.put("name", name);
            let ajax = new AjaxSender(action + "WebUser.updateUserName", false, "json", map);
            ajax.send(function(data){
                $("#popup1").hide();
                $(".nameArea").html(data.data.name);
            });
        });

        $(".jUpdatePhone").click(function(){
            map.put("phone", $("#phone").val());
            let ajax = new AjaxSender(action + "WebUser.updatePhone", false, "json", map);
            ajax.send(function(data){
                $("#popup2").hide();
                $(".phoneArea").html(data.data.phone);
            });
        });
    });
</script>

<div class="myid">
    <p class="t14px">ID(이메일)</p>
    <p class="id"><?=$user->email?></p>
</div>

<hr class="mt10">
<div class="morelist" onclick="location.href='/userApp/pages/showMore/passwordUpdateForm.php';">비밀번호 변경</div>
<div class="morelist" onclick="document.getElementById('popup1').style.display='block';">이름변경 <div class="t14px f_r gray nameArea"><?=$user->name?></div></div>
<div class="morelist" onclick="document.getElementById('popup2').style.display='block';">핸드폰 번호 변경 <div class="t14px f_r gray phoneArea"><?=$user->phone?></div></div>

<div id="popup1" class="popup_layer">
    <div class="bg">
        <div class="type01">
            <p class="t14px center mt10">성명을 입력해 주세요</p>
            <div class="p5"><input type="text" id="name" class="inputbox" style="width:80%;"></div>
        </div>
        <div class="clearfix">
            <button type="button" class="btn_type02 jUpdateName">확인</button>
            <button type="button" class="btn_type02 line0" onclick="document.getElementById('popup1').style.display='none';">취소</button>
        </div>
    </div>
</div>

<div id="popup2" class="popup_layer">
    <div class="bg">
        <div class="type01">
            <p class="t14px center mt10">핸드폰 번호를 입력해 주세요</p>
            <div class="p5"><input type="text" id="phone" class="inputbox" style="width:80%;"></div>
        </div>
        <div>
            <button type="button" class="btn_type02 jUpdatePhone">확인</button>
            <button type="button" class="btn_type02 line0" onclick="document.getElementById('popup2').style.display='none';">취소</button>
        </div>
    </div>
</div>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/footer.php" ;?>