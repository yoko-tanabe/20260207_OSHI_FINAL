<?php

$id = $_GET['id'];

//update.phpからコピーする
//config.phpを呼び出す
////////////require_once('../../config.php'); //さくらにあげるときはこっち
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

//SQLでデータを読み込む
$stmt = $pdo->prepare('SELECT * FROM timelesz_location WHERE id = :id;');
$stmt -> bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//エラー時はエラー表示をする
$result = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
   $result = $stmt->fetch();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSHI NO IRU BASHO</title>
    <!-- このCloudflareが何かを後で確認する -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>


    <div id="form">
    <div class="decoration_h_index"></div>

    <h1>登録内容の確認</h1>
        <!-- action 属性は、フォームのデータがどこに送信されるかを指定するために使います -->
        <form action= "update.php" method="POST" enctype="multipart/form-data">
            <!-- 写真 : <input type="image" name="images">     -->
            <div class="data_input" id="data_input_url">
                <label for="url"> Google MAP URL </label>
                <input type="text" name="url" value="<?=  $result['URL'] ?>>">
            </div>

            <div class="data_input" id="data_input_comment">
                <label for="comment"> コメント </label>
                <input type="text" name="comment" placeholder="出演番組名や記事名、思ったことなど" value="<?= $result['COMMENT'] ?>">
            </div>

            <div class="form_input">
                <label for="img">関連する写真</label>

                <!-- image/*は画像ファイルならなんでもOKという意味。image/pdfなら.pdfだけOK -->
                <input type="file" name="img" accept="image/*" >
            </div>
             <input type="hidden" name="id" value="<?= $result['ID'] ?>"> 
            <!-- https://form.run/home/blog/contact/design/javascript -->
            <!-- 発火方法は３種類ある -->
            <input type="submit" value="更新">
        </form>

        <div class="decoration_c">
        <div class="transfer">
            <a href="select.php">
                <button id="return_select_btn" type="button">一覧に戻る</button>
            </a>

        </div>
    </div>
</div>


</body>

</html>
