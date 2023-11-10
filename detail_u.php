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
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE id=:id;");
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
    <title>USERデータ更新</title>
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
                <div class="navbar-header"><a class="navbar-brand" href="select_u.php">USERデータ一覧</a></div>
            </div>
        </nav>
    </header>

    <!-- method, action, 各inputのnameを確認してください。  -->
    <form method="post" action="update_u.php">
        <div class="jumbotron">
            <fieldset>
                <legend>USER登録</legend>
                <label>名　前: <input type="text" name="name" value="<?= $result['name'] ?>"></label><br>
                <label>　ID　: <input type="text" name="lid" value="<?= $result['lid'] ?>"></label><br>
                <label>　PW　: <input type="text" name="lpw" value="<?= $result['lpw'] ?>"></label><br>
                <label>管理FLG: <input type="text" name="kanri_flg" value="<?= $result['kanri_flg'] ?>"></label><br>
                <label>使用FLG: <input type="text" name="life_flg" value="<?= $result['life_flg'] ?>"></label><br>
                <input type="hidden" name="id" value="<?= $result['id']?>">
                <input type="submit" value="更新">
            </fieldset>
        </div>
    </form>
</body>

</html>
