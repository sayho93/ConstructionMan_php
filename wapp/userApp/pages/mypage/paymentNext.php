<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 5. 11.
 * Time: PM 4:41
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
$obj = new WebUser($_REQUEST);

//REQUEST ************************************
$P_STATUS = $_POST["P_STATUS"];
$P_REQ_URL = $_POST["P_REQ_URL"];
$P_TID = $_POST["P_TID"];
//$P_MID = $_POST["P_MID"];
$P_MID = "INIpayTest";

function parseData($receiveMsg){
    $retVal = array();
    $returnArr = explode("&",$receiveMsg);
    foreach($returnArr as $value){
        $tmpArr = explode("=",$value);
        $retVal[$tmpArr[0]] = $tmpArr[1];
    }
    return $retVal;
}

function chkTid($P_TID){
    return true;
}


if($P_STATUS=="00" && chkTid($P_TID)){

    $sUrl = $P_REQ_URL."?P_TID=".$P_TID."&P_MID=".$P_MID;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $sUrl);
    curl_setopt($curl, CURLOPT_NOSIGNAL, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $sRes = curl_exec($curl);
    curl_close($curl);

    $returnData = $sRes;

//    var_dump($returnData);

//    $returnData = iconv("euc-kr", "utf-8", $sRes);
    $returnDataArr = parseData($returnData);

    $paymentId = $_REQUEST["paymentId"];
    $userId = $_REQUEST["userId"];

    $P_TID = $returnDataArr["P_TID"];
    $P_MID = $returnDataArr["P_MID"];
    $P_AUTH_DT = $returnDataArr["P_AUTH_DT"];
    $P_STATUS = $returnDataArr["P_STATUS"];
    $P_TYPE = $returnDataArr["P_TYPE"];
    $P_OID = $returnDataArr["P_OID"];
    $P_FN_CD1 = $returnDataArr["P_FN_CD1"];
    $P_AMT = $returnDataArr["P_AMT"];

    $P_CARD_NUM = $returnDataArr["P_CARD_NUM"];

    $sql = "
        UPDATE tblPayment
        SET 
          `transactionId` = '{$P_TID}',
          `type` = '{$P_TYPE}',
          `authDate` = '{$P_AUTH_DT}',
          `code` = '{$P_FN_CD1}',
          `oId` = '{$P_OID}',
          `cardNum` = '{$P_CARD_NUM}',
          `amount` = '{$P_AMT}',
          `resCode` = '{$P_STATUS}'
        WHERE `id` = '{$paymentId}'
    ";

    $obj->update($sql);

    $retVal = $obj->post("/web/user/point/inc/{$userId}", Array("inc" => 1000, "payType" => 1, "comment" => "포인트 결제", "paymentId" => $paymentId));

    echo "<script>location.href = '/userApp/pages/mypage/mypageMain.php'</script>";

}else{
    echo "failed : ".$P_STATUS;
}


?>