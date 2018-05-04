<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBase.php" ;?>
<?php
if(! class_exists("WebUser") ){

    class WebUser extends Common{
        function __construct($req){
            parent::__construct($req);
        }

        function userLogin(){
            $retVal = $this->post("/web/user/login", Array("account" => $_REQUEST["account"], "password" => $_REQUEST["password"] ));
            LoginUtil::doWebLogin(json_decode($retVal)->data);
            return $retVal;
        }

        function checkAccountDuplication(){
            $retVal = $this->get("/web/user/checkAccountDuplication/{$_REQUEST["account"]}", null);
            return $retVal;
        }

        function checkPhoneDuplication(){
            $retVal = $this->get("/web/user/checkPhoneDuplication/{$_REQUEST["phone"]}", null);
            return $retVal;
        }

        function sendAuth(){
            $retVal = $this->get("/web/user/auth/{$_REQUEST["phone"]}", null);
            return $retVal;
        }

        function verifyCode(){
            $retVal = $this->get("/web/user/verify/{$_REQUEST["phone"]}", Array("code" => $_REQUEST["code"]));
            return $retVal;
        }

        function getSidoList(){
            $retVal = $this->get("/info/region", null);
            return $retVal;
        }

        function getGugunList(){
            $retVal = $this->get("/info/region/{$_REQUEST["sidoID"]}", null);
            return $retVal;
        }

        function getWorkInfo(){
            $retVal = $this->get("/info/work", Array("work" => $_REQUEST["work"]));
            return $retVal;
        }

        function joinUser(){
            $retVal = $this->post("/web/user/join", Array("name" => $_REQUEST["name"], "account" => $_REQUEST["account"],
                "password" => $_REQUEST["password"], "phone" => $_REQUEST["phone"], "age" => $_REQUEST["age"], "type" => $_REQUEST["type"],
                "pushKey" => $_REQUEST["pushKey"], "region" => $_REQUEST["regionArr"], "work" => $_REQUEST["workArr"],
                "career" => $_REQUEST["careerArr"], "welderType" => $_REQUEST["welderType"], "gearInfo" => $_REQUEST["gearInfo"]));

            LoginUtil::doWebLogin(json_decode($retVal)->data);
            return $retVal;
        }

        function getGearOption1(){
            $retVal = $this->get("/info/gearOption1", Array("name" => $_REQUEST["name"]));
            return $retVal;
        }

        function getGearOption2(){
            $retVal = $this->get("/info/gearOption2", Array("name" => $_REQUEST["name"], "detail" => $_REQUEST["detail"]));
            return $retVal;
        }

        function registerSearch(){
            $retVal = $this->post("/web/register/search/{$this->webUser->id}", Array("type" => $_REQUEST["type"], "work" => $_REQUEST["workArr"],
                "career" => $_REQUEST["careerArr"], "welderType" => $_REQUEST["welderType"], "sidoId" => $_REQUEST["sidoId"],
                "gugunId" => $_REQUEST["gugunId"], "name" => $_REQUEST["name"], "startDate" => $_REQUEST["startDate"], "endDate" => $_REQUEST["endDate"],
                "lodging" => $_REQUEST["lodging"], "price" => $_REQUEST["price"], "discussLater" => $_REQUEST["discussLater"], "gearId" => $_REQUEST["gearId"],
                "attachment" => $_REQUEST["attachment"]));
            return $retVal;
        }

        function getUserInfo(){
            $retVal = $this->get("/web/user/info/{$this->webUser->id}", null);
            return $retVal;
        }













        function memberJoin(){
            return $this->post(
                "/web/user/join",
                Array("phone" => $this->req["phone"], "name" => $this->req["name"],
                    "email" => $this->req["email"], "password" => $this->req["password"],
                    "deviceType" => $this->req["deviceType"], "regKey" => $this->req["regKey"],
                    "lastIp" => $this->req["lastIp"])
            );
        }

        function autoLogin(){
            $retVal = $this->post("/web/user/access", Array("email" => $this->req["email"], "token" => $this->req["token"]));
            LoginUtil::doWebLogin(json_decode($retVal)->data);
            return $retVal;
        }

        function userLogout(){
            LoginUtil::doWebLogout();
            return $this->makeResultJson("1", "로그아웃되었습니다");
        }

        function findEmail(){
            return $this->get("/web/user/find/email", Array("phone" => $this->req["phone"], "name" => $this->req["name"]));
        }

        //TODO
        function checkUserPwd(){
            return $this->post("/web/user/check/password", Array("email" => $this->req["email"], "password" => $this->req["currentPw"]));
        }

        function findPwd(){
            return $this->get("/web/user/find/password", Array("phone" => $this->req["phone"], "name" => $this->req["name"], "email" => $this->req["email"]));
        }

        function getRegionList(){
            return $this->get("/info/region", Array());
        }

        function getCityList(){
            return $this->get("/info/region/{$this->req["regionID"]}", Array());
        }

        function getCompanyList(){
            return $this->get(
                "/info/company",
                Array("page" => $this->checkNullParam("page", 1),
                    "search" => $this->req["search"], "sido" => $this->checkNullParam("sido", null),
                    "gungu" => $this->checkNullParam("gungu", null))
            );
        }

        //TODO
        function matchCompany(){
            $result = $this->post("/reg/workplace/{$this->webUser->id}", Array("companyId" => $this->req["companyId"], "permission" => $this->req["permission"]));
            LoginUtil::doWebLogin(json_decode($result)->data);
            return $result;
        }

        function getNoticeList(){
            return $this->get("/info/board/0",Array("page" => $this->checkNullParam("page", 1), "company" => "1"));
        }

        function getBoardInfo(){
            return $this->get("/info/board/detail/{$this->req["id"]}",Array());
        }

        function updateUserName(){
            $result = $this->post("/web/user/update/name/{$this->req["id"]}", Array("name" => $this->req["name"]));
            LoginUtil::doWebLogin(json_decode($result)->data);
            return $result;
        }

        function updateUserPwd(){
            return $this->post("/web/user/update/password/{$this->req["id"]}", Array("password" => $this->req["password"]));
        }

        function updatePhone(){
            $result = $this->post("/web/user/update/phone/{$this->req["id"]}", Array("phone" => $this->req["phone"]));
            LoginUtil::doWebLogin(json_decode($result)->data);
            return $result;
        }

        function updatePushFlag(){
            if($this->webUser->flagPush  == 0) $result = $this->post("/web/user/push/off/{$this->req["id"]}", null);
            else $result = $this->post("/web/user/push/on/{$this->req["id"]}", null);
            LoginUtil::doWebLogin(json_decode($result)->data);
            return $result;
        }

        function updateAlarmFlag(){
            if($this->webUser->flagAlarm  == 0) $result = $this->post("/web/user/alarm/off/{$this->req["id"]}", null);
            else $result = $this->post("/web/user/alarm/on/{$this->req["id"]}", null);
            LoginUtil::doWebLogin(json_decode($result)->data);
            return $result;
        }

        function updateGestureFlag(){
            if($this->webUser->flagGesture  == 0) $result = $this->post("/web/user/gesture/off/{$this->req["id"]}", null);
            else $result = $this->post("/web/user/gesture/on/{$this->req["id"]}", null);
            LoginUtil::doWebLogin(json_decode($result)->data);
            return $result;
        }

        function getFavoredGates(){
            return $this->get("/info/gates/favored/{$this->webUser->id}", Array());
        }

        function getGates(){
            return $this->get("/info/gates/{$this->req["companyId"]}", Array("memberId" => $this->req["memberId"]));
        }

        function getGateDetail(){
            return $this->get("/info/gate/detail/{$this->req["gateId"]}", Array("memberId" => $this->webUser->id));
        }

        function updateLikeStatus(){
            if($this->req["flag"] == 0) return $this->post("/like/gate/{$this->webUser->id}", Array("gateId" => $this->req["gateId"]));
            else return $this->post("/unlike/gate/{$this->webUser->id}", Array("gateId" => $this->req["gateId"]));
        }

        function updateGestureStatus(){
            if($this->req["flag"] == 0) return $this->post("/gesture/gate/{$this->webUser->id}", Array("gateId" => $this->req["gateId"]));
            else return $this->post("/undogesture/gate/{$this->webUser->id}", Array("gateId" => $this->req["gateId"]));
        }

        function getMyWorkplace(){
            return $this->get("/info/workplace/{$this->webUser->id}", Array());
        }

        function deleteWorkplace(){
            return $this->post("/delete/workplace/{$this->webUser->id}", Array("companyId" => $this->req["companyId"]));
        }

        function getWorkPlaceDetail(){
            return $this->get("/info/workplace/detail/{$this->req["companyId"]}", Array());
        }

        function getWorkPlaceAdmin(){
            return $this->get("/info/workplace/admin/{$this->req["companyId"]}", Array());
        }

        //TODO 근무지 승인코드
        function submitCompanyToken(){
//            return $this->makeResultJson(1, "asd");
//            return $this->makeResultJson(-1, "asd");
            return $this->post("/confirm/workplace/{$this->webUser->id}", Array("companyId" => $this->req["companyId"], "token" => $this->req["token"]));
        }

        function getLatestDiligenceUser(){
            return $this->get("/info/diligence/latest/user/{$this->webUser->id}", Array());
        }

        function registerDiligence(){
            return $this->post("/reg/diligence/{$this->webUser->id}", Array("gateId" => $this->req["gateId"], "classifier" => $this->req["classifier"], "type" => $this->req["type"]));
        }
    }
}
?>