<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php" ;?>
<?
/*
 * Web process
 * add by cho
 * */
if(!class_exists("AdminMain")){
    class AdminMain extends  AdminBase {
        function __construct($req)
        {
            parent::__construct($req);
        }

        function login(){
            $account = $_REQUEST["account"];
            $password = md5($_REQUEST["password"]);

            $sql = "
                SELECT * FROM tblAdmin
                WHERE account = '{$account}' AND password = '{$password}' AND status = 1
                LIMIT 1
            ";
            $res = $this->getRow($sql);
            LoginUtil::doAdminLogin($res);
            return $this->makeResultJson(1, "succ", $res);
        }

        function logout(){
            LoginUtil::doAdminLogout();
            return $this->makeResultJson(1, "succ");
        }

        function getUserList(){
            $searchType = $_REQUEST["searchType"];
            $searchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($searchTxt != ""){
                switch($searchType){
                    case 0:
                        $query = " AND `name` LIKE '%{$searchTxt}%'";
                        break;
                    case 1:
                        $query = " AND `account` LIKE '%{$searchTxt}%'";
                        break;
                    case 2:
                        $query = " AND phone LIKE '%{$searchTxt}%'";
                        break;
                }
            }

            $this->initPage();
            $sql = "
                SELECT COUNT(*) as rowCnt
                FROM tblUser WHERE status = 1 {$query}
                ORDER BY regDate DESC;
            ";

            $this->rownum = $this->getValue($sql, "rowCnt");
            $this->setPage($this->rownum) ;

            $sql = "
                SELECT * 
                FROM tblUser WHERE status = 1 {$query}
                ORDER BY regDate DESC
                LIMIT {$this->startNum}, {$this->endNum};
            ";
            return $this->getArray($sql);
        }

        function getManUserList(){
            $searchType = $_REQUEST["searchType"];
            $searchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($searchTxt != ""){
                switch($searchType){
                    case 0:
                        $query = " AND `name` LIKE '%{$searchTxt}%'";
                        break;
                    case 1:
                        $query = " AND `account` LIKE '%{$searchTxt}%'";
                        break;
                    case 2:
                        $query = " AND phone LIKE '%{$searchTxt}%'";
                        break;
                }
            }

            $this->initPage();
            $sql = "
                SELECT COUNT(*) as rowCnt
                FROM tblUser WHERE status = 1 AND `type` = 'M' {$query}
                ORDER BY regDate DESC;
            ";

            $this->rownum = $this->getValue($sql, "rowCnt");
            $this->setPage($this->rownum) ;

            $sql = "
                SELECT * 
                FROM tblUser WHERE status = 1 AND `type` = 'M' {$query}
                ORDER BY regDate DESC
                LIMIT {$this->startNum}, {$this->endNum};
            ";
            return $this->getArray($sql);
        }

        function getGearUserList(){
            $searchType = $_REQUEST["searchType"];
            $searchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($searchTxt != ""){
                switch($searchType){
                    case 0:
                        $query = " AND `name` LIKE '%{$searchTxt}%'";
                        break;
                    case 1:
                        $query = " AND `account` LIKE '%{$searchTxt}%'";
                        break;
                    case 2:
                        $query = " AND phone LIKE '%{$searchTxt}%'";
                        break;
                }
            }

            $this->initPage();
            $sql = "
                SELECT COUNT(*) as rowCnt
                FROM tblUser WHERE status = 1 AND `type` = 'G' {$query}
                ORDER BY regDate DESC;
            ";

            $this->rownum = $this->getValue($sql, "rowCnt");
            $this->setPage($this->rownum) ;

            $sql = "
                SELECT * 
                FROM tblUser WHERE status = 1 AND `type` = 'G' {$query}
                ORDER BY regDate DESC
                LIMIT {$this->startNum}, {$this->endNum};
            ";
            return $this->getArray($sql);
        }

        function getNormalUserList(){
            $searchType = $_REQUEST["searchType"];
            $searchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($searchTxt != ""){
                switch($searchType){
                    case 0:
                        $query = " AND `name` LIKE '%{$searchTxt}%'";
                        break;
                    case 1:
                        $query = " AND `account` LIKE '%{$searchTxt}%'";
                        break;
                    case 2:
                        $query = " AND phone LIKE '%{$searchTxt}%'";
                        break;
                }
            }

            $this->initPage();
            $sql = "
                SELECT COUNT(*) as rowCnt
                FROM tblUser WHERE status = 1 AND `type` = 'N' {$query}
                ORDER BY regDate DESC;
            ";

            $this->rownum = $this->getValue($sql, "rowCnt");
            $this->setPage($this->rownum) ;

            $sql = "
                SELECT * 
                FROM tblUser WHERE status = 1 AND `type` = 'N' {$query}
                ORDER BY regDate DESC
                LIMIT {$this->startNum}, {$this->endNum};
            ";
            return $this->getArray($sql);
        }

        function deleteUser(){
            $id = $_REQUEST['id'];
            $sql = "UPDATE tblUser SET `status` = 0 WHERE `id` = {$id}";
            $this->update($sql);
        }

        function deleteUserMulti(){
            $noArr = $this->req["no"];

            $noStr = implode(',', $noArr);
            $sql = "
				UPDATE tblUser
				SET status = 0
				WHERE `id` IN({$noStr})
			";
            $this->update($sql);
        }

        function getSearchList(){
            $searchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($searchTxt != "")
                $query = "AND (SELECT account FROM tblUser U WHERE U.id = userId) LIKE '%{$searchTxt}%'";

            $this->initPage();
            $sql = "
                SELECT COUNT(*) as rowCnt
                FROM tblSearch
                WHERE 1=1 {$query}
            ";
            $this->rownum = $this->getValue($sql, "rowCnt");
            $this->setPage($this->rownum);

            $sql = "
                SELECT 
                  *, 
                  (SELECT account FROM tblUser U WHERE U.id = userId) as account,
                  (SELECT `name` FROM tblUser U WHERE U.id = userId) as nm,
                  (SELECT description FROM tblZipGugun G WHERE G.gugunID = S.gugunId) as gugunTxt
                  ,(SELECT abbreviation FROM tblZipSido ZS WHERE ZS.sidoID = S.sidoId) as sidoTxt
    
                FROM tblSearch S
                WHERE 1=1 {$query}
                ORDER BY regDate DESC
                LIMIT {$this->startNum}, {$this->endNum}
            ";
            return $this->getArray($sql);
        }

        function getManSearchList(){
            $searchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($searchTxt != "")
                $query = " AND (SELECT account FROM tblUser U WHERE U.id = userId) LIKE '%{$searchTxt}%'";

            $this->initPage();
            $sql = "
                SELECT COUNT(*) as rowCnt
                FROM tblSearch
                WHERE 1=1 AND `type` = 'M' {$query}
            ";
            $this->rownum = $this->getValue($sql, "rowCnt");
            $this->setPage($this->rownum);

            $sql = "
                SELECT 
                  *, 
                  (SELECT account FROM tblUser U WHERE U.id = userId) as account,
                  (SELECT `name` FROM tblUser U WHERE U.id = userId) as nm,
                  (SELECT description FROM tblZipGugun G WHERE G.gugunID = S.gugunId) as gugunTxt
                  ,(SELECT abbreviation FROM tblZipSido ZS WHERE ZS.sidoID = S.sidoId) as sidoTxt
                FROM tblSearch S
                WHERE 1=1 AND `type` = 'M' {$query}
                ORDER BY regDate DESC
                LIMIT {$this->startNum}, {$this->endNum}
            ";
            return $this->getArray($sql);
        }

        function getGearSearchList(){
            $searchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($searchTxt != "")
                $query = " AND (SELECT account FROM tblUser U WHERE U.id = userId) LIKE '%{$searchTxt}%'";

            $this->initPage();
            $sql = "
                SELECT COUNT(*) as rowCnt
                FROM tblSearch
                WHERE 1=1 AND `type` = 'G' {$query}
            ";
            $this->rownum = $this->getValue($sql, "rowCnt");
            $this->setPage($this->rownum);

            $sql = "
                SELECT 
                  *, 
                  (SELECT account FROM tblUser U WHERE U.id = userId) as account,
                  (SELECT `name` FROM tblUser U WHERE U.id = userId) as nm,
                  (SELECT description FROM tblZipGugun G WHERE G.gugunID = S.gugunId) as gugunTxt
                  ,(SELECT abbreviation FROM tblZipSido ZS WHERE ZS.sidoID = S.sidoId) as sidoTxt
                FROM tblSearch S
                WHERE 1=1 AND `type` = 'G' {$query}
                ORDER BY regDate DESC
                LIMIT {$this->startNum}, {$this->endNum}
            ";
            return $this->getArray($sql);
        }

        function getPaymentList(){
            $searchType = $_REQUEST["searchType"];
            $serchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($serchTxt != ""){
                switch(intval($searchType)){
                    case 0:
                        $query = " AND U.account LIKE '%{$serchTxt}%'";
                        break;
                    case 1:
                        $query = " AND U.name LIKE '%{$serchTxt}%'";
                        break;
                    case 2:
                        $query = " AND U.phone LIKE '%{$serchTxt}%'";
                        break;
                    default:
                        break;
                }
            }

            $this->initPage();
            $sql = "
                SELECT COUNT(*) as rowCnt
                FROM tblPayment P
                JOIN tblUser U ON P.userId = U.id 
                WHERE resCode = '00' {$query}
            ";
            $this->rownum = $this->getValue($sql, "rowCnt");
            $this->setPage($this->rownum);

            $sql = "
                SELECT *
                FROM tblPayment P
                JOIN tblUser U ON P.userId = U.id 
                WHERE resCode = '00' {$query}
                ORDER BY P.regDate DESC
                LIMIT {$this->startNum}, {$this->endNum}
            ";

            return $this->getArray($sql);
        }

        function getUserListForPoint(){

            $searchType = $_REQUEST["searchType"];
            $serchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($serchTxt != ""){
                switch(intval($searchType)){
                    case 0:
                        $query = " AND account LIKE '%{$serchTxt}%'";
                        break;
                    case 1:
                        $query = " AND name LIKE '%{$serchTxt}%'";
                        break;
                    case 2:
                        $query = " AND phone LIKE '%{$serchTxt}%'";
                        break;
                    default:
                        break;
                }

                $sql = "SELECT * FROM tblUser WHERE `status` = 1 {$query} ORDER BY regDate DESC";
                return $this->getArray($sql);
            }
        }

        function addPoint(){
            $noArr = $_REQUEST["no"];
            $amount = $_REQUEST["amount"];
            $sql = "INSERT INTO tblPoint(`userId`, `inc`, `comment`, `regDate`) VALUES ";
            for($e = 0; $e < sizeof($noArr); $e++){
                $sql .= "({$noArr[$e]}, {$amount}, '관리자 수기 지급', NOW())";
                if($e + 1 < sizeof($noArr)) $sql .= ", ";
            }

            $this->update($sql);
        }

        function changePass(){
            $password = md5($_REQUEST["password"]);

            $sql = "
            UPDATE tblAdmin SET `password`='{$password}'
            ";
            $this->update($sql);

            return $this->makeResultJson("1", "succ");
        }

        function getSupplyList(){
            $this->initPage();

            $sql = "
                SELECT COUNT(*) as rowCnt FROM tblPoint P JOIN tblUser U ON U.id = P.userId
                WHERE payType = 0
            ";
            $this->rownum = $this->getValue($sql, "rowCnt");
            $this->setPage($this->rownum);

            $sql = "
                SELECT *, P.regDate as rd 
                FROM tblPoint P JOIN tblUser U ON U.id = P.userId
                WHERE payType = 0 
                ORDER BY P.regDate DESC
                LIMIT {$this->startNum}, {$this->endNum}
            ";

            return $this->getArray($sql);
        }

    }
}