// 1. ターゲットとなる地点の座標（例：東京駅）

// let latitude=35.681236
// let longitude=139.767125

// console.log(latitude)

const target = {
  latitude: 35.681236,
  longitude: 139.767125
};

const radius = 100; // 判定距離（メートル）
let hasAlerted = false; // 重複アラート防止用

// 2. 2点間の距離を計算する関数（ハバーサイン公式）
function getDistance(lat1, lon1, lat2, lon2) {
  const R = 6371e3; // 地球の半径（メートル）
  const φ1 = lat1 * Math.PI / 180;
  const φ2 = lat2 * Math.PI / 180;
  const Δφ = (lat2 - lat1) * Math.PI / 180;
  const Δλ = (lon2 - lon1) * Math.PI / 180;

  const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
            Math.cos(φ1) * Math.cos(φ2) *
            Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

  return R * c; // 単位: メートル
}

// 3. 現在地の監視を開始
//geolocation APIで現在地を取得する
//watchPosition()で位置情報を監視、

//まずブラウザがgeolocation APIを持っているかを確認している
//navigatorとはブラウザ自身の情報が入っているオブジェクトのこと
if ("geolocation" in navigator) {
//位置情報 APIは navigator.geolocation への呼び出しを介してアクセスします
//Geolocation.watchPosition(): 端末の位置が変化するごとに自動的に呼び出され、更新された位置情報を返すハンドラー関数を登録します。
//watchPositionはGeolocationのメソッド 
navigator.geolocation.watchPosition(
  //coordsはposiitionオブジェクトが持つプロパティで、中身はオブジェクト

  //positionは　W3C仕様では：
// interface GeolocationPosition {
//   readonly attribute GeolocationCoordinates coords;
//   readonly attribute DOMTimeStamp timestamp;
// };
// つまり position はGeolocationPosition インターフェースのインスタンス
//ブラウザが勝手につくるからnewしなくて大丈夫
//position は「ブラウザが生成して、コールバック関数に渡してくる位置情報オブジェクト」
//positonを生成するのはwatchPosition
    function (position) {
      //coords atttribution : HTML要素の属性？
      const { latitude, longitude } = position.coords;
      const distance = getDistance(latitude, longitude, target.latitude, target.longitude);

      //Math.roundがMathのメソッド
      console.log(`現在地からの距離: ${Math.round(distance)}m`);

      if (distance <= radius && !hasAlerted) {
        alert("ターゲットから100m以内に到達しました！");
        hasAlerted = true; // 一度アラートを出したら止める場合
      } else if (distance > radius) {
        hasAlerted = false; // 範囲外に出たらフラグをリセット
      }
    },
   function  (error)  {
      console.error("位置情報の取得に失敗しました:", error.message);
    },
    {
      enableHighAccuracy: false, // 高精度モード（GPS使用）ならtrue**************
      maximumAge: 0,
      timeout: 10000
    }
  );
} else {
  alert("このブラウザは位置情報をサポートしていません。");
}
