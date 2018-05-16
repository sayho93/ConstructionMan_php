<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 5. 2.
 * Time: PM 3:49
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
    $type = $userInfo->type;
    $gearInfo = $userInfo->gearInfo;

    $imgPath = $userInfo->imgPath;
?>
<script>
    $(document).ready(function(){
        var type = "<?=$type?>";
        $(".jBack").click(function(){location.href = "/userApp/pages/search/searchMain.php"})
        $(".jInfo").click(function(){location.href = "/userApp/pages/mypage/mypageInfo.php?type=" + type;});
        $(".jApply").click(function(){location.href = "/userApp/pages/mypage/applyInfo.php";});
        $(".jPaid").click(function(){location.href = "/userApp/pages/mypage/paymentInfo.php";});
        $(".jSetting").click(function(){location.href = "/userApp/pages/mypage/setting.php";});

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
            if(confirm("금액을 충전하시겠습니까?")){
                var params = new sehoMap().put("userId", "<?=$userInfo->id?>");
                var ajax = new AjaxSender("/action_front.php?cmd=WebUser.insertPaymentBasic", true, "json", params);
                ajax.send(function(data){
                    location.href = "/userApp/pages/mypage/payment.php?paymentId=" + data + "&userId=" + '<?=$userInfo->id?>';
                });
            }


            // alert("< 금액(포인트) 충전 정보 안내 > \n 계좌번호(입금주 이행수(휴넵스))\n" +
            // "- 국민은행 770601-00-1019919\n" +
            // "- 농협 301-0231-1507-91");
        });
    });
</script>

<div class="mypageHeader">
    <h2>마이페이지</h2>
    <a class="tool_left"><img src="../../img/btn_prev.png" class="back_btn jBack"/></a>
    <a class="tool_right wide"><p id="point"></p></a>
    <div>
        <? if($imgPath == ""){ ?>
            <img src="../../img/person_head.png" class="profileImg"/>
        <? }else{ ?>
            <img src="<?=$obj->IMG_DIR.$imgPath?>" class="profileImg"/>
        <? } ?>
    </div>
    <h3><?=$name?></h3>
</div>

<div class="mypageTitleHeader">
    <table width="100%" height="100%">
        <tr class="tableRowInfo">
            <td width="20%"><a class="subject">희망지역</a></td>
            <td width="30%">
                <a class="content">
                    <?
                        for($i=0; $i<sizeof($regionInfo); $i++){
                            echo $regionInfo[$i]->gugunTxt;
                            if($i != sizeof($regionInfo) - 1) echo ", ";
                        }
                    ?>

                </a>
            </td>

            <?if($type == "M"){?>
            <td width="20%"><a class="subject">직종</a></td>
            <td width="30%">
                <a class="content">
                    <?
                        for($i=0; $i<sizeof($workInfo); $i++){
                            echo $workInfo[$i]->name;
                            if($i != sizeof($workInfo) - 1) echo ", ";
                        }
                    ?>
                </a>
            </td>
            <?}else if($type == "G"){?>
                <td width="20%"></td>
                <td width="30%">
                </td>
            <?}?>

        </tr>
        <tr class="tableRowInfo">
            <?if($type == "M"){?>
            <td><a class="subject">경력정보</a></td>
            <td>
                <a class="content">
                    <?
                        for($i=0; $i<sizeof($workInfo); $i++){
                            switch($workInfo[$i]->career){
                                case 1:
                                    echo "5년 이하";
                                    break;
                                case 2:
                                    echo "5년 이상";
                                    break;
                                case 3:
                                    echo "10년 이상";
                                    break;
                            }

                            if($i != sizeof($workInfo) - 1) echo ", ";
                        }
                    ?>
                </a>
            </td>
            <?}else if($type == "G"){?>
                <td><a class="subject">장비</a></td>
                <td colspan="2">
                    <a class="content">
                        <?
                            for($i=0; $i<sizeof($gearInfo); $i++){
                                echo $gearInfo[$i]->name . "/" . $gearInfo[$i]->detail . "/" . $gearInfo[$i]->size;

                                if($i != sizeof($gearInfo) - 1) echo ", ";
                            }
                        ?>
                    </a>
                </td>
            <?}?>
<!--            <td></td>-->
        </tr>
    </table>
</div>

<div class="mypageBody">
    <table class="listTable">
        <tr class="row jInfo">
            <td width="20%" class="gray"><img src="../../img/ico_info.png" style="width: 8vw; height: 8vw;"></td>
            <td width="80%" class="txt">
                개인정보
                <img src="../../img/btn_go_detail.png" style="float: right; width: 4vw; height: 7vw; margin-right: 4vw;">
            </td>
        </tr>
        <tr class="row jApply">
            <td width="20%" class="gray"><img src="../../img/ico_list.png" style="width: 8vw; height: 8vw;"></td>
            <td width="80%" class="txt">
                구인리스트
                <img src="../../img/btn_go_detail.png" style="float: right; width: 4vw; height: 7vw; margin-right: 4vw;">
            </td>
        </tr>
        <tr class="row jPaid">
            <td width="20%" class="gray"><img src="../../img/ico_history.png" style="width: 8vw; height: 8vw;"></td>
            <td width="80%" class="txt">
                결제내역
                <img src="../../img/btn_go_detail.png" style="float: right; width: 4vw; height: 7vw; margin-right: 4vw;">
            </td>
        </tr>
        <tr class="row jSetting">
            <td width="20%" class="gray"><img src="../../img/ico_setting.png" style="width: 8vw; height: 8vw;"></td>
            <td width="80%" class="txt">
                설정
                <img src="../../img/btn_go_detail.png" style="float: right; width: 4vw; height: 7vw; margin-right: 4vw;">
            </td>
        </tr>
    </table>

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
