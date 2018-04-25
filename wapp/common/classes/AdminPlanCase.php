<?
include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php" ;
include $_SERVER[DOCUMENT_ROOT] . "/common/php/LoginUtil.php";

if (! class_exists("AdminPlanCase")){
	class AdminPlanCase extends AdminBase{
		function __construct($req)
		{
			parent::__construct($req);
		}
		
		function savePlanCase(){
			$planType=$this->req["planType"];
			$caseNo=$this->req["caseNo"];
			$resTypeArr=$this->req["resTypeArr"];
			$resContentArr=$this->req["resContentArr"];
			$isPropofol=$this->req["isPropofol"];
			$isKetamine=$this->req["isKetamine"];
			$isOptimumDose=$this->req["isOptimumDose"];
			$doseNameArr=$this->req["doseNameArr"];
			$optimumDoseArr=$this->req["optimumDoseArr"];
			
			$sql="
				INSERT INTO `tblPlanCase`
            (
			`planType`,
             `caseNo`,
             `resType1`,
             `resContent1`,
             `resType2`,
             `resContent2`,
             `resType3`,
             `resContent3`,
             `resType4`,
             `resContent4`,
             `resType5`,
             `resContent5`,
             `resType6`,
             `resContent6`,
             `resType7`,
             `resContent7`,
             `resType8`,
             `resContent8`,
             `resType9`,
             `resContent9`,
             `resType10`,
             `resContent10`,
             `isPropofol`,
             `isKetamine`,
             `isOptimumDose`,
             `doseName1`,
             `optimumDose1`,
             `doseName2`,
             `optimumDose2`,
             `doseName3`,
             `optimumDose3`,
             `doseName4`,
             `optimumDose4`,
             `doseName5`,
             `optimumDose5`,
             `doseName6`,
             `optimumDose6`,
             `doseName7`,
             `optimumDose7`,
             `doseName8`,
             `optimumDose8`,
             `doseName9`,
             `optimumDose9`,
             `doseName10`,
             `optimumDose10`
			)
			VALUES 
			(
			'{$planType}',
        	'{$caseNo}',
        	'{$resTypeArr[1]}',
        	'{$resContentArr[1]}',
        	'{$resTypeArr[2]}',
        	'{$resContentArr[2]}',
        	'{$resTypeArr[3]}',
        	'{$resContentArr[3]}',
        	'{$resTypeArr[4]}',
        	'{$resContentArr[4]}',
        	'{$resTypeArr[5]}',
        	'{$resContentArr[5]}',
        	'{$resTypeArr[6]}',
        	'{$resContentArr[6]}',
        	'{$resTypeArr[7]}',
        	'{$resContentArr[7]}',
        	'{$resTypeArr[8]}',
        	'{$resContentArr[8]}',
        	'{$resTypeArr[9]}',
        	'{$resContentArr[9]}',
        	'{$resTypeArr[10]}',
        	'{$resContentArr[10]}',
        	'{$isPropofol}',
        	'{$isKetamine}',
        	'{$isOptimumDose}',
        	'{$doseNameArr[1]}',
        	'{$optimumDoseArr[1]}',
        	'{$doseNameArr[2]}',
        	'{$optimumDoseArr[2]}',
        	'{$doseNameArr[3]}',
        	'{$optimumDoseArr[3]}',
        	'{$doseNameArr[4]}',
        	'{$optimumDoseArr[4]}',
        	'{$doseNameArr[5]}',
        	'{$optimumDoseArr[5]}',
        	'{$doseNameArr[6]}',
        	'{$optimumDoseArr[6]}',
        	'{$doseNameArr[7]}',
        	'{$optimumDoseArr[7]}',
        	'{$doseNameArr[8]}',
        	'{$optimumDoseArr[8]}',
        	'{$doseNameArr[9]}',
        	'{$optimumDoseArr[9]}',
        	'{$doseNameArr[10]}',
        	'{$optimumDoseArr[10]}'
			)
			ON DUPLICATE KEY UPDATE
			resType1='{$resTypeArr[1]}',
			resContent1='{$resContentArr[1]}',
			resType2='{$resTypeArr[2]}',
			resContent2='{$resContentArr[2]}',
			resType3='{$resTypeArr[3]}',
			resContent3='{$resContentArr[3]}',
			resType4='{$resTypeArr[4]}',
			resContent4='{$resContentArr[4]}',
			resType5='{$resTypeArr[5]}',
			resContent5='{$resContentArr[5]}',
			resType6='{$resTypeArr[6]}',
			resContent6='{$resContentArr[6]}',
			resType7='{$resTypeArr[7]}',
			resContent7='{$resContentArr[7]}',
			resType8='{$resTypeArr[8]}',
			resContent8='{$resContentArr[8]}',
			resType9='{$resTypeArr[9]}',
			resContent9='{$resContentArr[9]}',
			resType10='{$resTypeArr[10]}',
			resContent10='{$resContentArr[10]}',
			isPropofol='{$isPropofol}',
			isKetamine='{$isKetamine}',
			isOptimumDose='{$isOptimumDose}',
			doseName1='{$doseNameArr[1]}',
			optimumDose1='{$optimumDoseArr[1]}',
			doseName2='{$doseNameArr[2]}',
			optimumDose2='{$optimumDoseArr[2]}',
			doseName3='{$doseNameArr[3]}',
			optimumDose3='{$optimumDoseArr[3]}',
			doseName4='{$doseNameArr[4]}',
			optimumDose4='{$optimumDoseArr[4]}',
			doseName5='{$doseNameArr[5]}',
			optimumDose5='{$optimumDoseArr[5]}',
			doseName6='{$doseNameArr[6]}',
			optimumDose6='{$optimumDoseArr[6]}',
			doseName7='{$doseNameArr[7]}',
			optimumDose7='{$optimumDoseArr[7]}',
			doseName8='{$doseNameArr[8]}',
			optimumDose8='{$optimumDoseArr[8]}',
			doseName9='{$doseNameArr[9]}',
			optimumDose9='{$optimumDoseArr[9]}',
			doseName10='{$doseNameArr[10]}',
			optimumDose10='{$optimumDoseArr[10]}'
			";
			
			$this->update($sql);
			
// 			echo $sql;
			return $this->makeResultJson(1, "저장되었습니다");
		}
		
		function getPlanCase(){
			$typeNo=$this->req["no"];
			
			$sql="
				SELECT *
				FROM tblPlanCase
				WHERE planType='{$typeNo}'
			";
			
			$result=$this->getArray($sql);
// 			echo json_encode($result);
			return $result;
		}
	}
}

?>