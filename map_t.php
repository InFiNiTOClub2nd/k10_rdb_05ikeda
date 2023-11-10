<?php
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
  <meta charset="utf-8">
  <title>経歴地図登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
    }
  </style>
<script src="js/jquery-2.1.3.min.js"></script>
<link rel="stylesheet" href="css/sample.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" 
                href="select.php">経歴データ一覧</a></div>
            </div>
        </nav>
        <!-- <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand" 
                href="index_t.php">クリック地図データ登録</a></div>
            </div>
        </nav> -->
    </header>  
    <!-- MapArea -->
  <div id="view"></div>
    <div id="myMap" style="width: 1000px;height: 1000px;">
  </div>

  
  <form action = "index_t.php" method = "post" id = "point" name = "point">
    <input type = "hidden" id = "lat" name = "lat" > 
    <input type = "hidden" id = "lon" name = "lon" > 
  </form>
  
  
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
    function mapsInit(position){
      // 緯度経度取得 lat=緯度 lon=経度
      const now_lat = position.coords.latitude;
      const now_lon = position.coords.longitude;
      // const now_alt = position.coords.altitude;
      // console.log(now_lat);
      // console.log(now_lon);
      // console.log(now_alt);
      //Map表示
      map = new Bmap("#myMap");
      map.startMap(now_lat,now_lon,"load",6.5);//Mapの開始位置

      // クリックした場所にinfoBoxを立てる
          map.onGeocode("click", function(data){
          console.log(data);                   //Get Geocode ObjectData
          const lat = data.location.latitude;  //Get latitude
          const lon = data.location.longitude; //Get longitude
          // const alt = data.location.altitude;
          console.log(lat);
          console.log(lon);
          let pin = map.pin(lat,lon,"#000000");
          // console.log(alt);
          
          // document.getElementById("lat").textContent = lat ;
          // console.log("ok");

          // map.infobox(lat,lon,"今押した場所","説明文");

    // //InfoBoxを表示
    map.onPin(pin,"click",function(){
      // console.log(lat);
      // console.log(lon);
      const lat_h = <?= '"緯度:'.$result[lat].'"' ?> 
      const lon_h = <?= '"経度:'.$result[lon].'"' ?> 
      // console.log(lat_h);
      // console.log(lon_h);
      map.infobox(lat,lon,lat_h,lon_h);

      
      $('#lat').val(lat);
      $('#lon').val(lon);
      console.log(lat);
      console.log(lon);
      $("#point").submit();

      // $_SESSION["lat_t"] = lat;
      // console.log(ok);
      // $_SESSION["lon_t"] = lot;
      // console.log(ok);
      // $lat_t = $_SESSION['lat_t'];
      // $lon_t = $_SESSION['lon_t'];
      // echo $lat_t;
      // echo $lon_t;
  });
  //  <!-- method, action, 各inputのnameを確認してください。  -->
}); 
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