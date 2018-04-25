<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-01
 * Time: 오전 10:37
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Web.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBoard.php" ;?>

<? include "navigator.php";?>

<script>
    $(document).ready(function(){
        let map = new Map();
        map.set("no", 1);
        map.set("id", "fishcreek");
        map.set("pwd", "<?=md5('1212')?>");
        map.set("name", "전세호");

        map.delete("no");

        console.log(map.entries().next());

        for(let pair of map)
            $("#test").append(JSON.stringify(pair) + "\n");

        let set = new Set();
        set.add("a").add("b").add("c");
        set.delete("a");

        for(let x of set)
            $("#testSet").append(x + "\n");

        var [start, end] = ["09:00", "18:00", "12:00"];
        console.log(start + ":::::" + end);
});

</script>

<div style="margin-top: 200px;">
    <textarea rows="5" style="width:100%" id="test"></textarea>
    <textarea rows="5" style="width:100%" id="testSet"></textarea>
</div>


