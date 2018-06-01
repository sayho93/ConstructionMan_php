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
    $userInfo = $obj->webUser;

    $list = $obj->getPointHistory();
    $list = json_decode($list)->data;
?>

<script>
    $(document).ready(function(){
        $(".jBack").click(function(){history.go(-1);});

        $(".jDel").click(function(){
            var params = new sehoMap().put("id", $(this).attr("no"));
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.hideApplyList", true, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.reload();
                }
            })

        });
    });
</script>

<div class="header">
    <a class="tool_left"><img src="../../img/btn_prev.png" class="back_btn jBack"/></a>
    <h2>결제 및 신청내역</h2>
</div>

<div class="body">
    <br/><br/>
    <div style="margin:0vw 5vw 0vw 5vw">
        <div style="left:5vw; float: left;">
            <text style="color:#03A0CB; font-size: 1.0em;"><?=$userInfo->name?></text>
            <text style="color:#333333; font-size: 0.8em;">님의 결제 및 신청 내역입니다.</text>
        </div>
        <div style="right:5vw; float: right">
            <text style="color:#333333; font-size: 0.8em;">총 </text>
            <text style="color:#03A0CB; font-size: 0.8em;"><?=sizeof($list)?></text>
            <text style="color:#333333; font-size: 0.8em;"> 건</text>
        </div>
    </div>

    <?if(sizeof($list) == 0){?>
        <br/><br/>
    <?}?>

    <?foreach($list as $item){?>
        <div class="listWrapper">
            <div style="display:table-cell; border-top: 1px solid #CCCCCC; border-bottom: 1px solid #CCCCCC; width: 100vw; height: 5vh; vertical-align: middle;">
                <div style="float:left; left:5vw;">
                    <table>
                        <tr>
                            <td>
                                <text style="color:#AAAAAA; font-size: 0.5em;"><?=$item->regDate?></text>
                            </td>
                            <td>
                                <?if($item->isPaid == 1){?>
                                    <div style="padding: 4px 9px 4px 9px; text-align:center; color:#03A0CB; font-size: 0.4em; border: 1px solid #AAAAAA; background-color: #CCCCCC; border-radius: 5%; width:12vw;">
                                        &nbsp;결제완료&nbsp;
                                    </div>
                                <?}?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="float:right; right:5vw">
                    <a href="#"><img class="jDel" src="../../img/btn_del.png" style="height:7vw; width: 7vw;" no="<?=$item->searchId?>" /></a>
                </div>
            </div>
            <p>
                <?=$item->type == "M" ? "[인력]" : "[장비]"?>
                <?=$item->comment?>
            </p>
        </div>
    <?}?>

    <div class="footer" style="margin-top: 10vh;">
        <span>휴넵스/건설인</span>
        <br>
        <p>특허 제 10-1705485 호 / 사업자등록번호 461-14-00804</p>
        <p>직업정보제공사업신고번호 J1700020180005호 / 통신판매업신고 제 2018-대전유성-0240 호</p>
        <p>mail : huneps71@gmail.com / Tel. 010-9719-1105 </p>
        <br>
        <p>ⓒ 휴넵스 All rights reserved.</p>
    </div>

</div>
