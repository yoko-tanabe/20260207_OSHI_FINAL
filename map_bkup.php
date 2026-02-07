<?php
//funcs.phpを呼び出す
require_once('func.php');
login_check();
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
    function init() {
      //地図を表示するdiv要素のidを設定
      let map = L.map('mapcontainer');
      //地図の中心とズームレベルを指定
      map.setView([35.40, 136], 5);
      
    //   注意すべき点としてLeafletは地図の表示処理とUI操作を制御するライブラリであり、
    // 地図そのものの画像（タイル）は別途用意する必要があります。
      //表示するタイルレイヤのURLとAttributionコントロールの記述を設定して、地図に追加する

      L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/std/{z}/{x}/{y}.png', {
        maxZoom : 18,
          attribution: "<a href='https://maps.gsi.go.jp/development/ichiran.html' target='_blank'>国土地理院タイル</a>"
      }).addTo(map);
      

// //マーカーを作る
//          let marker = L.marker([37.508106, 139.930239]).addTo(map);
// //クリックした際にポップアップメッセージを表示する
//          marker.bindPopup("会津若松駅");

addMarker(map, 37.508106, 139.930239, "会津若松駅");
    }


//地図をしていた上で緯度経度と場所の情報を入力すると、地図上にマーカーが置かれる
function addMarker(map, ido, keido, location_name){
  //マーカーを作る
  //mapもinitの中でしか定義されていないことに注意する
         let marker = L.marker([ido, keido]).addTo(map);
//クリックした際にポップアップメッセージを表示する
         marker.bindPopup(location_name);  
}


  </script>
  <script src="js/main.js"></script>
</body>
</html>