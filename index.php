<?php

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

    <header>
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="select.php">MAP一覧</a>
            </div>
            <div class="navbar-collapse">
                <ul class="navbar-nav">
                    <li><a href="login.php" class="button button-login">ログイン</a></li>
                    <li><a href="logout.php" class="button button-logout">ログアウト</a></li>
                </ul>
            </div>
        </div>
    </header>


    <h1>新規登録</h1>
        <!-- action 属性は、フォームのデータがどこに送信されるかを指定するために使います -->
        <form action= "location_data.php" method="POST" enctype="multipart/form-data">
            <!-- 写真 : <input type="image" name="images">     -->
            <div class="data_input" id="data_input_url">
                <label for="url"> Google MAP URL </label>
                <input type="text" name="url">
            </div>

            <div class="data_input" id="data_input_comment">
                <label for="comment"> 緯度 </label>
                <input type="text" name="ido" placeholder="緯度 0-90">
            </div>

                        <div class="data_input" id="data_input_comment">
                <label for="comment"> 経度 </label>
                <input type="text" name="keido" placeholder="経度 0-180">
            </div>

             <div class="data_input" id="data_input_comment">
                <label for="comment"> 名前 </label>
                <input type="text" name="name" placeholder="場所の名前">
            </div>


            <div class="data_input" id="data_input_comment">
                <label for="comment"> コメント </label>
                <input type="text" name="comment" placeholder="出演番組名や記事名、思ったことなど">
            </div>

            <div class="form_input">
                <label for="img">関連する写真</label>

                <!-- image/*は画像ファイルならなんでもOKという意味。image/pdfなら.pdfだけOK -->
                <input type="file" name="img" accept="image/*" >
            </div>
<!-- 
            <div class="form_input">
                <label for="url">URL : </label>
                <input type="text" name="url">
            </div>

            <div class="form_input">

                <label for="category">Type : </label>
                <select name="category" id="">
                    <option value="cheek">Cheek</option>
                    <option value="lip">Lip</option>
                    <option value="eye_shadow">Eye Shadow</option>
                </select>
            </div>

            <div class="form_input">

                <label for="brand">Brand : </label>
                <select name="brand" id="">
                    <option value="suqqu">Suqqu</option>
                    <option value="cosme_decorte">Cosme Decorte</option>
                    <option value="Kanebo">Kanebo</option>
                </select>
            </div> -->


            <!-- https://form.run/home/blog/contact/design/javascript -->
            <!-- 発火方法は３種類ある -->
            <input type="submit" value="送信">
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