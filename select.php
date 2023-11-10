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
$stmt = $pdo->prepare("SELECT * FROM yama_kei_table");

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
        $view .= '<a href="detail.php?id=' . $result['id'] . '">';
        // $view .= $result['num'].':'.$result['lat'].':'.$result['lon'].':'.$result['alt'].':'
        // .$result['k_name'].':'.$result['s_year'].':'.$result['y_name'].':'.$result['etc'];
        $view .= $result['num'].':'.$result['k_name'].':'.$result['s_year'].':'.$result['etc'];
        $view .= '</a>';
        $view .= '<a href="delete.php?id=' . $result['id'] . '">';//追記
        $view .= '   [削除] ';//追記
        $view .= '</a>';//追記
        // $view .= '<a href="map.php?id=' . $result['id'] . '">';//追記
        $view .= '<a href="select.php?id=' . $result['id'] . '">';//追記
        $view .= '   [地図表示] ';//追記
        $view .= '</a>';//追記


        $view .= '</p>';

// array_push($dim_lat) ; 
// array_push($dim_lon) ; 
// echo $dim_lat;
// echo $dimu_lon;

// $dim = array();
// array_push($dim); 
// print_r($dim);


// pinを打つための配列にデータを保存

$array = [
  [$result['lat'],$result['lon'],$result['k_name']],
];
  foreach($array as $vals){
      echo '　北緯:'.$vals[0].',　東経:'.$vals[1].',　工事名:'.$vals[2];
      echo '<br>';
  }
}
    //1.対象のIDを取得
    $id = $_GET["id"];
    //3.地図data受取SQLを作成
    $stmt = $pdo->prepare("SELECT * FROM yama_kei_table WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute(); //実行
        //4．データ表示
    $view_1 = '';
    if ($status == false) {
        sql_error($status);
    } else {
        $result = $stmt->fetch();//ここを追記！！
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>経歴データ一覧</title>
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
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <div>
    <!-- <div class="container jumbotron">     -->
        <div class="container-fluid">
            <!-- <a href="select.php"></a> -->
            <a href="detail.php"></a>
            <?= $view ?>
        </div>
    </div>
    <!-- Main[End] -->
    

  <!-- <input type="submit" value="表示"> -->

    <!-- MapArea -->
 <div id="view_1"></div>
  <div id="myMap" style="width: 1000px;height: 1000px;"></div>
  <!-- /MapArea -->


<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- JQuery -->

 

  <!-- jQuery&GoogleMapsAPI -->
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=Amd84VwxSptT2cHsO8hlJ93s6Yy8ffivd1BiyizIgmbeH3COcxKJWOj_W0Fw6F0I'
    async defer></script>
  <script src="js/BmapQuery.js"></script>
  
  <script>
    //****************************************
    //最初に実行する関数
    //****************************************
    function GetMap(){
      navigator.geolocation.getCurrentPosition(mapsInit, mapsError, set);
    }
    //****************************************
    //成功関数
    //****************************************
    let map;
    // let hairetsu;???
    function mapsInit(position){
      // 緯度経度取得 lat=緯度 lon=経度
      const now_lat = position.coords.latitude;
      const now_lon = position.coords.longitude;

      //Map表示
      map = new Bmap("#myMap");
      map.startMap(now_lat,now_lon,"load",6);//Mapの開始位置
      
      // array.forEach(function( vals ) {
      // console.log( vals );
      // });

      // forEach($array as $vals){
      // echo '　北緯:'.$vals[0].',　東経:'.$vals[1].',　工事名:'.$vals[2];
      // echo '<br>';
      // console.log( $vals[0] );
      // console.log(ok);
      // }
      
      // for (  var i = 0;  i < array.length;  i++  ) {
        for (  var i = 0;  i < 10;  i++  ) {
        // forEach($array as $vals){
        const lat = <?= $vals[0] ?> 
        const lon = <?= $vals[1] ?> 
        console.log(lat);
        console.log(lon);       


        // const lat = <?= $result['lat'] ?> 
        // const lon = <?= $result['lon'] ?> 
        // const k_name = <?= '"'.$result['k_name'].'"' ?> 
        // const etc = <?= '"北緯:'.$result['lon'].'東経:'.$result['lat'].'標高:'.$result['alt'].'m,竣工:'.$result['s_year'].',住所:'.$result['etc'].'"' ?> 
        // console.log(lat);
        // console.log(lon);
        // console.log(k_name);
        // console.log(etc);
 
        let pin = map.pin(lat,lon,"#000000");

      }
      
    //InfoBoxを表示
        map.onPin(pin,"click",function(){
        map.infobox(lat,lon,k_name,etc);});
    }

    //****************************************
    //失敗関数
    //****************************************
    function mapsError(error) {
      let e = "";
      if (error.code == 1) { //1＝位置情報取得が許可されてない（ブラウザの設定）
        e = "位置情報が許可されてません";
      }
      if (error.code == 2) { //2＝現在地を特定できない
        e = "現在位置を特定できません";
      }
      if (error.code == 3) { //3＝位置情報を取得する前にタイムアウトになった場合
        e = "位置情報を取得する前にタイムアウトになりました";
      }
      alert("エラー：" + e);
    };
    //****************************************
    //オプション設定
    //****************************************
    const set = {
      enableHighAccuracy: true, //より高精度な位置を求める
      maximumAge: 20000, //最後の現在地情報取得が20秒以内であればその情報を再利用する設定
      timeout: 10000 //10秒以内に現在地情報を取得できなければ、処理を終了
    };
  </script>
</body>
</html>