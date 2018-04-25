<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php" ;?>
<?
/*
 * Admin process
 * add by dev.lee
 */
if (! class_exists("AdminMain"))
{
	class AdminMain extends AdminBase
	{
		function __construct($req)
		{
			parent::__construct($req);
		}



	}


}