<?php
//【重要】
/**
 * DB接続のための関数をfuncs.phpに用意
 * require_onceでfuncs.phpを取得
 * 関数を使えるようにする。
 */
//SESSIONスタート
session_start();
require_once('funcs.php');
//ログインチェック
loginCheck();
$pdo = db_conn();

//２．SQL文を用意(データ取得：SELECT)
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");

//3. 実行
$status = $stmt->execute();

//4．データ表示
$view="";//空のviewを作成
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
        //GETデータ送信リンク作成
        // <a>で囲う。
        $view .= '<p>';
        $view .= '<a href="detail_u.php?id=' . $result['id'] . '">';
        // $view .= $result['name'].':'.$result['lid'].':'.$result['lpw'].':'
        // .$result['kanri_flg'].':'.$result['life_flg'];
        $view .= $result['name'].':'.$result['lid'].':'
        .$result['kanri_flg'].':'.$result['life_flg'];
        $view .= '</a>';
        $view .= '<a href="delete_u.php?id=' . $result['id'] . '">';//追記
        $view .= '   [削除] ';//追記
        $view .= '</a>';//追記
        $view .= '</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>USERデータ一覧</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">経歴データ登録</a>
                    <a class="navbar-brand" href="index_u.php">USERデータ登録</a>
                </div>
            </div>
        </nav>

        <!-- <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="map_t.php">経歴データ地図登録</a>
                </div>
            </div>
        </nav> -->
    </header>
    <!-- Head[End] -->
    <!-- Main[Start] -->
    <div>
        <div class="container jumbotron">
            <a href="detail_u.php"></a>
            <?= $view ?>
        </div>
    </div>
    <!-- Main[End] -->
</body>
</html>