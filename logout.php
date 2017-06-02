<?php
    //Sessionをスタートする
    session_start();

    //セッション変数の中身を空にする（上書きする）
    $_SESSION = array();

    if(ini_get("session.use_cookies")) {
    	$params = session_get_cookie_params();
    	setcookie(session_name(), '', time(), - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();

    //Cookie情報も空にする
    setcookie('email', '', time() - 3600);
    setcookie('password', '', time() - 3600);


    header("location: index.php");
    exit();

?>