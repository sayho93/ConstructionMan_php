<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-10
 * Time: 오전 10:11
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php"; ?>
<script>
    $(document).ready(function(){
        setHeaderTitle("더보기");
        $(".jLogout").click(function(){
            let ajax = new AjaxSender(action + "WebUser.userLogout", false, "json", new sehoMap());
            ajax.send(function(data){location.href = "/userApp";});
        });
    });
</script>

<div class="morelist" onclick="location.href='/userApp/pages/showMore/notice.php';">공지사항</div>
<div class="morelist" onclick="location.href='/userApp/pages/showMore/myPage.php';">마이페이지</div>
<div class="morelist" onclick="location.href='/userApp/pages/workPlace/myWorkPlace.php';">근무지 관리</div>
<div class="morelist" onclick="location.href='/userApp/pages/showMore/appSetting.php';">설정</div>
<div class="morelist jLogout">로그아웃</div>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/footerNavigation.php" ;?>