<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-14
 * Time: 오후 5:59
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php"; ?>
<?
    $obj = new WebUser($_REQUEST);
    $companyId = $obj->webUser->summatives->primary->companyId;
    $memberId = $obj->webUser->id;
?>
<script>
    const [availableImg, offlimitImg, favoredImg, unFavoredImg, gestureImg] =
        ["/userApp/image/ic_door_ok.png", "/userApp/image/ic_door_er.png", "/userApp/image/ic_favo_on.png", "/userApp/image/ic_favo_off.png", "/userApp/image/ic_gesture.png"];
    $(document).ready(function(){
        setHeaderTitle("출입문");
        getDoorList();

        $(document).on("click", ".jDetail", function(){
            let doorId = $(this).attr("no");
            location.href = "/userApp/pages/door/doorDetail.php?id=" + doorId;
        });
    });

    function getDoorList(){
        //TODO companyId에 제대로 된 값 넣기 "<?=$companyId?>"
        let ajax = new AjaxSender(action + "WebUser.getGates", false, "json", new sehoMap().put("companyId", "1").put("memberId", "<?=$memberId?>"));
        ajax.send(function(data){
            let list = data.data;
            for(let i=0; i<list.length; i++){
                let row = list[i];
                let template = $("#template").html();

                template = template.replace("{#name}", row.title);
                if(row.liked === true) template = template.replace("{#favored}", favoredImg);
                else template = template.replace("{#favored}", unFavoredImg);

                //TODO replace with proper flag
                template = template.replace("{#doorId}", row.id);
                template = template.replace("{#gesture}", "");
                template = template.replace("{#availability}", availableImg);
                $(".doorlist").append(template);
            }
        });
    }
</script>

<!--list template-->
<table id="template" style="display:none;">
    <tr class="jDetail" no="{#doorId}" style="cursor:pointer;">
        <td><img src="{#availability}" width="14"></td>
        <td>{#name}</td>
        <td>
            <img src="{#gesture}" width="22">
            <img src="{#favored}" width="22">
        </td>
    </tr>
</table>

<div class="bg_search">
    <button type="button" class="btn_blue btn_bigh" onclick="location.href='invite_list.html';">초대장 관리</button>
</div>

<h2 class="center">출입문 목록</h2>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="doorlist">
    <colgroup>
        <col width="15%">
        <col width="60%">
        <col width="25%">
    </colgroup>
</table>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/footerNavigation.php" ;?>