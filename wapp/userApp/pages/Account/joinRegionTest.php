<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 5. 30.
 * Time: PM 4:06
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
    $obj = new WebUser($_REQUEST);
    $regionList = $obj->getSidoList();
    $regionList = json_decode($regionList)->data;
?>

<script>
    var regionArr = [];
    var workArr = [];


    $(document).ready(function(){
        $(".jBack").click(function(){history.go(-1)});

        $(".popBody").niceScroll({autohidemode:'false'});

        $(".regionItem").click(function(){
            var regionID = $(this).attr("no");

            if(regionID == "0"){
                if($(this).hasClass("on")){
                    $(this).removeClass("on");
                    regionArr.splice(regionArr.indexOf("0"), 1);
                }
                else{
                    $(".regionItem").removeClass("on");
                    $(".regionItem").attr("gugunId", "");
                    $(".regionItem").find("#box").html("-");

                    $(this).addClass("on");
                    regionArr.push("0");
                }
            }
            else{
                if(regionArr.indexOf("0") > -1){
                    alert("전국 선택시 다른 지역은 선택이 불가합니다.");
                    return;
                }
                else{

                    if($(this).hasClass("on")){
                        $(this).removeClass("on");
                        $(this).attr("gugunId", "");
                        $(this).find("#box").html("-");
                        regionArr.splice(regionArr.indexOf(regionID), 1);
                    }
                    else{
                        getGugunList(regionID);
                        regionArr.push(regionID);
                    }
                }
            }
        });

        function getGugunList(sidoId){
            $(".popBody").empty();
            var params = new sehoMap().put("sidoID", sidoId);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.getGugunList", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode == 1){
                    //20180524 sayho
                    var template = $(".listTemplate").html();
                    template = template.replace("#{no}", data.data[0].sidoID * -1);
                    template = template.replace("#{text}", "전체");
                    template = template.replace("#{prt}", data.data[0].sidoID);
                    $(".popBody").append(template);

                    for(var i=0; i<data.data.length; i++){
                        var template = $(".listTemplate").html();
                        template = template.replace("#{no}", data.data[i].gugunID);
                        template = template.replace("#{text}", data.data[i].description);
                        template = template.replace("#{prt}", data.data[i].sidoID);
                        $(".popBody").append(template);
                    }
                    $(".popBG").show();
                }
                else
                    alert("구/군 리스트 조회 실패");
            });
        }

        function collectGugunId(){
            var regionArr = $(".regionItem");
            var toRet = [];
            var cursor = 0;
            for(var e = 0; e < regionArr.length; e++){
                var value = regionArr.eq(e).attr("gugunId");
                if(value != "" && value != null) toRet[cursor++] = value;
            }
            return toRet;
        }

        function collectWorkId(){
            var workArr = $(".jobItem.on");
            var toRet = [];
            for(var i=0; i<workArr.length; i++){
                var value = workArr.eq(i).attr("no");
                toRet.push(value);
            }
            return toRet;
        }

        $(document).on("click", ".listItem", function(){
            var text = $(this).find("span").html();

            var thisId = $(this).attr("no");
            var parentId = $(this).attr("parentId");
            var parentObj = $(".regionItem[no="+ parentId +"]");
            if(parentObj == null) {
                return;
            }

            parentObj.attr("gugunId", thisId);
            parentObj.addClass("on");

            parentObj.find("#box").html(text);
            parentObj.find("#box").show();
            $(".popBG").hide();
        });


        $(".jClose").click(function(){
            $(".popBG").hide();
        });

        $(".tabContent").hide();
        $(".tabContent:first").show();

        $(".item").click(function(){
            $(".item").removeClass("on");
            $(this).addClass("on");
            $(".tabContent").hide();
            var activeTab = $(this).attr("rel");
            $("#" + activeTab).show();
        });

        $(".jobItem").click(function(){
            if($(this).hasClass("on"))
                $(this).removeClass("on");
            else
                $(this).addClass("on");
        });

        $("#next").click(function(){
            var regionArr = collectGugunId();
            var workArr = collectWorkId();

            regionArr = regionArr.join();
            if(regionArr == "") regionArr = "0";
            workArr = workArr.join();
            if(workArr == ""){
                alert("직종을 선택해 주시기 바랍니다.");
                return;
            }
            $("[name='regionArr']").val(regionArr);
            $("[name='workArr']").val(workArr);

            var str = $("[name='form']").serialize();

            location.href = "joinManStep2.php?" + str;
        });
    });

</script>

<div class="popBG" style="display: none;">
    <div class="popIcon jClose"></div>
    <div class="popArea">
        <div class="popHeaderWrap">
            <div class="popHeader">
                지역 선택
            </div>
        </div>
        <div class="popBody">

        </div>
    </div>
</div>

<div class="listTemplate" style="display: none;">
    <div class="listItem" no="#{no}" parentId="#{prt}"><span>#{text}</span></div>
</div>


<body>
<div class="header">
    <h2>회원가입</h2>
</div>

<div class="body">
    <div class="region">
        <p>희망지역<span>(중복선택가능)</span></p>
        <div id="table">
            <ul>
                <li class="regionItem" no="1" gugunId=""><text>전국</text> <div id="box">-</div></li>
                <li class="regionItem" no="2" gugunId=""><text>서울</text> <div id="box">-</div></li>
                <li class="regionItem" no="3" gugunId=""><text>부산</text> <div id="box">-</div></li>
                <li class="regionItem" no="4" gugunId=""><text>인천</text> <div id="box">-</div></li>
                <li class="regionItem" no="5" gugunId=""><text>대구</text> <div id="box">-</div></li>
            </ul>
            <ul>
                <li class="regionItem" no="6" gugunId=""><text>대전</text> <div id="box">-</div></li>
                <li class="regionItem" no="7" gugunId=""><text>경기</text> <div id="box">-</div></li>
                <li class="regionItem" no="8" gugunId=""><text>경남</text> <div id="box">-</div></li>
                <li class="regionItem" no="9" gugunId=""><text>경북</text> <div id="box">-</div></li>
                <li class="regionItem" no="10" gugunId=""><text>전라</text> <div id="box">-</div></li>
            </ul>
            <ul>
                <li class="regionItem" no="11" gugunId=""><text>충청</text> <div id="box">-</div></li>
                <li class="regionItem" no="12" gugunId=""><text>강원</text> <div id="box">-</div></li>
                <li class="regionItem" no="13" gugunId=""><text>제주</text> <div id="box">-</div></li>
            </ul>
        </div>
    </div>

    <div class="jobClass">
        <p>직종선택</p>
        <div id="itemWrapper">
            <div class="item on" rel="tab1"><text>건축</text></div>
            <div class="item" rel="tab2"><text>기계설비</text></div>
            <div class="item" rel="tab3"><text>전기<br>통신<br>소방</text></div>
            <div class="item" rel="tab4"><text>관리자</text></div>
            <div class="item" rel="tab5"><text>인테리어</text></div>
        </div>

        <div class="align_center">
            <a href="#" id="middleArea"></a>
        </div>

        <div class="jobTable">
            <div class="tabContent" id="tab1">
                <div class="jobItem"><text>콘크리트공</text></div>
                <div class="jobItem"><text>철근공</text></div>
                <div class="jobItem"><text>조적공</text></div>
                <div class="jobItem"><text>석공</text></div>
                <div class="jobItem"><text>타일공</text></div>
                <div class="jobItem"><text>수장공</text></div>
                <div class="jobItem"><text>방수공</text></div>
                <div class="jobItem"><text>비계공</text></div>
                <div class="jobItem"><text>미장공</text></div>
                <div class="jobItem"><text>견출공</text></div>
                <div class="jobItem"><text>도장공</text></div>
                <div class="jobItem"><text>부대토목공</text></div>
                <div class="jobItem"><text>형틀목공</text></div>
                <div class="jobItem"><text>지붕및홈통공</text></div>
            </div>

            <div class="tabContent" id="tab2">
                <div class="jobItem"><text>배관공</text></div>
                <div class="jobItem"><text>용접공</text></div>
                <div class="jobItem"><text>보온공</text></div>
                <div class="jobItem"><text>덕트설비공(공조,냉동,보일러)</text></div>
                <div class="jobItem"><text>위생설비공(변기,세면기,욕조)</text></div>
                <div class="jobItem"><text>소화설비공(소화전,스프링쿨러)</text></div>
                <div class="jobItem"><text>도비공(기계설치공)</text></div>
            </div>

            <div class="tabContent" id="tab3">
                <div class="jobItem"><text>송전공</text></div>
                <div class="jobItem"><text>배전공</text></div>
                <div class="jobItem"><text>내선공</text></div>
                <div class="jobItem"><text>플랜트공(제어공)</text></div>
                <div class="jobItem"><text>계장공</text></div>
                <div class="jobItem"><text>통신공</text></div>
                <div class="jobItem"><text>소방전기공</text></div>
                <div class="jobItem"><text>케이블포설공</text></div>
            </div>

            <div class="tabContent" id="tab4">
                <div class="jobItem"><text>공사관리자</text></div>
                <div class="jobItem"><text>공무관리자</text></div>
                <div class="jobItem"><text>설계관리자</text></div>
                <div class="jobItem"><text>안전관리자</text></div>
            </div>

            <div class="tabContent" id="tab5">
                <div class="jobItem"><text>도배공(장판)</text></div>
                <div class="jobItem"><text>목공(내장)</text></div>
                <div class="jobItem"><text>전기통신소방</text></div>
                <div class="jobItem"><text>타일공</text></div>
                <div class="jobItem"><text>미장공</text></div>
                <div class="jobItem"><text>간판공(실사)</text></div>
                <div class="jobItem"><text>냉난방시설공</text></div>
                <div class="jobItem"><text>샷시공</text></div>
                <div class="jobItem"><text>도장공</text></div>
            </div>
        </div>
    </div>

    <div class="center">
        <a href="#" id="next"></a>
    </div>

    <div class="footer">
        <span>휴넵스/건설인</span>
        <br>
        <p>대표 : 이화수 / 사업자등록번호 : 111-222-3333333</p>
        <p>주소 : 대전광역시 유성구 봉명동 1111</p>
        <p>TEL : 1644-1111 / MAIL : geonseolin@geonseolin.com</p>
        <br><br>
        <p>ⓒ휴넵스 All rights reserved.</p>
    </div>
</div>

</body>
</html>
