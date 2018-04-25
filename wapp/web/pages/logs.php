<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Web.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBoard.php" ;?>

<?
    $obj = new WebBoard($_REQUEST);

    $ret = $obj->searchLog();
    $json = $ret->pageInfo;
    $list = $ret->list;
    $virtualNum = $ret->pageInfo->virtualNum;
?>
<? include "navigator.php";?>

<style>
    th {text-align: center}
</style>

<script>
    $(document).ready(function(){
        var form = $("[name=form]");

        $(".jSearch").click(function(){
            form.submit();
        });

        $(".jPage").click(function(){
            var page = $(this).attr("page");
            $.ajax({
                url: "/modules/page/pageTag.php",
                async: false,
                cache: false,
                dataType: "html",
                data: {
                    "page": page
                },
                success: function (data) {
                    $("[name=form]").append(data);
                }
            });
            form.submit();
        });

        $(".jDelete").click(function(){
            var no = $(this).attr("no");
            $.ajax({
                url: "/action_front.php?cmd=WebBoard.deleteLog",
                async: false,
                cache: false,
                data : {
                    "no" : no
                },
                dataType: "json",
                success: function (data) {
                    if(data.returnCode == "1") {
                        swal({title:"",text:"삭제되었습니다.", type:"success"}, function(isConfirm){location.reload();});
                        location.reload();
                    }
                }
            });
        });

    });
</script>
            <div id="page-wrapper" style="height: 150%">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"><i class="fa fa-history fa-fw"></i>Logs</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Search
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <form name="form" role="form">
                                                <div class="form-group">
                                                    <input class="form-control" name="searchText" placeholder="Enter text" value="<?=$_REQUEST["searchText"]?>">
                                                </div>
                                                <button type="button" class="btn btn-default btn-sm jSearch">
                                                    <span class="glyphicon glyphicon-search"></span> Search
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>출발어</th>
                                                        <th>참조어</th>
                                                        <th>출발 POS</th>
                                                        <th>참조 POS</th>
                                                        <th>방향</th>
                                                        <th>빈도</th>
                                                        <th>갱신일</th>
                                                        <th>등록일</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?for($i = 0; $i < sizeof($list); $i++){
                                                        $row = $list[$i];
                                                        ?>
                                                        <tr>
                                                            <th><?=$virtualNum--?></th>
                                                            <td><?=$row->word?></td>
                                                            <td><?=$row->refWord?></td>
                                                            <td><?=$row->tag?></td>
                                                            <td><?=$row->refTag?></td>
                                                            <td><?=$row->reverse == "0" ? "순행" : "역행"?></td>
                                                            <td><?=$row->frequency?></td>
                                                            <td><?=$row->uptDate?></td>
                                                            <td><?=$row->regDate?></td>
                                                            <td style="text-align: center"><a class="btn btn-danger jDelete" no="<?=$row->no?>">Delete</a></td>
                                                        </tr>
                                                    <?}?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <? include $_SERVER["DOCUMENT_ROOT"] ."/modules/page/pageNavigation.php";?>
                    </div>
                </div>
            </div>
        </div>


<? include "footer.php";?>