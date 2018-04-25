<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Web.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php" ;?>

<?
    $obj = new WebUser($_REQUEST);

?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/web/php/metaData.php" ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="title" content="Richware Dictionary">
    <title>Richware Dictionary</title>
    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <script src="js/html5shiv.min.js"></script>
</head>

<link rel="stylesheet" type="text/css" href="css/common.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/sweetalert.css">
<script type="text/javascript" src="js/sweetalert.min.js"></script>
<script type="text/javascript" src="/common/js/jquery_rich/RichBaseExtends.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<link href="./css/bootstrap.min.css" rel="stylesheet">
<link href="./css/metisMenu.min.css" rel="stylesheet">
<link href="./css/timeline.css" rel="stylesheet">
<link href="./css/startmin.css" rel="stylesheet">
<link href="./css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script>
//    swal({title:"",text:"아이디와 비밀번호가 일치하지 않습니다.", type:"warning"}, function(isConfirm){location.reload();});
    $(document).ready(function(){

        $(".jLogin").click(function(){

            var userID = $("#userID").val();
            var userPwd = $("#userPwd").val();

            if(userID == "") {
                alert("아이디를 입력해 주세요");
                return;
            }

            $.ajax({
                url : "/action_front.php?cmd=WebUser.userLogin",
                async : false,
                cache : false,
                dataType : "json",
                data : {
                    "userID" : userID,
                    "userPwd" : userPwd
                },
                success : function(data){
                    if(data.returnCode == 1){
                        location.href = "/web/main.php";
                    }
                    else if(data.returnCode == -2)
                        swal({title:"",text:"올바른 값을 입력해 주세요", type:"warning"});
                    else{
                        swal({title:"",text:"아이디 혹은 비밀번호가 일치하지 않습니다.", type:"warning"});
                    }
                },
                error : function(req, res, err){
                    alert(req+res+err);
                }
            });
        });

        $("#userID").focus();
        $("#userID, #userPwd").enterHandling($(".jLogin"));
    });

</script>

<body class="login_page">
	
<form id="fm1">
    <div class="login">

<!--        <h1><i class="fa fa-chain-broken fa-fw"></i>Masquerader</h1>-->
        <img src="./image/title_mas.png" style="height: 130px; width: 350px;"/>
        <div class="login_input">
            <input type="text" id="userID" name="userID" placeholder="성명" />
            <input type="password" id="userPwd" name="userPwd" placeholder="휴대폰 번호" />
        </div>

        <input type="button" class="jLogin" name="" value="LOGIN" />
    </div>
</form>

</body>
</html>