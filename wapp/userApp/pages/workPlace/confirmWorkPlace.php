<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-27
 * Time: 오전 11:35
 */
?>
<?include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php";?>
<?include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<script>
    $(document).ready(function(){
        setHeaderTitle("승인코드");
        let map = new sehoMap();
        map.put("companyId", "<?=$_REQUEST["companyId"]?>");
        let ajax = new AjaxSender(action + "WebUser.getWorkPlaceDetail", false, "json", map);
        ajax.send(function(data){
            let row = data.data;
            $(".code_title").html(row.name);
            $(".code_call").html(formatPhone(row.phone));

            let addrTxt = row.sidoTxt + " " + row.gunguTxt;
            if(row.dongTxt !== undefined)
                addrTxt += " " + row.dongTxt;
            $(".code_adr").html(addrTxt);
        });

        ajax = new AjaxSender(action + "WebUser.getWorkPlaceAdmin", false, "json", map);
        ajax.send(function(data){
            let row = data.data;
            $("#adminName").html(row.name);
            $("#adminDept").html(row.deptTxt);
            $("#adminPosition").html(row.positionTxt);
            $("#adminPhone").html(formatPhone(row.phone));
            $("#adminMail").html(row.email);
        });

        $(".jSubmit").click(function(){
            let ajax = new AjaxSender(action + "WebUser.submitCompanyToken", false, "json", new sehoMap().put("token", $("#token").val()).put("companyId", "<?=$_REQUEST["companyId"]?>"));
            ajax.send(function(data){
                let row = data.data;
                let map = new sehoMap();
                if(data.returnCode === 1)
                    showPop(map.put("popText", "승인되었습니다");, null, function(){$(".jHeaderBack").trigger("click")});
                else
                    showPop(map.put("popText", "승인 번호가 틀렸습니다"));
            });
        });
    });
</script>
<div class="bg_contents">
    <p class="code_title"></p>
    <p class="code_call"></p>
    <p class="code_adr"></p>

    <h5 class="gray mt30">※ 관리자에게 받은 승인코드를 입력해 주세요.</h5>
    <input type="text" class="inputbox mt5" id="token">
    <div class="center"><button type="button" class="btn_blue btn_bigh mt20 jSubmit" style="width:50%;">확인</button></div>
</div>


<!-- TODO 관리자정보 -->
<hr class="mt10">
<div class="bg_contents">
    <h5 class="gray">※ 승인코드를 못 받으셨거나, 발급받은 승인코드가 다를 경우, 아래 관리자에게 문의 바랍니다.</h5>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="basic mt5">
        <tr>
            <th>관리자명</th>
            <td id="adminName"></td>
        </tr>
        <tr>
            <th>소속</th>
            <td id="adminDept">총무팀</td>
        </tr>
        <tr>
            <th>직급</th>
            <td id="adminPosition"></td>
        </tr>
        <tr>
            <th>연락처</th>
            <td id="adminPhone"></td>
        </tr>
        <tr>
            <th>이메일</th>
            <td id="adminMail"></td>
        </tr>
    </table>
</div>

<div class="popArea">   </div>