<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/commons/metaData.php"; ?>
<?
$obj = new AdminMain($_REQUEST);

$type = $_REQUEST["type"];

if($type == "0" || $type == "") $list = $obj->getUserList();
if($type == "1") $list = $obj->getManUserList();
if($type == "2") $list = $obj->getGearUserList();
if($type == "3") $list = $obj->getNormalUserList();
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

            $(".sortable").click(function(){
                $("[name=searchTxt]").val($("#searchTxt").val());
                $("[name=toSort]").val($(this).attr("toSort"));
                $("[name=sortDirection]").val($(this).attr("sortDirection"));
                $("[name=form]").submit();
            });

            $(".jDel").click(function(){
                var id = $(this).attr("no");
                $.ajax({
                    method:'GET',
                    url : "/action_front.php?cmd=AdminMain.deleteUser",
                    cache : false,
                    async : true,
                    data : {
                        id : id
                    },
                    success : function(data){
                        alert('삭제되었습니다.');
                        location.reload();
                    }
                }
            );
            });

            $("#jCheckAll").change(function(){
                if($(this).is(":checked"))
                    $(".jUserNo").prop("checked", true);
                else
                    $(".jUserNo").prop("checked", false);
            });

            $(".jDelUserMulti").click(function(){
                var noArr = new Array();
                var noCount = $(".jUserNo:checked").length;
                if(noCount == 0)
                {
                    alert("삭제할 사용자를 하나 이상 선택해주세요.");
                    return false;
                }
                if(confirm("정말 삭제하시겠습니까?")){
                    for(var i = 0; i < noCount; i++ )
                    {
                        noArr[i] = $(".jUserNo:checked:eq(" + i + ")").val();
                    }
                    deleteUser(noArr);
                }
            });

            function deleteUser(noArr){
                $.ajax({
                    url : "/action_front.php?cmd=AdminMain.deleteUserMulti",
                    async : false,
                    cache : false,
                    data : {
                        "no"	: noArr
                    },
                    success : function(data){
                        alert("삭제되었습니다");
                        location.reload();
                    }
                });
            }

            $("#sType").change(function(){
                $("[name=searchType]").val($(this).val());
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
<!--            <input type="hidden" name="target" value="--><?//="/admin/" . $LEFT_MENU_INFO["userList.php"]["전체 회원"]?><!--"/>-->
            <input type="hidden" name="searchType" value="<?=$_REQUEST["searchType"]?>"/>
            <input type="hidden" name="searchTxt"/>
            <input type="hidden" name="page"/>
            <input type="hidden" name="toSort" value="regDate"/>
            <input type="hidden" name="sortDirection" value="DESC"/>
        </form>

        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left">유저 리스트</div>
            </div>
            <div class="block-content collapse in">
                <div class="span12">
                    <div class="searchArea" align="center">
                        <select id="sType" style="width: 12%; margin-bottom: 0px;">
                            <option value="0" <?=$_REQUEST["searchType"] == "0" ? "selected" : ""?>>이름</option>
                            <option value="1" <?=$_REQUEST["searchType"] == "1" ? "selected" : ""?>>ID</option>
                            <option value="2" <?=$_REQUEST["searchType"] == "2" ? "selected" : ""?>>휴대폰번호</option>
                        </select>
                        <input type="text" class="search-query" id="searchTxt" placeholder="검색" value="<?=$_REQUEST["searchTxt"]?>"> <button class="btn jSearch">검색</button>
                        <a class="btn btn-danger excel jDelUserMulti" style="float:right;">선택 삭제</a>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="jCheckAll"></th>
                            <th class="sortable" toSort="name" sortDirection="ASC">이름</th>
                            <th class="sortable" toSort="account" sortDirection="ASC">ID</th>
                            <th class="sortable" toSort="phone" sortDirection="ASC">휴대폰번호</th>
                            <th class="sortable" toSort="age" sortDirection="ASC">연령</th>
                            <th class="sortable" toSort="type" sortDirection="ASC">타입</th>
                            <th class="sortable" toSort="regDate" sortDirection="DESC">가입일시</th>
                            <th>-</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?foreach($list as $row){?>
                            <tr class="odd">
                                <td>
                                    <input type="checkbox" class="jUserNo" value="<?=$row["id"]?>" >
                                </td>
                                <td class="center"><?=$row["name"]?></td>
                                <td class="center"><?=$row["account"]?></td>
                                <td class="center"><?=$row["phone"]?></td>
                                <td class="center"><?=$row["age"] . " 대"?></td>
                                <td class="center">
                                    <?
                                    switch($row["type"]){
                                        case "M":
                                            echo "인력";
                                            break;
                                        case "G":
                                            echo "장비";
                                            break;
                                        case "N":
                                            echo "일반";
                                            break;
                                    }
                                    ?>
                                </td>
                                <td class="center"><?=$row["regDate"]?></td>
                                <td class="center"><button class="btn jDel" no="<?=$row["id"]?>">삭제</button></td>
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