<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/metaData.php"; ?>
<?
    $obj = new AdminMain($_REQUEST);

    $type = $_REQUEST["type"];

    if($type == "0" || $type == "") $list = $obj->getSearchList();
    if($type == "1") $list = $obj->getManSearchList();
    if($type == "2") $list = $obj->getGearSearchList();

//    echo json_encode($list);
?>
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
                <div class="muted pull-left">구인 리스트</div>
            </div>
            <div class="block-content collapse in">
                <div class="span12">
                    <div class="searchArea" align="center">
                        <input type="text" class="search-query" id="searchTxt" placeholder="등록자 아이디 검색" value="<?=$_REQUEST["searchTxt"]?>"> <button class="btn jSearch">검색</button>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
                        <thead>
                        <tr>
                            <th>등록자</th>
                            <th>위치</th>
                            <th>작업명</th>
                            <th>시작일~종료일</th>
                            <th>숙소제공</th>
                            <th>단가</th>
                            <th>타입</th>
                            <th>등록일시</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?foreach($list as $row){?>
                            <tr class="odd">
                                <td class="center"><?=$row["nm"] . "(" . $row["account"] . ")"?></td>
                                <td class="center"><?=$row["sidoTxt"] . " " . $row["gugunTxt"]?></td>
                                <td class="center"><?=$row["name"]?></td>
                                <td class="center"><?=$row["startDate"] . " ~ " . $row["endDate"]?></td>
                                <td class="center"><?=$row["lodging"] == "1" ? "Y" : "N"?></td>
                                <td class="center"><?=$row["discussLater"]==0 ? $row["price"] : $row["price"] . "(추후협의)"?></td>
                                <td class="center"><?=$row["type"] == "M" ? "인력" : "장비"?></td>
                                <td class="center"><?=$row["regDate"]?></td>
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
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/footer.php"; ?>