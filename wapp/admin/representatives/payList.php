<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/metaData.php"; ?>
<?
    $obj = new AdminMain($_REQUEST);

    $type = $_REQUEST["type"];

    if($type == "0" || $type == "") $list = $obj->getPaymentList();
    if($type == "1") $list = $obj->getuserListForPoint();
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

                $(".excel").click(function(){
                    var sText = "<?=$_REQUEST["searchTxt"]?>";
                    location.href="./excels/excelPayList.php?searchTxt=" + sText;
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
                    <div class="muted pull-left">결제 리스트</div>
                </div>
                <div class="block-content collapse in">
                    <div class="span12">
                        <div class="searchArea" align="center">
                            <input type="text" class="search-query" id="searchTxt" placeholder="구매자 휴대폰번호 검색" value="<?=$_REQUEST["searchTxt"]?>"> <button class="btn jSearch">검색</button>

                            <a class="btn btn-success excel" style="float:right;">엑셀 출력</a>
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
        <script>
            $(document).ready(function(){
                $(".jSearch").click(function(){
                    form.submit();
                });

                $(".jAdd").click(function(){
                    var noArr = new Array();
                    var noCount = $(".chk:checked").length;
                    if(noCount == 0){
                        alert("지급할 사용자를 하나 이상 선택해주세요.");
                        return false;
                    }
                    if(confirm("정말 지급하시겠습니까?")){
                        for(var i = 0; i < noCount; i++){
                            noArr[i] = $(".chk:checked:eq(" + i + ")").attr("no");
                        }
                        addPoint(noArr);
                    }
                });

                function addPoint(noArr){
                    var am = $("#amount").val();
                    if(am == 0 || am == ""){
                        alert("지급/차감할 포인트를 입력하세요.");
                        return;
                    }

                    $.ajax({
                        url: "/action_front.php?cmd=AdminMain.addPoint",
                        async: false,
                        cache: false,
                        // dataType: "json",
                        data: {
                            "no": noArr,
                            amount : am
                        },
                        success: function (data) {
                            if(am > 0) alert("지급되었습니다.");
                            else if(am < 0) alert("차감되었습니다.");

                            location.reload();
                        }
                    });
                }
            });
        </script>

        <form class="form-horizontal" name="form" action="#">
            <input type="hidden" name="type" value="<?=$_REQUEST["type"]?>"/>
            <div class="control-group">
                <label class="control-label" for="inputEmail">이름</label>
                <div class="controls">
                    <input type="text" name="searchTxt" placeholder="유저 이름으로 검색" value="<?=$_REQUEST["searchTxt"]?>">
                    <button class="btn jSearch">검색</button>

                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
                        <thead>
                        <tr>
                            <th>선택</th>
                            <th>아이디</th>
                            <th>이름</th>
                            <th>전화번호</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?foreach($list as $row){?>
                            <tr class="odd">
                                <td class="center"><input class="chk" type="checkbox" no="<?=$row["id"]?>"/></td>
                                <td class="center"><?=$row["account"]?></td>
                                <td class="center"><?=$row["name"]?></td>
                                <td class="center"><?=$row["phone"]?></td>
                            </tr>
                        <?}?>

                        <?if(sizeof($list) == 0){?>
                            <tr class="odd">
                                <td colspan="7" class="">리스트가 없습니다.</td>
                            </tr>
                        <?}?>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPassword">지급 포인트</label>
                <div class="controls">
                    <input type="number" id="amount" placeholder="포인트">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <a class="btn btn-success jAdd">포인트 지급</a>
                </div>
            </div>
        </form>
    <?}?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/footer.php"; ?>