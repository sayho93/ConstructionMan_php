<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-10
 * Time: 오전 10:14
 */
?>

<script>
    $(document).ready(function(e){
        $(".menuLink").click(function(){
            location.href=$(this).attr("url");
        });

        let menuImgPrefix = "/userApp/image/navi_";
        let menuImgPostfix = ".png";
        let navs = $(".menuLink");

        for(let e = 0; e < navs.length; e++){
            let listTag = navs.eq(e);
            let menuNum = listTag.attr('menuNum');
            let isTurnedOn = "";
            if(getUrl().includes(listTag.attr("url")) ) isTurnedOn = "_on";
            listTag.find("img").attr("src", menuImgPrefix + menuNum + isTurnedOn + menuImgPostfix);
        }
    });

    function urlRemoveSharp(url){
        let urlArr = url.split("?");
        urlArr[0] = urlArr[0].replace("#", "");
        urlArr = urlArr.join("?");
        return urlArr;
    }

    function getUrl(){
        let currentUrl = urlRemoveSharp(document.URL);
        let urlArr = currentUrl.split("/");
        let retPath = "";
        for (let i = 3; i < 10; i++){
            if(urlArr[i] != "") retPath += "/"+urlArr[i];
        }
        return retPath;
    }
</script>

<footer>
    <ul id="navi">
        <li menuNum="01" class = "menuLink" url="/userApp/pages/index.php">
            <img src="/userApp/image/navi_01.png" onMouseOver="this.src='/userApp/image/navi_01_on.png';" onMouseOut="this.src='/userApp/image/navi_01.png';">
        </li>
        <li menuNum="02" class = "menuLink" url="/userApp/pages/diligenceRecord/recordView.php">
            <img src="/userApp/image/navi_02.png" onMouseOver="this.src='/userApp/image/navi_02_on.png';" onMouseOut="this.src='/userApp/image/navi_02.png';">
        </li>
        <li menuNum="03" class = "menuLink" url="/userApp/pages/salary/salaryView.php">
            <img src="/userApp/image/navi_03.png" onMouseOver="this.src='/userApp/image/navi_03_on.png';" onMouseOut="this.src='/userApp/image/navi_03.png';">
        </li>
        <li menuNum="04" class = "menuLink" url="/userApp/pages/door/doorList.php">
            <img src="/userApp/image/navi_04.png" onMouseOver="this.src='/userApp/image/navi_04_on.png';" onMouseOut="this.src='/userApp/image/navi_04.png';">
        </li>
        <li menuNum="05" class = "menuLink" url="/userApp/pages/showMore/moreIndex.php">
            <img src="/userApp/image/navi_05_on.png" onMouseOver="this.src='/userApp/image/navi_05_on.png';" onMouseOut="this.src='/userApp/image/navi_05.png';">
        </li>
    </ul>
    <div class="area_navi"></div>
</footer>
