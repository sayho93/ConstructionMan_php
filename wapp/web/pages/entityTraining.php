<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-10-30
 * Time: 오후 5:08
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBoard.php" ;?>
<?
$obj = new WebBoard($_REQUEST);

$list = $obj->instantResponse();
?>

    <li class="timeline-inverted added">
        <div class="timeline-badge warning"><i class="fa fa-search"></i>
        </div>
        <div class="timeline-panel">
            <div class="timeline-heading">
                <h4 class="timeline-title">Normalized</h4>
            </div>
            <div class="timeline-body">
                <p><?=$list->normalized?></p>
            </div>
        </div>
    </li>
<?for($i=0; $i<sizeof($list->analysis); $i++){?>
    <li class="timeline-inverted added">
        <div class="timeline-badge warning"><i class="fa fa-search"></i>
        </div>
        <div class="timeline-panel">
            <div class="timeline-heading">
                <h4 class="timeline-title">Analysis</h4>
            </div>
            <div class="timeline-body">
                <p><?=$list->analysis[$i]?></p>
            </div>
        </div>
    </li>
<?}?>