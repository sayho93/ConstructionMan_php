<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-09
 * Time: 오후 3:23
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php"; ?>
<?
    $obj = new WebUser($_REQUEST);
    $regionList = $obj->getRegionList();
    $regionList = json_decode($regionList)->data;
?>

    <script>
        let currentPage = 1;
        let currentItems = 0;
        let totalRows = 0;
        $(document).ready(function(){
            setHeaderTitle("근무지 추가");
            searchCompany(new sehoMap());

            $(".jSearch").click(function(){
                $(".listArea").html("");
                searchCompany(
                    new sehoMap()
                        .put("page", 1).put("sido", $("#sido").val()).put("gungu", $("#gungu").val()).put("search", $("#search").val())
                );
                currentPage = 1;
                currentItems = 0;
            });

            $(window).scroll(function(){
                if(currentItems >= totalRows) return;
                if($(window).scrollTop() === $(document).height() - $(window).height()) searchCompany(new sehoMap().put("page", ++currentPage));
            });

            $("#sido").change(function(){
                let ajax = new AjaxSender(action + "WebUser.getCityList", false, "json", new sehoMap().put("regionID", $("#sido").val()));
                ajax.send(function(data){
                        $("#gungu").html("");
                        $("#gungu").append("<option value='-1'>전체</option>");
                    for(let i=0; i<data.data.length; i++){
                        let row = data.data[i];
                        $("#gungu").append("<option value='" + row.gugunID + "'>" + row.description + "</option>");
                    }
                });
            });

            $(document).on("click", ".jAdd", function(){
                let ajax = new AjaxSender(action + "WebUser.matchCompany", true, "json", new sehoMap().put("companyId", $(this).attr("no")).put("permission", 130));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        showPop(new sehoMap().put("popText", "등록되었습니다"), null, function(){
                            location.href = "/userApp/main.php"
                        });
                    }
                });
            });
        });

        function searchCompany(map){
            let ajax = new AjaxSender(action + "WebUser.getCompanyList", true, "json", map);
            ajax.send(function(data){
                totalRows = data.data.pageInfo.totalRow;
                for(let i=0; i<data.data.list.length; i++){
                    let template = $("#listTemplate").html();
                    let row = data.data.list[i];
                    template = template.replace("#{name}", row.name);
                    template = template.replace("#{call}", row.phone);
                    template = template.replace("#{addr}", row.phone);
                    template = template.replace("#{no}", row.id);
                    $(".listArea").append(template);
                }
                currentItems += data.data.list.length;
            });
        }
    </script>

    <div class="bg_search clearfix">
        <h5 class="gray left">※ 회사명 또는 지역 검색을 통해 근무지를 선택해 주세요.</h5>
        <p class="mt5">
            <select class="select2" id="sido" style="width:calc(50% - 5px);">
                <option value="-1">전체</option>
                <?for($i=0; $i<sizeof($regionList); $i++){?>
                <option value="<?=$regionList[$i]->sidoID?>"><?=$regionList[$i]->description?></option>
                <?}?>
            </select>
            <select class="select2 ml5" id="gungu" style="width:calc(50% - 5px);">
                <option value="01">전체</option>
            </select>
        </p>
        <p class="mt10">
            <input type="text" id="search" class="inputbox" style="width:calc(75% - 22px);">
            <button type="button" class="btn_search btn_blue jSearch"><img src="/userApp/image/btn_search.png"> 검색</button>
        </p>
    </div>
    <hr>

    <h2 class="center mt20">검색 결과</h2>

    <div class="listArea">      </div>

    <div id="listTemplate" style="display: none;">
        <dl class="list_search">
            <dt>
                <div class="name">#{name}</div>
                <div class="call">#{call}</div>
            </dt>
            <dd>
                <div class="adr">#{addr}</div>
                <div class="flex3"><button type="button" class="btn_blue btn_bigh t14px jAdd" no="#{no}">추가</button></div>
            </dd>
        </dl>
    </div>

    <div class="popArea">   </div>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/footer.php" ;?>