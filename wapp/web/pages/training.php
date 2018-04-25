<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Web.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php" ;?>
<? include "navigator.php";?>

<script>
    $(document).ready(function(){
        var form = $("[name=form]");

        $("#searchText").keyup(function(event){
            if(event.keyCode === 13)
                $(".jSearch").click();
        });

        $("#message").keyup(function(event){
            if(event.keyCode === 13)
                $(".jSend").click();
        });

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

        $(".jSend").click(function(){
            var msg = $("#message").val();

            $.ajax({
                url: "/web/pages/entityTraining.php",
                async: true,
                cache: false,
                dataType: "html",
                data: {
                    "msg": msg
                },
                success: function (data) {
                    $(".added").remove();
                    $(".timeline").append(data);

                    $("#message").val("");

                }
            });
        });
    });
</script>

            <div id="page-wrapper" style="height: 150%">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header"><i class="fa fa-database fa-fw"></i>Training Center</h1>
                        </div>
                    </div>
<!--                    search Area-->
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
                                                    <input class="form-control" name="searchText" id="searchText" placeholder="Enter text" value="<?=$_REQUEST["searchText"]?>">
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
                    </div>

<!--                    training Area-->
                    <div class="row">
                        <div class="col-lg-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-flask fa-fw"></i> Laboratory
                                </div>
                                <div class="panel-body">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-badge"><i class="fa fa-comment"></i>
                                            </div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">Try : <input type="text" id="message" style="width:50%;"/> <a class="btn btn-primary jSend" >Send</a></h4>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

<!--                    log Area-->
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

<? include "footer.php";?>