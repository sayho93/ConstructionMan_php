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
            $searchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($searchTxt != ""){
                $query = "AND phone LIKE '%{$searchTxt}%'";
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
            $searchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($searchTxt != ""){
                $query = "AND phone LIKE '%{$searchTxt}%'";
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
            $searchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($searchTxt != ""){
                $query = "AND phone LIKE '%{$searchTxt}%'";
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
            $searchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($searchTxt != ""){
                $query = "AND phone LIKE '%{$searchTxt}%'";
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
                  (SELECT description FROM tblZipGugun G WHERE G.gugunID = S.gugunId) as gugunTxt
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
                  (SELECT description FROM tblZipGugun G WHERE G.gugunID = S.gugunId) as gugunTxt
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
                  (SELECT description FROM tblZipGugun G WHERE G.gugunID = S.gugunId) as gugunTxt
                FROM tblSearch S
                WHERE 1=1 AND `type` = 'G' {$query}
                ORDER BY regDate DESC
                LIMIT {$this->startNum}, {$this->endNum}
            ";
            return $this->getArray($sql);
        }

        function getPaymentList(){
            $serchTxt = $_REQUEST["searchTxt"];
            $query = "";
            if($serchTxt != "") $query = " AND U.phone LIKE '%{$serchTxt}%'";

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




    }
}