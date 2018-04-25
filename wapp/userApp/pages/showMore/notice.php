<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2017-11-13
 * Time: 오전 11:15
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/header.php";?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>

<script>
    let currentPage = 1;
    let currentItems = 0;
    let totalRows = 0;
    $(document).ready(function(){
        setHeaderTitle("공지사항");
        getNoticeList(new sehoMap());
        currentPage = 1;
        currentItems = 0;

        $(document).on("click", ".noticelist", function(){location.href = "/userApp/pages/showMore/noticeView.php?id=" + $(this).attr("no");});

        $(window).scroll(function(){
            if(currentItems >= totalRows) return;
            if($(window).scrollTop() === $(document).height() - $(window).height()) getNoticeList(new sehoMap().put("page", ++currentPage));
        });
    });

    function getNoticeList(map){
        let ajax = new AjaxSender(action + "WebUser.getNoticeList", true, "json", map);
        ajax.send(function(data){
            totalRows = data.data.pageInfo.totalRow;
            for(let i=0; i<data.data.list.length; i++){
                let template = $("#listTemplate").html();
                let row = data.data.list[i];
                template = template.replace("#{id}", row.id);
                template = template.replace("#{title}", row.title);
                template = template.replace("#{regDate}", row.regDate);
                $(".listArea").append(template);
            }
            currentItems += data.data.list.length;
        });
    }
</script>

<div id="listTemplate" style="display:none;">
    <div class="noticelist" no="#{id}">
        <p>#{title}</p>
        <p class="t12px gray">등록일 : #{regDate}</p>
    </div>
</div>

<div class="listArea">  </div>
<? include $_SERVER["DOCUMENT_ROOT"] . "/userApp/php/footer.php" ;?>