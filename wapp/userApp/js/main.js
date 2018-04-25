//사이드 메뉴 토글 function
$(function(){
	$('.header').find('.menu').toggle(function(){
		$('.sideBar').animate({left:'0px'},300);
	}, function(){
		$('.sideBar').animate({left:'-251px'},300);
	});
});


//페이지 클릭 이벤트 핸들러
$("body").click(function(){
    if($(".sideBar").css("left") != "-251px" && $(".menu_lock").find("img").attr("flag") != "1")
        $(".menu").trigger("click");
});

//전체화면 toggle function
function toggleFullScreen() {
    var doc = window.document;
    var docEl = doc.documentElement;

    var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
    var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

    if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
        requestFullScreen.call(docEl);
    }
    else {
        cancelFullScreen.call(doc);
    }
}

function showPop(url){
    $.ajax({
        url: url,
        async : false,
        cache : false,
        dataType : "html",
        data:{},
        success :function(data){
            $(".jPopSection").html(data);
            $(".jPopSection").fadeIn();
            $(".jPopSection").draggable();
        }
    });
}