<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/metaData.php"; ?>
<?
$obj = new AdminMain($_REQUEST);

$type = $_REQUEST["type"];


?>

    <script>
        $(document).ready(function(){
            $(".submit").click(function(){
                var pass = $("#pwd").val();
                var passConfirm = $("#pwdC").val();

                if(pass != passConfirm){
                    alert("비밀번호가 일치하지 않습니다.");
                    return;
                }

                var params = new sehoMap().put("password", pass);
                var ajax = new AjaxSender("/action_front.php?cmd=AdminMain.changePass", true, "json", params);
                ajax.send(function(data){
                    if(data.returnCode === "1"){
                        alert("변경되었습니다.");
                        location.reload();
                    }
                })
            });
        });
    </script>

    <form class="form-horizontal" name="form" action="#">
        <input type="hidden" name="type" value="<?=$_REQUEST["type"]?>"/>
        <div class="control-group">
            <label class="control-label" for="inputPassword">변경할 패스워드</label>
            <div class="controls">
                <input type="password" id="pwd" placeholder="패스워드">
                <input type="password" id="pwdC" placeholder="패스워드 확인">
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <a class="btn btn-danger submit">변경</a>
            </div>
        </div>
    </form>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/footer.php"; ?>