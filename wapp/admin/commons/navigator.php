<ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
    <?
    foreach ($LEFT_MENU_INFO[$CURRENT_PAGE] as $key => $value){
        ?>
        <li>
            <a href="#" toGo="<?="/admin/".$value?>" class="leftMenuItemPickle"><i class="icon-chevron-right"></i> <?=$key?></a>
        </li>
        <?
    }
    ?>
</ul>