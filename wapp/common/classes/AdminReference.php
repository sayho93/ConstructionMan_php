<?
include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php" ;
include $_SERVER[DOCUMENT_ROOT] . "/common/php/LoginUtil.php";

if (! class_exists("AdminReference")){
	class AdminReference extends AdminBase{
		function __construct($req)
		{
			parent::__construct($req);
		}

		function getListOfReference(){
			
			$this->initPage();
			$sql="
				SELECT COUNT(*) rn
				FROM tblRefInfo
				WHERE status=1
			";
			$this->rownum=$this->getValue($sql, "rn");
			$this->setPage($this->rownum);
			
			$sql="
				SELECT *
				FROM tblRefInfo
				WHERE status=1
				ORDER BY refNo DESC
				LIMIT {$this->startNum}, {$this->endNum} ;
			";
			
			$result=$this->getArray($sql);
			return $result;
		}
		
		function getInfoOfReference(){
			$refNo=$this->req["no"];
			$sql="
				SELECT *
				FROM tblRefInfo
				WHERE refNo='{$refNo}'
			";
			$result=$this->getRow($sql);
			return $result;
		}
		
		function exhibitReference(){
			$refNo=$this->req["no"];
			$type=$this->req["type"];
			

			$sql="
			UPDATE tblRefInfo
			SET
				exhibit='{$type}'
			WHERE refNo='{$refNo}'
			";
			$this->update($sql);
			
			return $this->makeResultJson(1, "변경되었습니다");
		}
		
		function saveReference(){
			$refNo=$this->req["refNo"];
			
			$refTitle1=$this->req["refTitle1"];
			$refTitle2=$this->req["refTitle2"];
			
			$imgResult = $this->inFn_Common_fileSave($_FILES);
			$filePathRef = $imgResult["filePathRef"]["saveURL"] != "" ? $imgResult["filePathRef"]["saveURL"] : $this->req["filePathRef"];
			
// 			echo $filePathRef;

			if(($refTitle1=="" && $refTitle2=="")||$filePathRef=="")
				return $this->makeResultJson(-1, "제목과 파일을 확인해 주세요");
			
			$exhibit=$this->req["exhibit"];
			
			if($refNo != ""){
				$sql="
					 update `tblRefInfo`
					set
  					`refTitle1` = '{$refTitle1}',
  					`refTitle2` = '{$refTitle2}',
  					`filePathRef` = '{$filePathRef}'
					where `refNo` = '{$refNo}'	
				";
				$this->update($sql);
				return $this->makeResultJson(1, "수정되었습니다");
			}
			else{
				$sql="
					insert into `tblRefInfo`
            		(
             		`refTitle1`,
             		`refTitle2`,
             		`filePathRef`,
             		`exhibit`,
             		`regDate`,
             		`status`
					)
					values 
					(
        			'{$refTitle1}',
        			'{$refTitle2}',
        			'{$filePathRef}',
        			0,
        			NOW(),
        			1
					);
				";
				$this->update($sql);
				return $this->makeResultJson(1, "저장되었습니다");
			}
		}
		
		function deleteReference(){
			$refNo=$this->req["no"];
			
			$sql="
				UPDATE tblRefInfo
				SET
					status=0
				WHERE refNo='{$refNo}'
			";
			$this->update($sql);
			return $this->makeResultJson(1, "삭제되었습니다");
		}
	}
}

?>