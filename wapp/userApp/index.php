<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Web.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php" ;?>
<?
    $autoFlag = $_REQUEST["auto"];
    $userId = $_REQUEST["id"];

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>ConstructionMan</title>
    <link href="/userApp/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/userApp/css/common.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="/userApp/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="/modules/ajaxCall/ajaxClass.js"></script>
<script type="text/javascript" src="/modules/sehoMap/sehoMap.js"></script>
<script type="text/javascript" src="/modules/valueSetter/sayhoValueSetter.js"></script>

<script>
    $(document).ready(function(){
        var autoFlag = "<?=$autoFlag?>";
        var userId = "<?=$userId?>";

        if(autoFlag === "true"){
            var params = new sehoMap();
            params.put("autoFlag", autoFlag).put("userId", userId);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.autoLogin", true, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.href = "/userApp/pages/search/searchMain.php";
                }
            })

        }


        $(".join").click(function(){location.href = "/userApp/pages/Account/memberJoin.php";});
        $(".login").click(function(){location.href = "/userApp/login.php";});
    });



</script>

<body style="background-color: #222222; overflow: scroll!important;">
<div class="main_page">
    <div class="main">
        <a href="#" class="join"></a>
        <a href="#" class="login"></a>
    </div>
</div>
</body>
</html>

