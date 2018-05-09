<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/metaData.php"; ?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title><?=$PROJECT_NAME?> 관리자</title>
    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="../assets/styles.css" rel="stylesheet" media="screen">
    <link href="../assets/DT_bootstrap.css" rel="stylesheet" media="screen">
    <!--[if lte IE 8]>
    <script language="javascript" type="text/javascript" src="../vendors/flot/excanvas.min.js"></script><![endif]-->
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="../vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="../vendors/jquery-1.9.1.js"></script>
</head>

<?
    $initFlag = "";
    if(isset($_REQUEST["initFlag"])) $initFlag = $_REQUEST["initFlag"];
?>

<script>
    var initFlag = "<?=$initFlag?>";

    $(document).ready(function(){

        if(initFlag == "0"){
            loadPage($(".leftMenuItemPickle").eq(0).attr("toGo"));
        }

        $(".leftMenuItemPickle").click(function(e){
            e.preventDefault();
            var toGo = $(this).attr("toGo");
            loadPage(toGo);
        });

        function loadPage(uri){
            $.ajax({
                method : 'GET',
                dataType : 'HTML',
                cache : false,
                url : uri,
                beforeSend : function(){
                    $(".mainLayout").fadeOut();
                },
                success : function(data){
                    $(".mainLayout").html(data);
                    $(".mainLayout").fadeIn();
                },
                error : function(req, res, msg){
                    $(".mainLayout").hide();
                }
            });
        }
    });
</script>

<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#"><?=$PROJECT_NAME?> 관리자</a>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> Vincent Gabriel <i class="caret"></i>
                            
                        </a>
                        <ul class="dropdown-menu">
                            <li class="divider"></li>
                            <li>
                                <a tabindex="-1" href="../login.html">로그아웃</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <? include $_SERVER['DOCUMENT_ROOT']."/admin/commons/topNavigator.php" ?>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3" id="sidebar">
            <? include $_SERVER['DOCUMENT_ROOT']."/admin/commons/navigator.php"; ?>
        </div>
        <!--/span-->
        <div class="span9 mainLayout" id="content">