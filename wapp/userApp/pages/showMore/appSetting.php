<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-13
 * Time: 오전 9:50
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
        setHeaderTitle("설정");
        let map = new sehoMap().put("id", "<?=$user->id?>");

        $(".jPush").click(function(){
            let ajax = new AjaxSender(action + "WebUser.updatePushFlag", false, "json", map);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    if(data.data.flagPush === 1)toggleJClass(".jPush", "switch_on", "switch");
                    else toggleJClass(".jPush", "switch", "switch_on");
                }
            });
        });

        $(".jAlarm").click(function(){
            let ajax = new AjaxSender(action + "WebUser.updateAlarmFlag", false, "json", map);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    if(data.data.flagAlarm === 1) toggleJClass(".jAlarm", "switch_on", "switch");
                    else toggleJClass(".jAlarm", "switch", "switch_on");
                }
            });
        });

        $(".jGesture").click(function(){
            let ajax = new AjaxSender(action + "WebUser.updateGestureFlag", false, "json", map);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    if(data.data.flagGesture === 1) toggleJClass(".jGesture", "switch_on", "switch")
                    else toggleJClass(".jGesture", "switch", "switch_on")
                }
            });
        });
    });
</script>

<div class="list flexbox">
    푸시 메시지 <div class="flex1 right"><button class="<?=$user->flagPush == "0" ? "switch_on" : "switch" ?> f_r jPush"></button></div>
</div>
<div class="list flexbox">
    출퇴근 알람 <div class="flex1 right"><button class="<?=$user->flagAlarm == "0" ? "switch_on" : "switch" ?> f_r jAlarm"></button></div>
</div>
<div class="list flexbox">
    제스처 문 열기 <div class="flex1 right"><button class="<?=$user->flagGesture == "0" ? "switch_on" : "switch" ?> f_r jGesture"></button></div>
</div>
<div class="morelist" onclick="document.getElementById('popup1').style.display='block';">이용약관</div>
<div class="morelist" onclick="document.getElementById('popup2').style.display='block';">개인정보 이용정책</div>
<div class="list flexbox">
    버전 정보 <div class="flex1 right gray t14px">10.01.01</div>
</div>

<div class="popArea">

</div>

<div id="popup1" class="popup_layer">
    <div class="bg" style="top:90px;">
        <h1 class="popuptitle">이용약관</h1>
        <div class="type02">
            본 약관(이하 ‘본 약관’이라 함)은 주식회사 시프티(Shiftee)(이하 ‘시프티’라 함)가 제공하는 모든 제품 및 서비스 (이하 ‘본 서비스’라 함)의 이용에 관한 조건에 대해 본 서비스를 이용하는 사용자(이하 ‘사용자’라 함)와 시프티간에 정하는 것이다.
        </div>
        <div class="clearfix">
            <button type="button" class="btn_type01" onclick="document.getElementById('popup1').style.display='none';">닫기</button>
        </div>
    </div>
</div>

<div id="popup2" class="popup_layer">
    <div class="bg" style="top:90px;">
        <h1 class="popuptitle">개인정보 이용정책</h1>
        <div class="type02">
            본 약관(이하 ‘본 약관’이라 함)은 주식회사 시프티(Shiftee)(이하 ‘시프티’라 함)가 제공하는 모든 제품 및 서비스 (이하 ‘본 서비스’라 함)의 이용에 관한 조건에 대해 본 서비스를 이용하는 사용자(이하 ‘사용자’라 함)와 시프티간에 정하는 것이다.
        </div>
        <div class="clearfix">
            <button type="button" class="btn_type01" onclick="document.getElementById('popup2').style.display='none';">닫기</button>
        </div>
    </div>
</div>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/footer.php" ;?>