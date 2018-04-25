<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Web.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php" ;?>
<?
    $obj = new WebUser($_REQUEST);
    $user = $obj->webUser;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Masquerader</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    <link href="../css/timeline.css" rel="stylesheet">
    <link href="../css/startmin.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<!--    sweetAlert-->
    <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
    <script type="text/javascript" src="../js/sweetalert.min.js"></script>
<!--    map-->
    <script type="text/javascript" src="/modules/sehoMap/sehoMap.js"></script>
<!--    ajaxCall-->
    <script type="text/javascript" src="/modules/ajaxCall/ajaxClass.js"></script>



</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php"><i class="fa fa-chain-broken fa-fw"></i>Masquerader</a>
        </div>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <ul class="nav navbar-nav navbar-left navbar-top-links">
        </ul>

        <ul class="nav navbar-right navbar-top-links">
            <li>
                <a class="" data-toggle="" href="#">
                    <i class="fa fa-info fa-fw"></i> <?="최근 접속일자 ".$user->lastLogin?> </b>
                </a>
            </li>

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <?=$user->name?> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="../login.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.php" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="training.php" class="active"><i class="fa fa-database fa-fw"></i> Training Center</a>
                    </li>
                    <li>
                        <a href="logs.php" class="active"><i class="fa fa-history fa-fw"></i> Logs</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>