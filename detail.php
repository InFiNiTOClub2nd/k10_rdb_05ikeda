<?php
session_start();

//selsect.phpから処理を持ってくる
//1.外部ファイル読み込みしてDB接続(funcs.phpを呼び出して)
require_once('funcs.php');


//ログインチェック
loginCheck();

$pdo = db_conn();

//2.対象のIDを取得
$id = $_GET['id'];

//3．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM yama_kei_table WHERE id=:id;");
$stmt->bindValue(':id',$id,PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ表示
$view = '';
if ($status == false) {
    sql_error($status);
} else {
    $result = $stmt->fetch();//ここを追記！！
}
?>

<!-- 以下はindex.phpのHTMLをまるっと持ってくる -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>経歴データ更新</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" href="select.php">経歴データ一覧</a></div>
            </div>
        </nav>
    </header>

    <!-- method, action, 各inputのnameを確認してください。  -->
    <form method="post" action="update.php">
        <div class="jumbotron">
            <fieldset>
                <legend>経歴データ更新</legend>
                <label>番　号: <input type="text" name="num" value="<?= $result['num'] ?>"></label><br>
                <label>緯　度: <input type="text" name="lat" value="<?= $result['lat'] ?>"></label><br>
                <label>経　度: <input type="text" name="lon" value="<?= $result['lon'] ?>"></label><br>
                <label>高　度: <input type="text" name="alt" value="<?= $result['alt'] ?>"></label><br>
                <label>工事名: <input type="text" name="k_name" value="<?= $result['k_name'] ?>"></label><br>
                <label>竣工年: <input type="text" name="s_year" value="<?= $result['s_year'] ?>"></label><br>
                <label>役職名: <input type="text" name="y_name" value="<?= $result['y_name'] ?>"></label><br>
                <label>その他: <input type="text" name="etc" value="<?= $result['etc'] ?>"></label><br>
                <input type="hidden" name="id" value="<?= $result['id']?>">
                <input type="submit" value="更新">
            </fieldset>
        </div>
    </form>
</body>

</html>
