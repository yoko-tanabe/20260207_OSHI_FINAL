<?php
//エラー表示をさせるおまじない
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//POSTデータの取得
$url = $_POST['url'];
$comment = $_POST['comment'];
//<form> に enctype="multipart/form-data" がないとエラーになる。ファイルアップロードでは、formタグに 必須 でこれを指定しないと$_FILES 自体が空になります。
$img_name=$_FILES['img']['name'];
$ido = $_POST['ido'];
$keido = $_POST['keido'];
$name = $_POST['name'];
$visit = false;
$trip_date = "20291215";

//--> 確認
// echo $url;
// echo $comment;


//config.phpを呼び出す
//////////////////require_once('../../config.php'); //さくらにあげるときはこっち
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
//３．データ登録SQL作成

// 1. SQL文を用意 改行OK
//VALUES(NULL, $name, $email, $contents, now())"); はできない。何故なら、Formに悪人が変なことを書く可能性があることを書く可能性がある
//:xxxは、xxxという名前のパラメータ（プレースフォルダー）　後で実際の値をバインドする
$stmt = $pdo->prepare("INSERT INTO 
timelesz_location(ID,DATE,IDO, KEIDO,NAME, VISIT, TRIP_DATE, COMMENT, URL)
VALUES(NULL, now(), :ido, :keido, :name, :visit, :trip_date, :comment, :url)");

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR
//悪人対策で、以下のように中間処理を入れる

$stmt->bindValue(':ido', $ido, PDO::PARAM_STR);
$stmt->bindValue(':keido', $keido, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':visit', $visit, PDO::PARAM_BOOL);
$stmt->bindValue(':trip_date', $trip_date, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment. PDO::PARAM_STR);
$stmt->bindValue(':url', $url, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  //５．index.phpへリダイレクト
  //ここのc Locationの後に空白が入ったら、エラーが出た
//   echo("OK");
header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>