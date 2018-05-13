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

    }
}