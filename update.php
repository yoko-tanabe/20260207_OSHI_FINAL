<?php
//送られてくるデータを受け取る。

$id = $_POST['id'];
$url = $_POST['url'];
$comment = $_POST['comment'];
$ido = 46.888190501495465;
$keido = 142.05889300327456;
$name = 'Ise Farm';
$visit = false;
$trip_date = "20291215";


//config.phpを呼び出す
/////////////require_once('../../config.php'); //さくらにあげるときはこっち
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

//SQLでデータを更新する
$stmt = $pdo->prepare(
'UPDATE
timelesz_location

-- SETの中では;ではなく,
SET
URL = :url,
COMMENT = :comment,
DATE = now(),
IDO = :ido,
KEIDO = :keido,
NAME = :name,
VISIT = :visit,
TRIP_DATE = :trip_date

WHERE
ID = :id

'
);

$stmt->bindValue(':url', $url, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':ido', $ido, PDO::PARAM_INT);
$stmt->bindValue(':keido', $keido, PDO::PARAM_INT);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':visit', $visit, PDO::PARAM_BOOL);
$stmt->bindValue(':trip_date', $trip_date, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute();

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: select.php');
    exit();
}

?>