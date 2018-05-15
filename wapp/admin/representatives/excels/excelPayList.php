<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?

$obj = new AdminMain($_REQUEST);
$list = $obj->getPaymentList();

header('Content-Disposition: attachment; filename=paymentList.xls');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko">
<META HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
<title>Application Back Office</title>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
    <thead>
    <tr>
        <th>구매자 아이디</th>
        <th>구매자 이름</th>
        <th>구매자 전화번호</th>
        <th>금액</th>
        <th>승인일자</th>
    </tr>
    </thead>
    <tbody>

    <?foreach($list as $row){?>
        <tr class="odd">
            <td class="center"><?=$row["account"]?></td>
            <td class="center"><?=$row["name"]?></td>
            <td class="center"><?=$row["phone"]?></td>
            <td class="center"><?=$row["amount"]?></td>
            <td class="center"><?=$row["authDate"]?></td>
        </tr>
    <?}?>

    <?if(sizeof($list) == 0){?>
        <tr class="odd">
            <td colspan="7" class="">리스트가 없습니다.</td>
        </tr>
    <?}?>
    </tbody>
</table>
</html>