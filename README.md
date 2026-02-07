# ①課題名
推しのロケ地等を記録し、その現場に近づくとアラートや推しが言っていた発言が出てきて元気をもらえるアプリです
<img width="972" height="679" alt="スクリーンショット 2026-02-07 15 05 16" src="https://github.com/user-attachments/assets/7575bea0-077b-44d4-b9bf-ee8ad81f71a8" />
<img width="889" height="690" alt="スクリーンショット 2026-02-07 15 05 34" src="https://github.com/user-attachments/assets/f42c2689-2c4b-47c3-8771-3e25eb665526" />



## ②課題内容（どんな作品か）
-Google MapのURLにコメントをつけて残せるようにしました
ー　推しのロケ地等を記録し、マップに表示します
ー　自分の現在地がロケ地に近づいたら、OSHIの気配に近づいたというアラートが出てくることで、日々の日常においてOSHIの気配を感じることができます
ー　ロケ地の10メートル圏内に入ると、推しの過去のコメントがポップアップされ、元気をもらえます
ー　ロケ地巡りをするほどではないけど、緩く推し活をしたいという人向けです

## ③アプリのデプロイURL
https://taco-onigiri.sakura.ne.jp/20260207_OSHI_FINAL-SAKURA/

## ④アプリのログイン用IDまたはPassword（ある場合）
- ID: test1
- PW: test1

## ⑤工夫した点・こだわった点
- ロケーションのDBと推しのコメントのDBを分けて、外部キーで組み合わせられるようにしました
- DBのログイン情報をwww外に配置しました
- 管理者権限では登録地の削除ができますが、一般権限では登録地の削除ができないようにしました
- 登録した情報をマップに表示できるようにしました（前回の課題からのトライしたかった点の回収）
- 登録地点に近づくと、近づいた度合いに応じて挙動が変わるようにしました

## ⑥難しかった点・次回トライしたいこと（又は機能）
- Google MapのAPIと連携することで、Google Mapのurlのみを登録できるようにしたい
- 推しのメッセージを投稿できるようにしたかったが、時間がなかったので、事前に登録する形にした

## ⑦フリー項目（感想、シェアしたいこと等なんでも）
- [感想]
CSSやUIをAIに任せましたが、とても短時間でUIの叩きが出てきてよかったです。
卒業制作の内容とは少し違いますが、卒業制作でもマップを使う予定なので、こちらの成果物を流用して進めたいと思っています。

- [参考記事]
https://techplay.jp/column/548

leaflet jsは地図読み込みようのライブラリ

以下がとても詳しい

https://qiita.com/macole/items/9bdecdaf950b7fdc196a

https://zenn.dev/sweflo/articles/8c34c081cb764c

navigatorがbrowser自信を示すオブジェクト

https://segakuin.com/javascript/navigator/

https://atmarkit.itmedia.co.jp/ait/articles/1107/14/news119.html

https://chatgpt.com/s/t_69668a5261548191b9c7f79b3901e50a

**結論から言うと、W3C仕様書で書かれている「Attribute」は、JavaScript実装では「プロパティ」として表現されます。**

これは

**仕様（IDL）と言語（JavaScript）のレイヤーの違い**

https://chatgpt.com/s/t_69668a97a1ec81918cc0bcf942518a3a


https://chatgpt.com/s/t_69726c2921548191bd91fb100c24d6c4

