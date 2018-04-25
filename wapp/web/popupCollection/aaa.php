<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBase.php" ;?>
<meta charset="utf-8" />
<?php

$obj = new WebBase($_REQUEST);

$userID = "suadmin";
$request = $obj->lnFn_Common_CrPost(array("password" => "suadmin" ));
$actionUrl = "{$obj->serverRoot}/user/read/".$userID;
$retVal = $obj->postData($actionUrl, $request);

$userInfo = json_decode($retVal)->data;

$tmp = json_encode($userInfo);
$webUser = json_decode($tmp, true);
echo $webUser["id"];



?>