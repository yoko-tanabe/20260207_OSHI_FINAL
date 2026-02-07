<?php

$id = $_GET['id'];

//update.phpからコピーする
//config.phpを呼び出す
////////////////////require_once('../../config.php'); //さくらにあげるときはこっち
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

//3. 削除します
$stmt = $pdo->prepare(
'DELETE

FROM
timelesz_location

WHERE
ID = :id;
'
);

$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute(); //実行

//4.削除処理がうまくいったのかを確認
if ($status == false){
$error = $stmt -> errorInfo();
var_dump($error);
//exitが文字列を出力してから処理を強制終了するので、echoしなくても文字が出てくる
exit('SQLError:'.print_r($error, true));
}else{
//コロンの前後にスペースを入れてはいけない
header('Location: select.php');
exit();
}

?>