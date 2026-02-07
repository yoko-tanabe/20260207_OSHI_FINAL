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
  exit('DBConnectError:' . $e->getMessage());
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
$locations = [];
if ($status == false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt_all->errorInfo();
  exit("ErrorQuery:" . $error[2]);
} else {
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  //1行ずつとってくる
  while ($result = $stmt_all->fetch(PDO::FETCH_ASSOC)) {

    //画面表示用
    $view .= '<p>';
    $view .= h($result['NAME']) . ' ' . h($result['URL']) . ' ' . h($result['COMMENT']);
    //$view = $result['date'].$result['name'].$result['email'].$result['date']; にするとWhileが回るたびに上書きされてしまう
    $view .= '<a href="detail.php?id=' . $result['ID'] . '">';
    $view .= ':更新';

    if ($_SESSION['kanri_flg'] === 1) {
      $view .= '<a  href="delete.php?id=' . $result['ID'] . '">';
      $view .= ':削除';
      $view .= '</a>';
    }

    $view .= '</p>';


    //Mapへの表示用

      $locations[] = [
        'ido' => $result['IDO'],
        'keido' => $result['KEIDO'],
        'name' => $result['NAME']
      ];
  
  }
  // var_dump($locations);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leafletで地図表示する</title>
  <!-- <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css"> -->
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/select.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.0/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>

  <!-- BODYに書いても大丈夫そう -->
  <!-- <script>
    function init() {
      //地図を表示するdiv要素のidを設定
      let map = L.map('mapcontainer');
      //地図の中心とズームレベルを指定
      map.setView([35.40, 136], 5);
      //表示するタイルレイヤのURLとAttributionコントロールの記述を設定して、地図に追加する
      L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/std/{z}/{x}/{y}.png', {
          attribution: "<a href='https://maps.gsi.go.jp/development/ichiran.html' target='_blank'>地理院タイル</a>"
      }).addTo(map);
    }
  </script> -->
</head>

<!-- onloadの記載がないと動かない -->
<!-- onloadを書くと全てのDOMツリー構造および関連リソースが読み込まれた後にJSが実行されるようになる -->
<!-- そのためheadにJSを書いてもエラーがなくなる -->
<!-- https://www.sejuku.net/blog/19754 -->
<!--  -->
<!-- <body> -->
<!-- https://ktgis.net/service/leafletlearn/index.html -->

<body onload="init()">
  <div id="mapcontainer"></div>
  <!-- Leaflet.js使い方 -->
  <!-- <div id="mapcontainer" style="width:600px;height:600px"></div> -->

  <script>
    const locations = <?= json_encode($locations, JSON_UNESCAPED_UNICODE); ?>;
  </script>

  <script>
    function init() {
      //地図を表示するdiv要素のidを設定
      let map = L.map('mapcontainer');
      //地図の中心とズームレベルを指定
      map.setView([35.65846772315217, 139.7004321239193], 12);

      //   注意すべき点としてLeafletは地図の表示処理とUI操作を制御するライブラリであり、
      // 地図そのものの画像（タイル）は別途用意する必要があります。
      //表示するタイルレイヤのURLとAttributionコントロールの記述を設定して、地図に追加する

      L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/std/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: "<a href='https://maps.gsi.go.jp/development/ichiran.html' target='_blank'>国土地理院タイル</a>"
      }).addTo(map);


      // //マーカーを作る
      //          let marker = L.marker([37.508106, 139.930239]).addTo(map);
      // //クリックした際にポップアップメッセージを表示する
      //          marker.bindPopup("会津若松駅");




      //地図をしていた上で緯度経度と場所の情報を入力すると、地図上にマーカーが置かれる
      function addMarker(map, ido, keido, location_name) {
        //マーカーを作る
        //mapもinitの中でしか定義されていないことに注意する
        let marker = L.marker([ido, keido]).addTo(map);
        //クリックした際にポップアップメッセージを表示する
        marker.bindPopup(location_name);
      }

      locations.forEach(loc => {
        addMarker(map, Number(loc.ido), Number(loc.keido), loc.name);
      })
      
console.log(locations);
    };




  </script>
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