<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-23
 * Time: 오후 4:06
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php"; ?>
<script>
    const weekDayEnum = {0 : "일", 1 : "월", 2 : "화", 3 : "수", 4 : "목", 5 : "금", 6 : "토"};
    const gateId = "<?=$_REQUEST["id"]?>";
    $(document).ready(function(){
        setHeaderTitle("출입문 상세보기");
        getGateInfo();
        $(document).on("click", "#gateLike", function(){manipulateFlag($(this).attr("flag"), 1);});
        $(document).on("click", "#gateGesture", function(){manipulateFlag($(this).attr("flag"), 2)});
    });

    //TODO 출입문 상태
    function getGateInfo(){
        let ajax = new AjaxSender(action + "WebUser.getGateDetail", false, "json", new sehoMap().put("gateId", "<?=$_REQUEST["id"]?>"));
        ajax.send(function(data){
            let [gateInfo, rangeList] = [data.data.gateInfo, data.data.entranceRange];

            $("#gateName").html(gateInfo.title);
            if(gateInfo.isFavored === 1){
                toggleJClass("#gateLike", "btn_favo", "btn_favo_on");
                $("#gateLike").attr("flag", "1");
            }else{
                toggleJClass("#gateLike", "btn_favo_on", "btn_favo");
                $("#gateLike").attr("flag", 0);
            }

            if(gateInfo.isGestureEnabled === 1){
                toggleJClass("#gateGesture", "btn_gesture", "btn_gesture_on");
                $("#gateGesture").attr("flag", "1");
            }else{
                toggleJClass("#gateGesture", "btn_gesture_on", "btn_gesture");
                $("#gateGesture").attr("flag", 0);
            }

            $("#enabledTime").html(gateInfo.formattedStartDate + " ~ " + gateInfo.formattedEndDate);
            appendRange(rangeList);
        });
    }

    function appendRange(rangeList){
        $("#rangeTarget").html("");
        for(let i=0; i<rangeList.length; i++){
            const [starterWeekDay, starterSat, starterSun, ender] = ["<p>", "<p class=\"blue\">", "<p class=\"red\">", "</p>"];
            let row = rangeList[i];
            let txt = weekDayEnum[parseInt(row.weekDay)] + " " + row.startTime + " ~ " + row.endTime;

            if(row.weekDay === 0) $("#rangeTarget").append(starterSun + txt + ender);
            else if(row.weekDay === 6) $("#rangeTarget").append(starterSat + txt + ender);
            else $("#rangeTarget").append(starterWeekDay + txt + ender);
        }
    }

    function  manipulateFlag(flag, type){
        let target = "WebUser.";
        if(type === 1) target += "updateLikeStatus";
        else if(type === 2) target += "updateGestureStatus";

        const ajax = new AjaxSender(action + target, false, "json", new sehoMap().put("flag", flag).put("gateId", gateId));
        ajax.send(function(data){
            if(data.returnCode === 1) getGateInfo();
            else alert(data.returnMessage);
        });
    }
</script>

<div class="home_wrap clearfix">
    <button type="button" class="f_l btn_favo" id="gateLike" flag="0"></button>
    <button type="button" class="f_r btn_gesture" id="gateGesture" flag="0"></button>
    <p class="mt30 t33px center" id="gateName"></p>

    <figure class="ic_door">
        <img src="/userApp/image/ic_door.png" width="100">
        <figcaption id="gateStatus">출입문 정상</figcaption>
    </figure>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="basic mt30">
        <colgroup>
            <col width="29%">
            <col width="71%">
        </colgroup>
        <tr>
            <th>출입 기간</th>
            <td id="enabledTime">   </td>
        </tr>
        <tr>
            <th>출입 요일</th>
            <td id="rangeTarget">   </td>
        </tr>
    </table>
</div>
