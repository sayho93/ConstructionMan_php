<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-09-13
 * Time: 오전 9:39
 */
?>
<script>
    $(document).ready(function(){
        var popMap = new Map();
        var mKey = '<?=$_REQUEST[mKey]?>';

        $(".jSubmit").click2(function(){
            if(popMap.containsKey("/web/popupCollection/spectrumViewPop.php")){
                //main.js의 showPop 호출
                showPop("/web/popupCollection/spectrumViewPop.php?mKey="+mKey);
            }

        });

        //select check/uncheck Map handler
        $(".jPopSelect").click2(function(){
            var flag = $(this).prop("checked");
            var target = $(this).attr("target");
            console.log("flag : " + flag + ", target : "+ target)
            if(flag == true){
                console.log("true");
                popMap.put(target, "");
            }
            else if(flag == false){
                console.log("falase");
                popMap.remove(target);
            }
            console.log(popMap);
        });

    });
</script>


<div class="popup_type02 jPopupManagePop">
    <div class="pop_title">
        <h3>팝업 관리</h3>
        <a class="JClose" target="jPopupManagePop"><img src="image/ic_pop_title_exit.png" alt="닫기" /></a>
    </div>

    <div class="pop_content">
        <ul class="chk_form clearfix">
            <li>
                <input class="jPopSelect" type="checkbox" name="motorInfo" id="chk1" target="/web/popupCollection/motorInfoPop.php" />
                <label for="chk1"><span>모터 정보</span></label>
            </li>
            <li>
                <input class="jPopSelect" type="checkbox" name="energyEfficiency" id="chk2" target="/web/popupCollection/energyEfficiencyPop.php" />
                <label for="chk2"><span>에너지 효율</span></label>
            </li>
            <li>
                <input class="jPopSelect" type="checkbox" name="motorStat" id="chk3" target="/web/popupCollection/motorStatPop.php" />
                <label for="chk3"><span>모터 상태</span></label>
            </li>
            <li>
                <input class="jPopSelect" type="checkbox" name="trendView" id="chk4" target="/web/popupCollection/trendViewPop.php" />
                <label for="chk4"><span>Trend View</span></label>
            </li>
            <li>
                <input class="jPopSelect" type="checkbox" name="machineStat" id="chk5" target="/web/popupCollection/machineStatPop.php"/>
                <label for="chk5"><span>기계 상태</span></label>
            </li>
            <li>
                <input class="jPopSelect" type="checkbox" name="spectrumView" id="chk6" target="/web/popupCollection/spectrumViewPop.php"/>
                <label for="chk6"><span>Spectrum View</span></label>
            </li>
        </ul>
        <p class="description">※ 화면 관리에서 선택하지 않은 항목만 선택 가능</p>
    </div>

    <div class="pop_footer clearfix">
        <div class="f_r">
            <input type="button" class="JClose" target="jPopupManagePop" value="취소" />
            <input type="button" class="jSubmit" value="확인" />
        </div>
    </div>
</div>