<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 5. 4.
 * Time: PM 3:18
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
    $obj = new WebUser($_REQUEST);
    $userInfo = $obj->getUserInfo();
    $userInfo = json_decode($userInfo)->data;
    $pushFlag = $userInfo->pushFlag;
?>

<script>
    $(document).ready(function(){
        $(".jPrivacy").click(function(){location.href = "/userApp/pages/Account/privacy.php";})
        $(".jPolicy").click(function(){location.href = "/userApp/pages/Account/policy.php";})

        $(".jPush").click(function(){
            var currentFlag = $("#pushFlag").attr("status");
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.updatePushFlag", false, "json", new sehoMap());
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.reload();
                }
            });
        });

        $(".jWithdraw").click(function(){
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.withdrawUser", false, "json", new sehoMap());
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("탈퇴되었습니다");
                    location.href = "/userApp";
                }
            });
        });

        $(".jBack").click(function(){history.go(-1);});
    });
</script>


<div class="header">
    <a class="tool_left"><img src="../../img/btn_prev.png" class="back_btn jBack"/></a>
    <h2>설정</h2>
</div>

<div class="body">
    <div class="title">
        <p>서비스 사용정보 및 설정</p>
    </div>

    <table class="listTable" style="margin-bottom: 13vh;">
        <tr class="row jPrivacy">
            <td width="20%" class="gray"><img src="../../img/ico_mylist_privacy.png" style="width:8vw; height:8vw;"></td>
            <td width="80%" class="txt">
                개인정보처리방침
                <img src="../../img/btn_go_detail.png" style="float: right; width: 4vw; height: 7vw; margin-right: 4vw;">
            </td>
        </tr>
        <tr class="row jPolicy">
            <td width="20%" class="gray"><img src="../../img/ico_mylist_policy.png" style="width:8vw; height:8vw;"></td>
            <td width="80%" class="txt">
                서비스 약관
                <img src="../../img/btn_go_detail.png" style="float: right; width: 4vw; height: 7vw; margin-right: 4vw;">
            </td>
        </tr>
        <tr class="row jPush">
            <td width="20%" class="gray"><img src="../../img/ico_mylist_sound.png" style="width:8vw; height:8vw;"></td>
            <td width="80%" class="txt">
                푸쉬 알림설정
                <div id="pushFlag" status="<?=$pushFlag?>" style="float: right; width: 4vw; height: 7vw; margin-right: 4vw; font-size: 1.0em;">
                    <?
                        if($pushFlag == 1)
                            echo "ON";
                        else
                            echo "OFF";
                    ?>
                </div>
            </td>
        </tr>
        <tr class="row jWithdraw">
            <td width="20%" class="gray"><img src="../../img/ico_mylist_withdraw.png" style="width:8vw; height:8vw;"></td>
            <td width="80%" class="txt">
                회원탈퇴
                <img src="../../img/btn_go_detail.png" style="float: right; width: 4vw; height: 7vw; margin-right: 4vw;">
            </td>
        </tr>
        <tr class="row">
            <td width="20%" class="gray"><img src="../../img/ico_mylist_info.png" style="width:8vw; height:8vw;"></td>
            <td width="80%" class="txt">
                버전정보
                <div style="float: right; margin-right: 6vw;">1.1.1</div>
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

