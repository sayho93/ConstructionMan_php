<?
$phpself=$_SERVER["PHP_SELF"];
$split1 = explode("/web/", $phpself);
$path = explode("/", $split1[1]);
?>
<script type = "text/javascript">
$(document).ready(function(){		
	// 현재 위치하고 있는 url의 상위 폴더명을 가져옴.
	var path = '<?= $path[0] ?>'

	$(".on").each(function( i ) {
		$(this).removeClass("on");
	});

	//현재 위치하고 있는 url의 상위 폴더명을 바탕으로 footerMenuBar를 세팅함.
	switch (path) {
    case 'home':
    	$(".home").addClass("on");		
        break;
    case 'market':
    	$(".market").addClass("on");
        break;
    case 'shop':
    	$(".shop").addClass("on");
        break;
    case 'mission':
    	$(".mission").addClass("on");
        break;
    case 'event':
    	$(".event").addClass("on");
        break;
    case 'more':
    	$(".more").addClass("on");
	}
		
});

</script>
<ul class="clearfix">
	<!-- 해당 페이지 on클래스 추가 -->
	<li class="home on"><a href="#"><i></i>HOME</a></li>
	<li class="market"><a href="#"><i></i>MARKET</a></li>
	<li class="shop"><a href="#"><i></i>SHOP</a></li>
	<li class="mission"><a href="#"><i></i>MISSION</a></li>
	<li class="event"><a href="#"><i></i>EVENT</a></li>
	<li class="more"><a href="#"><i></i>MORE</a></li>
</ul>