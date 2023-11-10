<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>USERデータ登録</title>
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
                <div class="navbar-header"><a class="navbar-brand" href="select_u.php">USERデータ一覧</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="login.php">ログイン</a></div>
                <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
            </div>
        </nav>
    </header>

    <!-- method, action, 各inputのnameを確認してください。  -->
    <form method="post" action="insert_u.php">
        <div class="jumbotron">
            <fieldset>
                <legend>USER登録</legend>
                <label>名　前: <input type="text" name="name"></label><br>
                <label>　ID　: <input type="text" name="lid"></label><br>
                <label>　PW　: <input type="text" name="lpw"></label><br>
                <label>管理FLG: <input type="text" name="kanri_flg"></label><br>
                <label>使用FLG: <input type="text" name="life_flg"></label><br>
                <input type="submit" value="登録">
            </fieldset>
        </div>
    </form>
</body>

</html>
