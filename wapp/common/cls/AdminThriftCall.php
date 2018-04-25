<?php
	
    require_once $_SERVER["DOCUMENT_ROOT"] . "/../global/lib/ThriftCall/TCall.php";
    
    
    use ThriftService\ThriftAdminServiceClient ;
    
    
    if (!class_exists("AdminThriftCall"))
    {

        class AdminThriftCall extends TCall
        {
            function __construct($name)
            {
                parent::__construct($name);
                
                $this->client = new ThriftAdminServiceClient($this->protocol);

            }

        }

    }
	
?>