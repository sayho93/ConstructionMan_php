<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Web.php"; ?>
<?
	$headObj = new Web($_REQUEST);

	$loginInfo = $headObj->webUser;

    if($loginInfo[userNo] == -1)
    {
        echo "<script>alert('로그인 후 이용가능합니다.'); location.href = '/web'; </script>";
        return;
    }
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/comm/Locale.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/web/php/metaData.php" ?>
<!DOCTYPE html>
<html lang="utf-8">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="DURATECH">
    <title><?=$locMap["web_title"]?></title>
    <script src="js/html5shiv.min.js"></script>




</head>

<!--css-->
<link rel="stylesheet" type="text/css" href="css/common.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<!---->

<!--alert js-->
<link rel="stylesheet" type="text/css" href="css/sweetalert.css">
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<!---->

<!--page loading animation-->
<link rel="stylesheet" type="text/css" href="/web/js/animsition-master/dist/css/animsition.min.css">
<script src="/web/js/animsition-master/dist/js/animsition.min.js" charset="utf-8"></script>
<!---->

<script type="text/javascript" src="js/vis.js"></script>
<link href="css/vis.min.css" rel="stylesheet" type="text/css"/>


<script src="/common/js/sayhoValueSetter.js" charset="utf-8"></script>


<script>
    $(document).ready(function(){
        //page loading effect
        $('div :not(.header)').animsition({
            inClass: 'fade-in-up-sm',
            outClass: 'fade-out-up-sm',
            inDuration: 1500,
            outDuration: 800,
            linkElement: '.animsition-link',
            // e.g. linkElement: 'a:not([target="_blank"]):not([href^="#"])'
            loading: true,
            loadingParentElement: 'body', //animsition wrapper element
            loadingClass: 'animsition-loading',
            loadingInner: '', // e.g '<img src="loading.svg" />'
            timeout: false,
            timeoutCountdown: 5000,
            onLoadEvent: true,
            browser: [ 'animation-duration', '-webkit-animation-duration'],
            // "browser" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
            // The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
            overlay : false,
            overlayClass : 'animsition-overlay-slide',
            overlayParentElement : 'body',
            transition: function(url){ window.location.href = url; }
        });

        //header Menu handler ------------------------------------------------------------------------------------------
        //로그아웃 처리
        $("#jLoginCtrl").change(function(){
            if($("#jLoginCtrl").val() == "로그아웃" || $("#jLoginCtrl").val() == "Logout"){
                $.ajax({
                    url: "/action_front.php?cmd=WebBase.doWebLogout",
                    async: false,
                    cache: false,
                    dataType: 'json',
                    data: {
                    },
                    success: function (data) {
                        alert("<?=$locMap[alerts][logout]?>");
                        location.href = "/web";
                    }
                });
            }
        });

        //header popupManage Click handler
        $(".jPopManage").click2(function(){
            var mKey = '<?=$_REQUEST[mKey]?>';
            showPop("/web/popupCollection/popupManagePop.php?mKey="+mKey);
        });

        $(".jFullForce").click2(function(){
            var flag = $(this).attr("flag");
            toggleFullScreen();
            $(".jFullForce").attr("flag", (flag=="0"?"1":"0"));
            $(".jFullForce").find("img").attr("src", (flag=="0"?"image/ic_title_small.png":"image/ic_title_full.png"));
        });
        //--------------------------------------------------------------------------------------------------------------


        //side Menu handler---------------------------------------------------------------------------------------------

        //메인 페이지
        $(document).on("click", ".jMain", function(){
            location.href = "/web/main.php";
        });

        //모터 추가 팝업
        $(document).on("click", ".jAddMotor", function(){
            showPop("/web/popupCollection/addMotorPop.php");
        });

        //점멸주기설정 팝업
        $(document).on("click", ".jEmitPeriod", function(){
            showPop("/web/popupCollection/emitPeriodPop.php");
        });

        //언어 설정 팝업
        $(document).on("click", ".jLangSetting", function(){
            showPop("/web/popupCollection/languageSettingPop.php");
        });

        //팝업 닫기 일괄 처리
        $(document).on("click", ".JClose", function(){
            var target = $(this).attr("target");
            $("."+target).fadeOut();
        });

        //사이드메뉴 잠금 토글
        $(function(){
            $(".sideBar").find('.menu_lock').toggle(function(){
                $('.menu_lock').find("img").attr("src", "image/ic_side_lock_off.png");
                $('.menu_lock').find("img").attr("flag", "1");
                $('.menu_lock').find("dura").html("<?=$locMap["side_lock_release"]?>");
            }, function(){
                $('.menu_lock').find("img").attr("src", "image/ic_side_lock.png");
                $('.menu_lock').find("img").attr("flag", "0");
                $('.menu_lock').find("dura").html("<?=$locMap["side_lock"]?>");
            });
        });
        //--------------------------------------------------------------------------------------------------------------

        //팝업 영역 설정 공통
//        function showPop(url){
//            $.ajax({
//                url: url,
//                async : false,
//                cache : false,
//                dataType : "html",
//                data:{},
//                success :function(data){
//                    $(".jPopSection").html(data);
//                    $(".jPopSection").draggable();
//                }
//            });
//        }


    });
</script>

<body>
<script type="text/javascript" src="/web/js/main.js"></script>
<script type="text/javascript" src="js/sehoMap.js"></script>
<script src="js/html5shiv.min.js"></script>

<?if(strpos($_SERVER['REQUEST_URI'], "/web/login.php") !== false){?>

<?}else{?>
<!--    로그인 페이지 아닐 시-->
    <div class="header clearfix">
        <ul class="left_icon f_l">
            <li class="menu"><img src="image/ic_title_menu.png" alt="menu" /></li>
            <li><img src="image/ic_title_refresh.png" alt="refresh" /></li>
            <?if(strpos($_SERVER['REQUEST_URI'], "/web/step1.php") !== false){?>
                <li><img src="image/ic_title_add.png" alt="add" /></li>
                <li class="jPopManage"><img src="image/ic_title_pop.png" alt="pop" /></li>
                <li><img src="image/ic_title_lock.png" alt="lock" /></li><!-- 잠금해제 상태 이미지 ic_title_lock_open.png -->
            <?}?>
        </ul>

        <div class="user_info">
            <select id="jLoginCtrl" style="line-height: 3.5">
                <option><?=$loginInfo["userID"]?></option>
                <option class="jLogout"><?=$locMap["statics"]["logout"]?></option>
            </select>
        </div>

        <ul class="right_icon f_r">
            <!-- <li><img src="image/ic_title_data.png" alt="data" /></li> -->
            <!-- <li><img src="image/ic_title_setting.png" alt="setting" /></li> -->
            <li class="jFullForce" flag="0"><img src="image/ic_title_full.png" alt="full" /></li><!-- 전체화면 해제 이미지 ic_title_small.png -->
        </ul>
    </div>
<?}?>


	