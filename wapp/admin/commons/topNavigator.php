<ul class="nav">
    <?
    foreach ($TOP_MENU_INFO as $key => $value){
        ?>
        <li class="<?=$CURRENT_PAGE == $value ? "active" : ""?>">
<!--        <li class="active">-->
            <a href="<?=$value?>?initFlag=0"><?=$key?></a>
        </li>
        <?
    }
    ?>
</ul>