<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-15
 * Time: 오전 9:56
 */
?>
<?include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php";?>
<?include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<script>
    $(document).ready(function(){
        setHeaderTitle("근무지 관리");
        getMyWorkPlace();

        $(document).on("click", ".jDel", function(){
            let companyId = $(this).attr("no");
            let map = new sehoMap().put("popText", "해당 근무지를 삭제하시겠습니까?<br>삭제 시 해당 근무지의 근태 및 급여 내역을 조회하실 수 없습니다.");
            showPop(
                map,
                function(){
                    let ajax = new AjaxSender(action + "WebUser.deleteWorkplace", false, "json", map.put("companyId", companyId));
                    ajax.send(function(data){
                        $("#listArea").empty();
                        getMyWorkPlace();
                    });
                },
                function(){}
            );
        });

        $(".jAdd").click(function(){location.href = "/userApp/pages/workPlace/addWorkPlace.php";});

        //TODO 주근무지 선택
        $(".jSet").click(function(){

        });

        //TODO 근무지 상세보기 소속, 직급
        $(document).on("click", ".jView", function(){
            let ajax = new AjaxSender(action + "WebUser.getWorkPlaceDetail", false, "json", new sehoMap().put("companyId", $(this).attr("no")));
            ajax.send(function(data){
                const row = data.data;
                $("#companyName").html(row.name);
                let addrTxt = row.sidoTxt + " " + row.gunguTxt;
                if(row.dongTxt !== undefined)  addrTxt += " " + row.dongTxt;

                $("#companyAddr").html(addrTxt);
                $("#companyTel").html(row.phone);
                $("#popup1").show();
            });

        });

        $(document).on("click", ".jCode", function(){location.href = "/userApp/pages/workPlace/confirmWorkPlace.php?companyId=" + $(this).attr("no");});
    });

    function getMyWorkPlace(){
        let ajax = new AjaxSender(action + "WebUser.getMyWorkplace", false, "json", new sehoMap());
        ajax.send(function(data){
            let list = data.data;

            for(let i=0; i<list.length; i++){
                let row = list[i];
                let listTemplate = $("#listTemplate").html();
                let btnTemplate = $("#btnTemplate").html();

                if(row.isApproved === 1){
                    btnTemplate = btnTemplate.replace(/{#color}/gi, "btn_gray");
                    btnTemplate = btnTemplate.replace(/{#name}/gi, "보기");
                    btnTemplate = btnTemplate.replace(/{#type}/gi, "jView");
                }
                else{
                    btnTemplate = btnTemplate.replace(/{#color}/gi, "btn_blue");
                    btnTemplate = btnTemplate.replace(/{#name}/gi, "승인코드");
                    btnTemplate = btnTemplate.replace(/{#type}/gi, "jCode");
                }
                btnTemplate = btnTemplate.replace(/{#companyId}/gi, row.companyId);

                listTemplate = listTemplate.replace(/{#radioId}/gi, "c" + i);
                listTemplate = listTemplate.replace(/{#name}/gi, row.companyName);
                listTemplate = listTemplate.replace(/{#viewable}/gi, btnTemplate);
                listTemplate = listTemplate.replace(/{#companyId}/gi, row.companyId);
                $("#listArea").append(listTemplate);

                if(row.isPrimary === 1) $("#c" + i).prop("checked", true);
            }
        });
    }
</script>

<div id="listTemplate" style="display:none">
    <div class="noticelist clearfix">
        <div class="f_l mt5">
            <input type="radio" id="{#radioId}" name="company">
            <label for="{#radioId}"><i></i> {#name}</label>
        </div>
        <div class="f_r">
            {#viewable}
            <button type="button" class="btn_gray btn_middleh jDel" no="{#companyId}" style="width:30px;"><img src="/userApp/image/btn_del.png" width="12"></button>
        </div>
    </div>
</div>

<div id="btnTemplate" style="display:none">
    <button type="button" class="{#color} btn_middleh t12px {#type}" style="width:60px;" no="{#companyId}">{#name}</button>
</div>

<div class="bg_search left">
    <h5 class="gray">※ 아래 근무지 중에서 원하는 근무지를 선택해 주세요.</h5>
</div>
<hr>

<div id="listArea"> </div>

<div class="bg_btn flex">
    <button type="button" class="btn_blue btn_bigh jAdd" onclick="location.href='company_add.html';">근무지 추가</button>
    <button type="button" class="btn_gray btn_bigh ml5 jSet">확인</button>
</div>

<div class="popArea">   </div>

<div id="popup1" class="popup_layer">
    <div class="bg">
        <h1 class="popuptitle">근무지 정보</h1>
        <dl class="companyinfo clearfix">
            <dt>회사명</dt>
            <dd id="companyName"></dd>
            <dt>주소</dt>
            <dd id="companyAddr"></dd>
            <dt>전화번호</dt>
            <dd id="companyTel"></dD>
            <dt>소속</dt>
            <dd id="belongsTo"></dd>
            <dt>직급</dt>
            <dd id="position">머머리</dd>
        </dl>
        <div class="clearfix">
            <button type="button" class="btn_type01" onclick="document.getElementById('popup1').style.display='none';">닫기</button>
        </div>
    </div>
</div>