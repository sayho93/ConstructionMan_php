<?php
/**
 * Created by PhpStorm.
 * User: 전세호
 * Date: 2018-05-13
 * Time: 오후 10:21
 */
?>
<div class="pageNumber pagination" align="right">
    <ul>
        <?
            if($obj->isPrevBlock()){
                echo '<li><a class="jPage" page="1"></a></li>';
                echo '<li><a class="jPage" page="' . ($obj->startBlock - 1) . '"></a><li>';
            }

            for($i=$obj->startBlock; $i<=$obj->endBlock; $i++){
                if( $obj->req["page"] == $i ) echo '<li class="active"><a href="#">'.$i.'</a></li>' ;
                else echo '<li><a href="#" class="jPage" page="'.$i.'">'.$i.'</a></li>' ;
            }

            if($obj->isNextBlock()){
                echo '<li><a class="jPage" page="' . ($obj->endBlock + 1) . '" src="/admin/inc/images/paging_next.gif" alt="다음"></li>';
                echo '<li><a class="jPage" page="' . ($obj->endPage) . '" src="/admin/inc/images/paging_last.gif" alt="마지막페이지"></li>';
            }
        ?>
    </ul>
</div>

<!--<div class="pagination" align="right">-->
<!--    <ul>-->
<!--        <li><a href="#">Prev</a></li>-->
<!--        <li class="active"><a href="#">1</a></li>-->
<!--        <li><a href="#">2</a></li>-->
<!--        <li><a href="#">3</a></li>-->
<!--        <li><a href="#">4</a></li>-->
<!--        <li><a href="#">5</a></li>-->
<!--        <li><a href="#">Next</a></li>-->
<!--    </ul>-->
<!--</div>-->