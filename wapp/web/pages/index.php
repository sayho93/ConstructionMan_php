<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Web.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBoard.php" ;?>

<? include "navigator.php";?>
    <script type="text/javascript">
        $(document).ready(function(){
            //enterHandling
            $(document).bind('keypress',inputKeyUp);
            function inputKeyUp(e) {
                e.which = e.which || e.keyCode;
                if(e.which == 13) {
                    $(".jSend").trigger("click");
                }
            }

            //getResponse
            $(".jSend").click(function(){
                var myMap = new sehoMap();
                myMap.put("msg", $("#message").val());
                var ajax = new AjaxSender("/web/pages/entityInstant.php", true, "html", myMap.map);
                var data = ajax.send(function(data){
                    $(".added").remove();
                    $(".timeline").append(data);
                    $("#message").val("");

                });
            });

            //TODO AjaxSender sample source
            var myMap = new sehoMap();
            myMap.put("msg", "aaaaa");
            myMap.put("no", 12);
//            myMap.delete("msg");

            var ajax = new AjaxSender("/web/pages/entityInstant.php", true, "html", myMap.map);
            var data = ajax.send(function(data){
                console.log(data);
            });;





            //dashBoard count refresh func
            function refreshDashBoard(){
                $.ajax({
                    url: "/action_front.php?cmd=WebBoard.getDashBoardData",
                    async: true,
                    cache: false,
                    dataType: "json",
                    success: function (data){
                        var tmpDat = data.data;
                        console.log(tmpDat);
                        $(".jResp").html(tmpDat.responses);
                        $(".jLearned").html(tmpDat.learned);
                        $(".jLinkage").html(tmpDat.linkages);
                    }
                });
            }

            //onload
            refreshDashBoard();
        });
    </script>

    <div id="json"></div>

            <div id="page-wrapper" style="height: 150%">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><i class="fa fa-dashboard fa-fw"></i>Dashboard</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge jResp">0</div>
                                        <div>Total Response</div>
                                    </div>
                                </div>
                            </div>
                            <a>
                                <div class="panel-footer">
                                    <span class="pull-left">&nbsp;</span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge jLearned">0</div>
                                        <div>Total Data</div>
                                    </div>
                                </div>
                            </div>
                            <a href="training.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-link fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge jLinkage">0</div>
                                        <div>Total Linkages</div>
                                    </div>
                                </div>
                            </div>
                            <a href="logs.php?mode=fail">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

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
            </div>
        </div>

<? include "footer.php";?>