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
<script>
    $(document).ready(function(){
        $(".jSubmit").click2(function(){
            var locale = $("[name=locRadio]:checked").val();
            $.ajax({
                url: "/action_front.php?cmd=WebUser.setLocale",
                async : false,
                cache : false,
                dataType : "json",
                data:{
                    locale : locale
                },
                success :function(data){
                    $.ajax({
                        url: "/action_front.php?cmd=WebUser.refreshUserInfo",
                        async : false,
                        cache : false,
                        dataType : "json",
                        data:{
                            locale : locale
                        },
                        success : function(data){
                            if(data.returnCode == "1"){
                                alert("저장되었습니다");
//                                $(".jCancel").trigger("click");
                                location.reload();
                            }
                        }
                    });
                }
            });
        });

    });

</script>


<div class="popup_type03 jLanguageSetting">
    <div class="pop_title">
        <h3>언어 설정</h3>
        <a><img src="image/ic_pop_title_exit.png" class="JClose" id="close" alt="닫기" target="jLanguageSetting" /></a>
    </div>

    <div class="pop_content">
        <p class="description">언어를 선택해 주세요</p>
        <ul class="chk_form clearfix">
            <li>
                <input type="radio" name="locRadio" id="locKo" value="ko" <?=$loc == "ko" ? "checked" : ""?>/>
                <label for="locKo"><span>한국어</span></label>
            </li>
            <li>
                <input type="radio" name="locRadio" id="locEn" value="en" <?=$loc == "en" ? "checked" : ""?>/>
                <label for="locEn"><span>영어</span></label>
            </li>
        </ul>
    </div>

    <div class="pop_footer clearfix">
        <div class="f_r">
            <input type="button" class="JClose" target="jLanguageSetting" value="<?=$locMap[buttons][cancel]?>" />
            <input type="button" class="jSubmit" value="<?=$locMap[buttons][confirm]?>" />
        </div>
    </div>
</div>