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
            "전체 회원" => "contentsView/contentUser.php",
            "인력 회원" => "contentsView/contentUser.php",
            "장비 회원" => "contentsView/contentUser.php",
            "구인 회원" => "contentsView/contentUser.php",
        ),
        "recruitList.php" => array(
            "전체 구인 내역" => "contentsView/contentUser.php",
            "인력 구인 내역" => "contentsView/contentUser.php",
            "장비 구인 내역" => "contentsView/contentUser.php",
        ),
        "payList.php" => array(
            "결제 내역" => "contentsView/contentUser.php",
            "포인트 수기 지급" => "contentsView/contentUser.php",
        ),
        "accountList.php" => array(
            "계정 정보" => "contentsView/contentUser.php",
            "계정 추가" => "contentsView/contentUser.php",
        )
    );

    $CURRENT_PAGE = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);

?>