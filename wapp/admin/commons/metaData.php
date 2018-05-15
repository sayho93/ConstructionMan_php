<?
    $PROJECT_NAME = "건설인";

    $TOP_MENU_INFO = array(
        "회원관리" => "userList.php",
        "구인관리" => "recruitList.php",
        "결제관리" => "payList.php",
        "계정관리" => "accountList.php"
    );
    
    $LEFT_MENU_INFO = array(
        "userList.php" => array(
            "전체 회원" => "representatives/userList.php?type=0",
            "인력 회원" => "representatives/userList.php?type=1",
            "장비 회원" => "representatives/userList.php?type=2",
            "구인 회원" => "representatives/userList.php?type=3",
        ),
        "recruitList.php" => array(
            "전체 구인 내역" => "representatives/recruitList.php?type=0",
            "인력 구인 내역" => "representatives/recruitList.php?type=1",
            "장비 구인 내역" => "representatives/recruitList.php?type=2",
        ),
        "payList.php" => array(
            "결제 내역" => "representatives/payList.php?type=0",
            "포인트 수기 지급" => "representatives/payList.php?type=1",
        ),
        "accountList.php" => array(
            "계정 정보" => "representatives/accountList.php?type=0"
        )
    );

    $CURRENT_PAGE = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);

?>