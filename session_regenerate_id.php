<?php

session_start();


//現在のセッションIDを取得
$old_session_id = session_id();

//新しいIDにする
session_regenerate_id(true);

//新しいセッションIDを取得
$new_session_id = session_id();

//旧セッションIDと新セッションIDを表示
echo '古いセッション:' . $old_session_id . '<br />';
echo '新しいセッション:' . $new_session_id . '<br />';
