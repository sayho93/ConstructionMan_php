<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 5. 8.
 * Time: PM 2:42
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
    $obj = new WebUser($_REQUEST);
    $list = $obj->getApplicationList();
    $list = json_decode($list)->data;
    $userInfo = $obj->getUserInfo();
    $userInfo = json_decode($userInfo)->data;

    $byPush = $_REQUEST["byPush"];
    $userId = $_REQUEST["userId"];
?>

<script>
    $(document).ready(function(){

        var byPush = "<?=$byPush?>";
        var user = "<?=$userId?>";

        if(byPush === "1"){
            var params = new sehoMap().put("userId", user);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.autoLogin", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1)
                    location.href = "/userApp/pages/mypage/applyInfo.php";
            });
        }


        $(".jBack").click(function(){
            location.href = "/userApp/pages/mypage/mypageMain.php";
        });

        $(".jAdd").click(function(){
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.usePoint", true, "json", new sehoMap());
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.reload();
                }
                else if(data.returnCode === -9){
                    alert("더 이상 결제할 목록이 없습니다.");
                    return;
                }
                else if(data.returnCode === -11){
                    alert("결제할 포인트가 부족합니다.");
                    return;
                }
            });
        });

        getUserPoint("#point");

        function getUserPoint(selector){
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.getUserPoint", true, "json", new sehoMap());
            ajax.send(function(data){
                if(data.returnCode === 1){
                    $(selector).html(data.data + " 원");
                    console.log(data);
                }
            })
        }

        $("#point").click(function(){
            //if(confirm("금액을 충전하시겠습니까?")){
            //    var params = new sehoMap().put("userId", "<?//=$userInfo->id?>//");
            //    var ajax = new AjaxSender("/action_front.php?cmd=WebUser.insertPaymentBasic", true, "json", params);
            //    ajax.send(function(data){
            //        location.href = "/userApp/pages/mypage/payment.php?paymentId=" + data + "&userId=" + '<?//=$userInfo->id?>//';
            //    });
            //}
        });

        $(".tel").click(function(){
            var tel = $(this).attr("no");
            if(tel.includes("*")){
                return;
            }
            else{
                location.href = "tel://" + tel;
            }
        });

        $(".round_btn").click(function(){
            alert("< 금액(포인트) 충전 정보 안내 > \n 계좌번호(입금주 이행수(휴넵스))\n" +
                "- 국민은행 770601-00-1019919\n" +
                "- 농협 301-0231-1507-91");
        });
    });
</script>

<div class="header">
    <a class="tool_left"><img src="../../img/btn_prev.png" class="back_btn jBack"/></a>
    <a class="tool_right wide">
        <p id="point"></p>
        <div class="round_btn">금액 충전</div>
    </a>
    <h2>구인리스트</h2>
</div>

<div class="body">
    <div class="listWrapper">
        <input class="recButton jAdd" type="button" value="포인트를 사용하여 더보기"/>

        <?foreach($list as $item){?>
            <table width="100%" border="0" cellpadding="0" cellspacing="6vw" class="doorlist" style="border-bottom: 1px solid gray; margin-top: 2vh;">
                <colgroup>
                    <col width="20%">
                    <col width="20%">
                    <col width="20%">
                    <col width="20%">
                    <col width="20%">
                </colgroup>
                <tr class="">
                    <td rowspan="3">
                        <?if($item->imgPath == ""){?>
                            <img src="../../img/list_person.png" style="width: 15vw; height: 15vw;">
                        <?}else{?>
                            <img src="<?=$obj->IMG_DIR.$item->imgPath?>" class="profileImg" style="width: 15vw; height: 15vw;"/>
                        <?}?>
                    </td>
                    <td style="font-size: 1.0em" colspan="2"><?=$item->name . "(" . $item->age . "대)"?></td>
                    <td colspan="2">
                        <!--                    <img src="../../img/btn_email.png" style="width: 8vw; height: 8vw; float: right">-->
                        <img src="../../img/btn_sms.png" class="tel" no="<?=$item->phone?>" style="width: 8vw; height: 8vw; float: right;">
                    </td>
                </tr>
                <tr>
                    <td class="subject">희망지역</td>
                    <td class="content">
                        <?
                        $lastItem = end($item->regionInfo);

                        foreach($item->regionInfo as $regionItem){
                            echo $regionItem->gugunTxt;
                            if($regionItem != $lastItem) echo ",";
                        }
                        ?>
                    </td>
                    <td class="subject"><?=$item->type == "M" ? "직종" : "장비"?></td>
                    <td class="content">
                        <?
                            if($item->type == "M"){
                                $lastItem = end($item->workInfo);
                                foreach($item->workInfo as $workItem){
                                    echo $workItem->name;
                                    if($workItem != $lastItem) echo ",";
                                }
                            }
                            else if($item->type == "G"){
                                $lastItem = end($item->gearInfo);
                                foreach($item->gearInfo as $gearItem){
                                    echo $gearItem->name;
                                    if($gearItem != $lastItem) echo ",";
                                }
                            }
                        ?>
                    </td>
                </tr>
                <!--            <tr style="margin-bottom: 2vh;">-->
                <!--                <td class="subject">경력정보</td>-->
                <!--                <td class="content">12년</td>-->
                <!--            </tr>-->
            </table>
        <?}?>
    </div>

    <div class="footer" style="margin-top: 2vh;">
        <span>휴넵스/건설인</span>
        <br>
        <p>특허 제 10-1705485 호 / 사업자등록번호 461-14-00804</p>
        <p>직업정보제공사업신고번호 J1700020180005호 / 통신판매업신고 제 2018-대전유성-0240 호</p>
        <p>mail : huneps71@gmail.com / tel : </p>
        <br>
        <p>ⓒ 휴넵스 All rights reserved.</p>
    </div>
</div>



