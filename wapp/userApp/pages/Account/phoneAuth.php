<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 4. 23.
 * Time: PM 5:26
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php" ;?>

<script>
    $(document).ready(function(){
        var type = "<?=$_REQUEST["type"]?>";

        $("#privacy").click(function(){
            location.href = "/userApp/pages/Account/privacy.php";
        });

        $("#policy").click(function(){
            location.href = "/userApp/pages/Account/policy.php";
        });

        $(".jSubmit").click(function(){
            var account = $("[name='account']").val();
            var password = $("[name='password']").val();
            var name = $("[name='name']").val();
            var age = $("[name='age']").val();
            var residence = $("[name='residence']").val();
            var phone = $("[name='phone']").val();
            var isChecked = $("#chk").prop("checked");

            var invalidIndex = getEmptyIndex([account, password, name, age, residence, phone]);
            var nameArray = ["아이디", "패스워드", "이름", "나이", "거주지", "휴대폰 번호"];

            if(invalidIndex != -1){
                alert(nameArray[invalidIndex] + "(을)를 입력해주세요.");
                return;
            }

            if(!isChecked){
                alert("이용약관에 동의해 주세요");
                return;
            }

            var params = new sehoMap();
            params.put("account", account);
            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.checkAccountDuplication", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode == 1){
                    var params = new sehoMap();
                    params.put("phone", phone);
                    var ajax = new AjaxSender("/action_front.php?cmd=WebUser.checkPhoneDuplication", false, "json", params);
                    ajax.send(function(data){
                        if(data.returnCode == 1){
                            var params = new sehoMap();
                            params.put("phone", phone);
                            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.sendAuth", false, "json", params);
                            ajax.send(function(data){
                                if(data.returnCode == 1){
                                    alert("인증번호를 입력해 주세요");
                                    $(".authNumber").show();
                                    $("#next").show();
                                    $(".jSubmit").hide();
                                }
                                else
                                    alert("인증문자 발송 실패! 관리자에게 연락 바랍니다.");
                            });
                        }
                        else
                            alert("입력하신 휴대폰 번호를 사용하는 사람이 있습니다. 다른 휴대폰 번호를 사용해 보세요");
                    });
                }
                else
                    alert("입력하신 아이디를 사용하는 사람이 있습니다. 다른 아이디를 사용해 보세요.");
            });
        });

        $("#next").click(function(){
            var str = $("[name='form']").serialize();
            var phone = $("[name='phone']").val();
            var authNum = $(".authNumber").val();
            var params = new sehoMap().put("phone", phone).put("code", authNum);

            var ajax = new AjaxSender("/action_front.php?cmd=WebUser.verifyCode", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    if(type ==="M"){
                        location.href = "/userApp/pages/Account/joinManStep1.php?" + str;
                    }
                    else if(type === "G"){
                        location.href = "/userApp/pages/Account/joinGearStep1.php?" + str;
                    }
                    else if(type === "N"){
                        //TODO 일반 회원가입
                        $("[name='type']").val("N");
                        str = $("[name='form']").serialize();
                        var ajax = new AjaxSender("/action_front.php?cmd=Webuser.joinUser", false, "json", str);
                        ajax.send(function(data){
                            if(data.returnCode == 1){
                                alert("가입 완료되었습니다.");
                                location.href = "/userApp/pages/search/searchMain.php";
                            }
                            else
                                alert("가입 실패! 다시 시도해 주세요");

                        });
                    }
                }
                else
                    alert("인증 실패. 다시 시도해 주세요")
            });

        });
    });
</script>
<div class="header">
    <h2>회원가입</h2>
</div>

<div class="body">
    <div class="form">
        <p>기본정보</p>
        <form name="form">
            <input type="text" name="account" placeholder="  아이디"/>
            <input type="text" name="password" placeholder="  비밀번호"/>
            <input type="text" name="name" placeholder="  본인 이름"/>
            <input type="number" name="age" placeholder="  나이"/>
            <input type="text" name="residence" placeholder="  거주지"/>
            <input type="number" name="phone" placeholder="  휴대폰번호"/>
            <input type="text" placeholder="  인증번호" class="authNumber" style="display: none;"/>
            <input type="button" value="휴대폰 본인인증" class="jSubmit"/>
            <input type="hidden" name="type"/>
        </form>
        <div class="line"></div>
        <div class="left">
            <input type="checkbox" id="chk"/>
            <label for="chk"></label>
            <h3>이용약관에 전체 동의합니다.</h3>
        </div>
        <div class="right">
            <span id="policy">서비스 이용약관</span> / <span id="privacy">개인정보취급방침</span>
        </div>

        <div class="center">
            <a href="#" id="next" style="display: none;"></a>
        </div>
    </div>

    <div class="footer">
        <span>휴넵스/건설인</span>
        <br>
        <p>대표 : 이화수 / 사업자등록번호 : 111-222-3333333</p>
        <p>주소 : 대전광역시 유성구 봉명동 1111</p>
        <p>TEL : 1644-1111 / MAIL : geonseolin@geonseolin.com</p>
        <br>
        <p>ⓒ휴넵스 All rights reserved.</p>
    </div>

</div>
