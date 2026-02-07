<?php
//POSTデータの取得
$product_name =$_POST['product_name'];
//<form> に enctype="multipart/form-data" がないとエラーになる。ファイルアップロードでは、formタグに 必須 でこれを指定しないと$_FILES 自体が空になります。
$img_name=$_FILES['img']['name'];
$url=$_POST['url'];
$category=$_POST['category'];
$brand=$_POST['brand'];

echo '<pre>';
var_dump($_POST);
var_dump($_FILES);
echo '</pre>';

//動かなっかのがFile sizeかを確認
// echo 'POSTサイズMAX';
// echo ini_get('post_max_size');
// echo 'UPLOAD_MAX';
// echo ini_get('upload_max_filesize');


// echo 'file_uplaodsがONになっているか';
// var_dump(ini_get('file_uploads'));

//画像を移動
//file_put_contentsは多分フォルダがなかったら新規で作ってくれるがmove_uploaded_fileは事前に作っておく必要がありそう
$result = move_uploaded_file($_FILES['img']['tmp_name'], 'img/'.$img_name);

if ($result == false){
    echo '書き込み失敗';
} else {echo "書き込み成功 ファイル名：".$img_name;}

// echo '<img src="img.php?img_name=' . $img_name . '">';
	//これ動く
// echo '<img src="img/AKB.jpg" >';
$current_dir="img/".$img_name;
//こっちは動かない
// echo <img src="$current_dir">; 何故ならechoは文字列のみ。HTMLを文字列とするひつようがある
//<img ...> は HTML
//echo は 文字列 しか出力できない
//シングルクオートしか動かない echo ''かecho" "が基本だけど、""だと中にさらに""が入るからNG
//''..''という構造になっている
//echoは基本的は’'' ""を横に記載すること。ただし変数丸出しであれば、不要である
echo '<img src="'.$current_dir.'">';
//または
echo "<img src=\"$current_dir\">";

//以下も動いちゃうけど正しくない。
//<img src= img/test.jpg>と解釈るすけど、正しくは＜<img src= "img/test.jpg">で””で囲む
// echo "<img src= $current_dir>";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>結果表示</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <br>
<?= $product_name ?><br>
<!-- <?php ?> -->
<?= $url ?> <br>
<?= $category ?> <br>
<?= $brand ?> <br>

        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <!-- <script src="js/main.js"></script> -->
</body>
</html>