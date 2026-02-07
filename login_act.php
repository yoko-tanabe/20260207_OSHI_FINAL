<?php

//エラー表示をさせるおまじない
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//最初にSESSIONを開始！！ココ大事！！
session_start();

//POST値を受け取る
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

//1.  DB接続します
require_once('func.php');
$pdo = db_conn();

//2. データ登録SQL作成
// gs_user_tableに、IDとWPがあるか確認する。
$stmt = $pdo->prepare('SELECT *FROM gs_user_table2 WHERE lid =:lid AND lpw =:lpw');
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if ($status === false) {
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();

//if(password_verify($lpw, $val['lpw'])){ //* PasswordがHash化の場合はこっちのIFを使う
//$val['id'] !== ''は$val['id'] の中身が空ではなかったら
//授業では以下だったが、これだとどんなUID／PWDでもログインできてしまった。
//GPT的回答はNotionに記載した
// if ($val['id'] !== '') {
// if ($val['id'] !== '' && password_verify($lpw, $val['lpw'])) {
    // if ($val['id'] !== '') { ///先生に確認
    if ($val !== false) {
    //Login成功時 該当レコードがあればSESSIONに値を代入
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['kanri_flg'] = $val['kanri_flg'];
    header('Location: select.php');
} else {
    //Login失敗時(Logout経由)
    header('Location: login.php');
}

exit();