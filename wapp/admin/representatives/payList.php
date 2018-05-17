<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/metaData.php"; ?>
<?
    $obj = new AdminMain($_REQUEST);

    $type = $_REQUEST["type"];

    if($type == "0" || $type == "") $list = $obj->getPaymentList();
    if($type == "1") $list = $obj->getuserListForPoint();
    if($type == "2") $list = $obj->getSupplyList();
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

                $('input').on("keydown", function(event){
                    if (event.keyCode == 13) {
                        $(".jSearch").trigger("click");
                    }
                });

                $(".excel").click(function(){
                    var sText = "<?=$_REQUEST["searchTxt"]?>";
                    location.href="./excels/excelPayList.php?searchTxt=" + sText;
                });

                $("#sType").change(function(){
                    $("[name=searchType]").val($(this).val());
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
                <input type="hidden" name="searchType" value="<?=$_REQUEST["searchType"]?>"/>
            </form>

            <div class="block">
                <div class="navbar navbar-inner block-header">
                    <div class="muted pull-left">결제 리스트</div>
                </div>
                <div class="block-content collapse in">
                    <div class="span12">
                        <div class="searchArea" align="center">
                            <select id="sType" style="width: 12%; margin-bottom: 0px;">
                                <option value="0" <?=$_REQUEST["searchType"] == "0" ? "selected" : ""?>>아이디</option>
                                <option value="1" <?=$_REQUEST["searchType"] == "1" ? "selected" : ""?>>이름</option>
                                <option value="2" <?=$_REQUEST["searchType"] == "2" ? "selected" : ""?>>휴대폰번호</option>
                            </select>
                            <input type="text" class="search-query" id="searchTxt" placeholder="검색" value="<?=$_REQUEST["searchTxt"]?>"> <button class="btn jSearch">검색</button>

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
                                    <td class="center">
                                        <?
                                            $time = strtotime($row["authDate"]);
                                            $newformat = date('Y-m-d H:i:s',$time);
                                            echo $newformat;
                                        ?>
                                    </td>
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
    <?}else if($type == "1"){?>
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

                $("#sType").change(function(){
                    $("[name=searchType]").val($(this).val());
                });
            });
        </script>

        <form class="form-horizontal" name="form" action="#">
            <input type="hidden" name="type" value="<?=$_REQUEST["type"]?>"/>
            <input type="hidden" name="searchType" value="<?=$_REQUEST["searchType"]?>"/>
            <div class="control-group">
                <label class="control-label" for="inputEmail">이름</label>
                <div class="controls">
                    <select id="sType" style="width: 12%; margin-bottom: 0px;">
                        <option value="0" <?=$_REQUEST["searchType"] == "0" ? "selected" : ""?>>아이디</option>
                        <option value="1" <?=$_REQUEST["searchType"] == "1" ? "selected" : ""?>>이름</option>
                        <option value="2" <?=$_REQUEST["searchType"] == "2" ? "selected" : ""?>>휴대폰번호</option>
                    </select>
                    <input type="text" name="searchTxt" placeholder="검색" value="<?=$_REQUEST["searchTxt"]?>">
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
                <label class="control-label" for="inputPassword">지급 금액</label>
                <div class="controls">
                    <input type="number" id="amount" placeholder="금액">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <a class="btn btn-success jAdd">금액 지급</a>
                </div>
            </div>
        </form>
    <?}else if($type == "2"){?>

    <div class="row-fluid">
        <form name="form">
            <input type="hidden" name="type" value="<?=$_REQUEST["type"]?>"/>
            <input type="hidden" name="searchType" value="<?=$_REQUEST["searchType"]?>"/>
            <input type="hidden" name="searchTxt"/>
            <input type="hidden" name="page"/>
        </form>

        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left">수기 지급 내역</div>
            </div>
            <div class="block-content collapse in">
                <div class="span12">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
                        <thead>
                        <tr>
                            <th>유저 아이디</th>
                            <th>금액</th>
                            <th>휴대폰번호</th>
                            <th>지급일시</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?foreach($list as $row){?>
                            <tr class="odd">
                                <td class="center"><?=$row["account"]?></td>
                                <td class="center"><?=$row["inc"]?></td>
                                <td class="center"><?=$row["phone"]?></td>
                                <td class="center"><?=$row["rd"]?></td>
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
    <?}?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/footer.php"; ?>