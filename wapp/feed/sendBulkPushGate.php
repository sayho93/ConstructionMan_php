<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/ApiProcess.php" ?>
<?
	$obj = new ApiProcess($_REQUEST);
	echo $obj->logPath . "/test.txt";
?>
<script type="text/javascript" src="/common/js/jquery-1.7.1.min.js"></script>
<script>
var data = {};
data.push_code = "<?=$_REQUEST["push_code"] ?>";
data.push_msg = "<?=$_REQUEST["push_msg"] ?>";
data.push_type = "<?=$_REQUEST["push_type"] ?>";
data.push_no = "<?=$_REQUEST["push_no"] ?>";

$.ajax({
	url : "/feed/sendBulkPush.php",
	async : true,
	cache : false,
	data : data
});
</script>