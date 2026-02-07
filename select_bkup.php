<?php

//エラー表示をさせるおまじない
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//funcs.phpを呼び出す
require_once('func.php');
login_check();

//config.phpを呼び出す
///////////////////require_once('../../config.php'); //さくらにあげるときはこっち
require_once('config.php');

//2. DB接続します
//tryは頑張ってやってみて、ダメだったらcatchして終了させます
try {
  //ID:'root', Password: xamppは 空白 ''
  //mampの場合はID root, PWD : root
  //Excelで言うところのファイルの指定
  $server_info = 'mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host;
  $pdo = new PDO($server_info, $db_id, $db_pw);
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}


//データ取得

$count_stmt = $pdo->prepare("SELECT Count(*) FROM timelesz_location");
$count_stmt->execute();
$count = $count_stmt->fetchColumn();
// var_dump($count);

//２．データ取得SQL作成
//$stmtじゃなくても良い。stmtを使い回してしまうと、値が上書きされていく
$stmt_all = $pdo->prepare("SELECT * FROM timelesz_location");
$status = $stmt_all->execute();

//３．データ表示
$view = "";
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt_all->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    //1行ずつとってくる
    while ($result = $stmt_all->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<p>';
        $view .= h($result['NAME']) . ' ' . h($result['URL']) . ' ' . h($result['COMMENT']);
        //$view = $result['date'].$result['name'].$result['email'].$result['date']; にするとWhileが回るたびに上書きされてしまう
        $view .= '<a href="detail.php?id='.$result['ID'].'">';
        $view .= ':更新';

        if($_SESSION['kanri_flg'] === 1){
    $view .= '<a  href="delete.php?id='.$result['ID'].'">';
        $view .= ':削除';
        $view .= '</a>';
        }

        $view .= '</p>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/select.css">
</head>

<body>
    <!-- 装飾要素 -->
    <div class="decoration_h"></div>
    <h1 id="title"> Google Map URL 一覧</h1>

    <div class="view_result">
        <?= $view ?>
    </div>

    <div class="decoration_b">
        <div class="transfer">
            <a href="index.php">
                <button id="return_home_btn" type="button">新しい場所を登録する</button>
            </a>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="js/main.js"></script>
</body>


</html>