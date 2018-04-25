<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-09-04
 * Time: 오후 5:24
 */
?>

<div class="sideBar">
    <h2>DURATECH</h2>

    <ul class="menu_list">
        <li class="jMain animsition-link"><a href="/web/main.php"><img src="image/ic_side_home.png" alt="메인" /><?=$locMap["menu_main"]?></a></li>
        <li class="jAddMotor"><a><img src="image/ic_side_add.png" alt="모터 추가" /><?=$locMap["menu_motor"]?></a></li>
        <li class="jEmitPeriod"><a><img src="image/ic_side_timer.png" alt="점멸 주기 설정" /><?=$locMap["menu_emit"]?></a></li>
        <li class="jLangSetting"><a><img src="image/ic_side_language.png" alt="언어 설정" /><?=$locMap["menu_locale"]?></a></li>
    </ul>

    <div class="menu_lock">
        <a>
            <img src="image/ic_side_lock.png" alt="사이드 메뉴 잠금" flag="0"/>
            <dura><?=$locMap["side_lock"]?></dura>
        </a>
    </div>
</div>
