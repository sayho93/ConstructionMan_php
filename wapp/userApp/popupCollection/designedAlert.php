<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-08
 * Time: 오전 11:49
 */
?>

<div id="popup1" class="popup_layer jAlert">
    <div class="bg" style="top:40%;">
        <div class="type01"><?=$_REQUEST["popText"]?></div>

        <div class="clearfix">
            <button type="button" class="btn_type01 closePopBtn jConfirm" onclick="document.getElementById('popup1').style.display='none';" style="display: none;">확인</button>
            <button type="button" class="btn_type01 closePopBtn jCancel" onclick="document.getElementById('popup1').style.display='none';">닫기</button>
        </div>
    </div>
</div>
