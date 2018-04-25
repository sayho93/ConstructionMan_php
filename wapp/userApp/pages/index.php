<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-13
 * Time: 오후 4:11
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php"; ?>
<?
    $obj = new WebUser($_REQUEST);
    $user = $obj->webuser;
    $permission = $user->summatives->primary->permission;
    $memberId = $user->id;
    $companyId = $user->summatives;
?>

<script>
    const diligenceStatusEnum = {0 : "출근", 1 : "외출", 2 : "복귀", 3 : "퇴근"};
    const weekDayEnum = {0 : "일", 1 : "월", 2 : "화", 3 : "수", 4 : "목", 5 : "금", 6 : "토"};

    $(document).ready(function(){
        const permission = "<?=$permission?>";
        setHeaderTitle("<img src='/userApp/image/logo_top.png' width='98'/>");
        pageInit();

        $(".jAttend").click(function(){
            let map = new sehoMap();
            let latestStat = $(this).attr("stat");
            if(latestStat !== 3) map.put("popText", "퇴근 기록이 없습니다. 출근 하시겠습니까?");
            else map.put("popText", "출근 하시겠습니까?");
            showPop(map, function(){doRegister();});
        });

        $(".jLeave").click(function(){
            let map = new sehoMap();
            let latestStat = $(this).attr("stat");
            if(latestStat === 3) map.put("popText", "출근 기록이 없습니다. 퇴근 하시겠습니까?");
            else map.put("popText", "퇴근 하시겠습니까?");
            showPop(map, function(){doRegister();});
        });

        $(document).on("click", ".gateEntity", function(){
            let gatePermission = $(this).attr("pms");
            let gateId = $(this).attr("no");
            if(parseInt(permission) <= parseInt(gatePermission)){
                showPop(new sehoMap().put("popText", "출입 처리되었습니다."), null, function(){
                    registerDiligence(gateId, 0, 0);
                    pageInit();
                });
            }
            else
                showPop(new sehoMap().put("popText", "출입 권한이 없습니다."));
        });
    });

    function pageInit(){startTime(); fetchFavoredGateList(); fetchDiligence();}

    function showGates(data){
        $("#gateListArea").html("");
        let list = data.data;
        for(let i=0; i<list.length; i++) $("#gateListArea").append("<button type=\"button\" class=\"btn_gray btn_bigh mt10 gateEntity\" no=\"" + list[i].id + "\" pms=\"" + list[i].permission + "\">" + list[i].title + "</button>");
        $("#popup2").show();
   }

    function startTime(){
        let today = new Date();
        let [h, m, year, month, date, day] = [today.getHours(), today.getMinutes(), today.getFullYear(), today.getMonth() + 1, today.getDate(), today.getDay()];
        let meridiemFormat = "AM";
        m = checkTime(m);
        if(h > 12){
            meridiemFormat = "PM";
            h -= 12;
            h = checkTime(h);
        }
        $("#date").html(year + "년 " + month + "월 " + date + "일 (" + weekDayEnum[day] + ")");
        $("#time").html(h + ":" + m + " <span class=\"blue\">" + meridiemFormat + "</span>");
        setTimeout(function(){startTime();}, 1000);
    }

    function checkTime(i){
        if (i < 10) i = "0" + i;
        return i;
    }

    function fetchDiligence(){
        const ajax = new AjaxSender(action + "WebUser.getLatestDiligenceUser", true, "json", new sehoMap());
        ajax.send(function(data){
            let row = data.data;
            let txt = diligenceStatusEnum[row.type] + " 상태입니다.";
            if(row.type === row.prevType){
                if(row.type === 3) txt += " 이전 출근 기록을 확인해 주세요";
                else txt += " 이전 퇴근 기록을 확인해 주세요";
            }
            else if(row.type < 3 && row.prevType < 3) txt += " 이전 출근 기록을 확인해 주세요";
            $("#diligenceStatus").html(txt);
            $(".jAttend").attr("stat", row.type);
            $(".jLeave").attr("stat", row.type);

            if(row.type === 3) $("#breakArea").hide();
            if(row.type === 2){
                $(".jBreak").hide();
                $(".jReturn").show();
                $(".jBreakStatus").show();
                $("#breakTime").html(row.uptMeridiem);
            }
        });
    }

    function fetchFavoredGateList(){
        const ajax = new AjaxSender(action + "WebUser.getFavoredGates", true, "json", new sehoMap());
        ajax.send(function(data){
            let list = data.data;
            for(let i=0; i<list.length; i++){
                let row = list[i];
                let form = $("#favoredListForm").html();
                form = form.replace("{#id}", row.gateId);
                form = form.replace("{#name}", row.gateTitle);
                $("#favoredListArea").append(form);
            }
        });
    }

    //TODO 출근/외출/복귀/퇴근 처리
    function registerDiligence(gateId, classifier, type){
        let map = new sehoMap().put("gateId", gateId).put("classifier", classifier).put("type", type);
        const ajax = new AjaxSender(action + "WebUser.registerDiligence", false, "json", map);
        ajax.send(function(data){
            console.log(data);
        });
    }

    function onBeaconDetected(uuid, major, minor, distance){
        let map = new sehoMap().put("beaconSN", uuid).put("major", major).put("minor", minor).put("distance", distance);
        const ajax = new AjaxSender(action + "WebUser.getGates", false, "json", map);
        ajax.send(function(data){
            showGates(data);
        });
    }

    function onWorkRegister(memberId, companyId, mode){location.href = "native://onWorkRegister";}

    function closeAskPop(){document.getElementById('popup1').style.display='none';}

    function doRegister(){
        closeAskPop();
        onWorkRegister();
//        onBeaconDetected("0d624712-f893-447b-a2f3-624c555c3b32", 1, 4, 0);
    }
</script>

    <div id="favoredListForm" style="display:none;"><button type="button" class="btn_blue btn_bigh mt10 jFGate" no="{#id}">{#name}</button></div>

    <div class="home_wrap">
<!--        TODO-->
        <div class="company_place jCurrentLoc">
            <img src="/userApp/image/ic_place.png" width="14">
            ABC마트 - 서울
        </div>

        <div class="timebox">
            <p id="time"></p>
            <p class="date" id="date">2017년 06월 14일 (목)</p>
        </div>

        <div class="state" id="diligenceStatus">    </div>
        <div class="bg_attend mt10">
            <a href="#open"><img src="/userApp/image/btnic_work_go_on.png" width="100" class="mr20 jAttend"></a>
            <img src="/userApp/image/btnic_work_out.png" width="100" class="jLeave">
        </div>
        <div class="bg_out clearfix" id="breakArea">
            <button type="button" class="btn_gray btn_bigh f_l jBreak" style="width:22%;">외출</button>
            <button type="button" class="btn_gray btn_bigh f_l jReturn" style="width:22%; display:none;">복귀</button>
            <p class="out_state jBreakStatus"><span id="breakTime"></span> 외출 하셨습니다.</p>
        </div>
        <div id="favoredListArea">  </div>
    </div>

    <div id="popArea">  </div>

    <div id="popup2" class="popup_layer">
        <div class="bg">
            <div class="type01" id="gateListArea">  </div>
            <div class="clearfix">
                <button type="button" class="btn_type01" onclick="document.getElementById('popup2').style.display='none';">취소</button>
            </div>
        </div>
    </div>

    <div class="popArea">   </div>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/footerNavigation.php" ;?>