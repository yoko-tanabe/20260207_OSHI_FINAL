// 1. ターゲットとなる地点の座標（例：東京駅）
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

//検証用のダミーの現在地
latitude = 35.681246
longitude = 139.767135
const distance = getDistance(latitude, longitude, target.latitude, target.longitude);

//Math.roundがMathのメソッド
console.log(`現在地からの距離: ${Math.round(distance)}m`);

if (distance <= radius && !hasAlerted) {
    alert("ターゲットから100m以内に到達しました！");
    hasAlerted = true; // 一度アラートを出したら止める場合
} else if (distance > radius) {
    hasAlerted = false; // 範囲外に出たらフラグをリセット
}
else {
    alert("このブラウザは位置情報をサポートしていません。");
}
