<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/metaData.php"; ?>
<?
$obj = new AdminMain($_REQUEST);

$type = $_REQUEST["type"];

if($type == "0" || $type == "") $list = $obj->getPaymentList();
?>
    <?if($type == "0" || $type == ""){?>
        <script>
            $(document).ready(function(){
                $(".jPage").click(function(){
                    $("[name=page]").val($(this).attr("page"));
                    form.submit();
                });

                $(".jSearch").click(function(){
                    $("[name=searchTxt]").val($("#searchTxt").val());
                    $("[name=form]").submit();
                });
            });
        </script>

        <style>
            .center{
                text-align:center;
            }
        </style>

        <div class="row-fluid">
            <form name="form">
                <input type="hidden" name="type" value="<?=$_REQUEST["type"]?>"/>
                <input type="hidden" name="searchTxt"/>
                <input type="hidden" name="page"/>
            </form>

            <div class="block">
                <div class="navbar navbar-inner block-header">
                    <div class="muted pull-left">유저 리스트</div>
                </div>
                <div class="block-content collapse in">
                    <div class="span12">
                        <div class="searchArea" align="center">
                            <input type="text" class="search-query" id="searchTxt" placeholder="구매자 휴대폰번호 검색" value="<?=$_REQUEST["searchTxt"]?>"> <button class="btn jSearch">검색</button>
                        </div>
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th>구매자 아이디</th>
                                <th>구매자 이름</th>
                                <th>구매자 전화번호</th>
                                <th>금액</th>
                                <th>승인일자</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?foreach($list as $row){?>
                                <tr class="odd">
                                    <td class="center"><?=$row["account"]?></td>
                                    <td class="center"><?=$row["name"]?></td>
                                    <td class="center"><?=$row["phone"]?></td>
                                    <td class="center"><?=$row["amount"]?></td>
                                    <td class="center"><?=$row["authDate"]?></td>
                                </tr>
                            <?}?>

                            <?if(sizeof($list) == 0){?>
                                <tr class="odd">
                                    <td colspan="7" class="">리스트가 없습니다.</td>
                                </tr>
                            <?}?>
                            </tbody>
                        </table>
                        <?include $_SERVER["DOCUMENT_ROOT"] . "/admin/commons/pageNavigator.php";?>
                    </div>
                </div>
            </div>
        </div>
    <?}else{?>
        <form class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="inputEmail">Email</label>
                <div class="controls">
                    <input type="text" id="inputEmail" placeholder="유저 전화번호로 검색">
                    <button class="btn jSearch">검색</button>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPassword">지급 포인트</label>
                <div class="controls">
                    <input type="password" id="inputPassword" placeholder="Password">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn">포인트 지급</button>
                </div>
            </div>
        </form>
    <?}?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/footer.php"; ?>