<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-08
 * Time: 오전 10:56
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Web.php"; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>ConstructionMan</title>
    <link href="/userApp/css/style.css" rel="stylesheet" type="text/css" />
</head>
<?
    $headObj = new Web($_REQUEST);
//    $loginInfo = $headObj->webUser;
//
//    if(!strpos($_SERVER['REQUEST_URI'],'Account') !== false){
//        if(!$loginInfo->id){
//            echo "<script>alert('로그인 후 이용가능합니다.'); location.href = '/userApp'; </script>";
//            return;
//        }
//    }
?>
<script type="text/javascript" src="/userApp/js/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script type="text/javascript" src="/modules/ajaxCall/ajaxClass.js"></script>
<script type="text/javascript" src="/modules/sehoMap/sehoMap.js"></script>
<script type="text/javascript" src="/modules/valueSetter/sayhoValueSetter.js"></script>
<script type="text/javascript" src="/modules/utils/PValidation.js"></script>
<script type="text/javascript" src="/userApp/js/jquery-ui.js"></script>
<script type="text/javascript" src="/userApp/js/jquery.nicescroll.min.js"></script>



<script>
    var action = "/action_front.php?cmd=";
    var designedAlert = "/userApp/popupCollection/designedAlert.php";
    $(document).ready(function(){
        $(".headerLogo").click(function(){
            location.href = "/userApp/pages/search/searchMain.php";
        });


        $(".jHeaderBack").click(function(){window.history.back();});

        $(".leftLogo").click(function(){
            location.href = "/userApp/pages/mypage/mypageMain.php";
        });
    });
</script>

<body>

<script>
    //designed popup with confirm&cancel callback
    function showPop(params, callbackConfirm, callbackCancel){
        $(".popArea").html("");
        var ajax = new AjaxSender(designedAlert, false, "html", params);
        ajax.send(function(data){
            $(".popArea").html(data);
            $(".jAlert").show();
            if(callbackConfirm){
                $(".jConfirm").show().removeClass("btn_type01").addClass("btn_type02");
                $(".jCancel").removeClass("btn_type01").addClass("btn_type02");
            }
        });
        $(".jConfirm").on("click", function(e){
            if(callbackConfirm) callbackConfirm();
            $(".jConfirm").unbind("click");
        });
        $(".jCancel").on("click", function(e){
            if(callbackCancel) callbackCancel();
            $(".jCancel").unbind("click");
        });
    }

    function setHeaderTitle(text){$(".jHeaderTitle").html(text);}

    function formatPhone(string){return string.replace(/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/,"$1-$2-$3");}

    function initDatepicker(selector){
        $(selector).datepicker({
            dateFormat: 'yy.mm.dd',
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNamesMin: ['일','월','화','수','목','금','토'],
            showMonthAfterYear: true,
            yearSuffix: '년',
        });
    }

    function toggleJClass(identifier, classFrom, classTo){
        if(classFrom !== null && classTo !== null){
            $(identifier).removeClass(classFrom);
            $(identifier).addClass(classTo);
        }
    }
</script>

	