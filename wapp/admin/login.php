<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 5. 14.
 * Time: PM 7:18
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Admin.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php" ;?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
    <script src="/admin/vendors/jquery-1.9.1.js"></script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<!--    <script src="/admin/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->

    <script type="text/javascript" src="/modules/ajaxCall/ajaxClass.js"></script>
    <script type="text/javascript" src="/modules/sehoMap/sehoMap.js"></script>
</head>

<script>
    $(document).ready(function(){
        $(".jLogin").click(function(){
            var params = new sehoMap();
            params.put("account", $("[name=account]").val());
            params.put("password", $("[name=password]").val());
            var ajax = new AjaxSender("/action_front.php?cmd=AdminMain.login", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.href = "/admin/representatives/userList.php";
                }
            });
        });
    });
</script>

<body id="login">
<div class="container">

    <div class="form-signin">
        <h2 class="form-signin-heading">Admin Login</h2>
        <input type="text" name="account" class="input-block-level" placeholder="Account">
        <input type="password" name="password" class="input-block-level" placeholder="Password">
<!--        <label class="checkbox">-->
<!--            <input type="checkbox" value="remember-me"> Remember me-->
<!--        </label>-->
        <button class="btn btn-large btn-primary jLogin">Sign in</button>
    </div>

</div> <!-- /container -->
<script src="vendors/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>