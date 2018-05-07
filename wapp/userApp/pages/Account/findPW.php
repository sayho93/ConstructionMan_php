<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 23.
 * Time: PM 3:52
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>

<script>
    $(document).ready(function(){
        var userIdx = -1;
        $("#findID").click(function(){
            location.href = "/userApp/pages/Account/findID.php"
        });

        $(".jFind").click(function(){
            var params = new sehoMap();
            params.put("name", $("[name='name']").val());
            params.put("phone", $("[name='phone']").val());
            params.put("account", $("[name='account']").val());

            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.findPW", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    userIdx = data.data.id;

                    $(".step1").hide();
                    $(".step2").show();
                }
            });
        });

        $(".jChange").click(function(){
            var password = $("[name='password']").val();
            var passwordConfirm = $("[name='passwordConfirm']").val();

            if(password != passwordConfirm){
                alert("비밀번호와 비밀번호 확인에 동일한 값을 입력해 주세요");
                return;
            }

            var params = new sehoMap().put("password", password).put("id", userIdx);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.changePW", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("변경되었습니다");
                    location.href = "/userApp";
                }
            });
        });
    });
</script>

<div class="header">
    <h2>비밀번호 찾기</h2>
</div>

<div class="body">
    <div class="form step1">
        <div class="mid">
            비밀번호를 찾으시나요? <br>회원정보에 등록된 아이디, 이름, 휴대폰번호를 입력해 주세요
        </div>
        <input type="text" name="account" placeholder="  아이디"/>
        <input type="text" name="name" placeholder="  이름"/>
        <input type="number" name="phone" placeholder="  휴대폰 번호(- 제외)"/>

        <input type="button" class="jFind" value="확인"/>
        <div class="line"></div>

        <div class="toID">
            <p>아이디를 모르시나요?</p>
            <a id="findID">아이디 찾기 바로가기▶</a>
        </div>
    </div>

    <div class="form step2" style="display: none;">
        <div class="mid">
            변경할 비밀번호를 입력해 주세요
        </div>
        <input type="text" name="password" placeholder="  비밀번호"/>
        <input type="text" name="passwordConfirm" placeholder="  비밀번호 확인"/>

        <input type="button" class="jChange" value="확인"/>
        <div class="line"></div>

        <div class="toID">
            <p>아이디를 모르시나요?</p>
            <a id="findID">아이디 찾기 바로가기▶</a>
        </div>
    </div>

    <div class="footer" style="margin-top: 10vh;">
        <span>휴넵스/건설인</span>
        <br>
        <p>대표 : 이화수 / 사업자등록번호 : 111-222-3333333</p>
        <p>주소 : 대전광역시 유성구 봉명동 1111</p>
        <p>TEL : 1644-1111 / MAIL : geonseolin@geonseolin.com</p>
        <br>
        <p>ⓒ휴넵스 All rights reserved.</p>
    </div>

</div>

