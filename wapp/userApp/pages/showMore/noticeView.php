<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-13
 * Time: 오전 11:51
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php"; ?>
<?
$obj = new WebUser($_REQUEST);
$data = $obj->getBoardInfo();
$data = json_decode($data)->data;
$besides = $data->besides;
?>

<script>
    $(document).ready(function(){
        setHeaderTitle("공지사항");
        $(".jNext").click(function(){
            let id = $(this).attr("no");
            location.href = "/userApp/pages/showMore/noticeView.php?id=" + id;
        });
    });
</script>

<div class="noticelist">
    <p><?=$data->title?></p>
    <p class="t12px gray">등록일 : <?=$data->regDate?></p>
</div>

<div class="noticeview">
    <?=$data->contents?>
<!--    <p><img src="/userApp/image/img_noticeview.png"></p>-->
</div>

<div class="noticefoot">
    <hr>
    <?if($besides->next){?>
        <div class="noticelist_next jNext" no="<?=$besides->next->id?>">
            <div class="flex1 gray">다음글</div>
            <div class="title"><?=$besides->next->title?></div>
        </div>
    <?}?>
    <?if($besides->prev){?>
        <div class="noticelist_next jNext" no="<?=$besides->prev->id?>">
            <div class="flex1 gray">이전글</div>
            <div class="title"><?=$besides->prev->title?></div>
        </div>
    <?}?>
</div>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/footer.php" ;?>
