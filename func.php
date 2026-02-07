<?php
//共通に使う関数を記述
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str ?? '', ENT_QUOTES);
}

//DB接続
function db_conn()
{
    require_once('config.php');
    try {
        $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
        return $pdo;
    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }
}

//SQLエラー
function sql_error($stmt)
{
    //execute(SQL実行時にエラーがある場合)
    $error = $stmt->errorInfo();
    exit('SQLerror:' . $error[2]);
}

//ログインチェック
function login_check()
{
    session_start();

    //||はorという意味
    if (!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] !== session_id()) {
        //持ってない人はここで終了させる
        exit('LOGINしてください');
    }

    //鍵があっていることを分かったらいつ盗まれてもいいように、鍵を変える
    session_regenerate_id(true);
    $_SESSION['chk_ssid'] = session_id();
}
