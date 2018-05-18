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
                $("[name=toSort]").val("regDate");
                $("[name=sortDirection]").val("DESC");
                $("[name=form]").submit();
            });

            $('input').on("keydown", function(event){
                if (event.keyCode == 13) {
                    $(".jSearch").trigger("click");
                }
            });

            $(".sortable").click(function(){
                $("[name=searchTxt]").val($("#searchTxt").val());
                $("[name=toSort]").val($(this).attr("toSort"));
                $("[name=sortDirection]").val($(this).attr("sortDirection"));
                $("[name=form]").submit();
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
            <input type="hidden" name="searchType" value="<?=$_REQUEST["searchType"]?>"/>
            <input type="hidden" name="searchTxt"/>
            <input type="hidden" name="page"/>
            <input type="hidden" name="toSort" value="regDate"/>
            <input type="hidden" name="sortDirection" value="DESC"/>
        </form>

        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left">구인 리스트</div>
            </div>
            <div class="block-content collapse in">
                <div class="span12">
                    <div class="searchArea" align="center">
                        <select id="sType" style="width: 12%; margin-bottom: 0px;">
                            <option value="0" <?=$_REQUEST["searchType"] == "0" ? "selected" : ""?>>아이디</option>
                            <option value="1" <?=$_REQUEST["searchType"] == "1" ? "selected" : ""?>>이름</option>
                        </select>
                        <input type="text" class="search-query" id="searchTxt" placeholder="검색" value="<?=$_REQUEST["searchTxt"]?>"> <button class="btn jSearch">검색</button>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
                        <thead>
                        <tr>
                            <th class="sortable" toSort="nm" sortDirection="ASC">등록자</th>
                            <th class="sortable" toSort="sidoTxt, gugunTxt" sortDirection="ASC">위치</th>
                            <th class="sortable" toSort="name" sortDirection="ASC">작업명</th>
                            <th class="sortable" toSort="startDate" sortDirection="ASC">시작일~종료일</th>
                            <th class="sortable" toSort="lodging" sortDirection="ASC">숙소제공</th>
                            <th class="sortable" toSort="price" sortDirection="ASC">단가</th>
                            <th class="sortable" toSort="type" sortDirection="ASC">타입</th>
                            <th class="sortable" toSort="regDate" sortDirection="DESC">등록일시</th>
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