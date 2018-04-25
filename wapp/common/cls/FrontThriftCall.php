<?php

    require_once $_SERVER["DOCUMENT_ROOT"] . "/../global/lib/ThriftCall/TCall_Front.php";


    use ThriftService\ThriftServiceClient ;


    if (!class_exists("FrontThriftCall"))
    {

        class FrontThriftCall extends TCall_Front
        {
            function __construct($name)
            {
                parent::__construct($name);

                $this->client = new ThriftServiceClient($this->protocol);

            }

        }

    }

?>