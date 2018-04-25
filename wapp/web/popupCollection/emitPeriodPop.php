<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-09-11
 * Time: 오전 9:50
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php" ;?>
<?
$obj = new WebUser($_REQUEST);
$loc = $obj->webUser["loc"];
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/comm/Locale.php"; ?>
<?
$locMap = $MENU_CONSTS[$loc];
?>

<div class="popup_type03 jEmitPeriodPop">
    <div class="pop_title">
        <h3>점멸 주기 설정</h3>
        <a><img src="image/ic_pop_title_exit.png" class="JClose" alt="닫기" target="jEmitPeriodPop" /></a>
    </div>

    <div class="pop_content">
        <p class="description">점멸 주기를 설정해 주세요</p>
        <ul class="chk_form clearfix">
            <li>
                <p>관심(노랑)</p>
                <select>
                    <?for($i=0; $i<24; $i++){?>
                        <option value="<?=$i?>"><?=$i?>시간</option>
                    <?}?>
                </select>
                <select>
                    <?for($i=0; $i<60; $i++){?>
                        <option value="<?=$i?>"><?=$i?>분</option>
                    <?}?>
                </select>
                <select>
                    <?for($i=0; $i<60; $i++){?>
                        <option value="<?=$i?>"><?=$i?>초</option>
                    <?}?>
                </select>
            </li>
            <li>
                <p>주의(주황)</p>
                <select>
                    <?for($i=0; $i<24; $i++){?>
                        <option value="<?=$i?>"><?=$i?>시간</option>
                    <?}?>
                </select>
                <select>
                    <?for($i=0; $i<60; $i++){?>
                        <option value="<?=$i?>"><?=$i?>분</option>
                    <?}?>
                </select>
                <select>
                    <?for($i=0; $i<60; $i++){?>
                        <option value="<?=$i?>"><?=$i?>초</option>
                    <?}?>
                </select>
            </li>
            <li>
                <p>심각(빨강)</p>
                <select>
                    <?for($i=0; $i<24; $i++){?>
                        <option value="<?=$i?>"><?=$i?>시간</option>
                    <?}?>
                </select>
                <select>
                    <?for($i=0; $i<60; $i++){?>
                        <option value="<?=$i?>"><?=$i?>분</option>
                    <?}?>
                </select>
                <select>
                    <?for($i=0; $i<60; $i++){?>
                        <option value="<?=$i?>"><?=$i?>초</option>
                    <?}?>
                </select>
            </li>
        </ul>
    </div>

    <div class="pop_footer clearfix">
        <div class="f_r">
            <input class="JClose" target="jEmitPeriodPop" type="button" name="" value="<?=$locMap[buttons][cancel]?>" />
            <input type="button" name="" value="<?=$locMap[buttons][confirm]?>" />
        </div>
    </div>
</div>