<?php
  session_start();
  //エラーの表示
  if($_SESSION['msg']){
    echo $_SESSION['msg'];
    //セッションを破壊する
    session_destroy();
  }
    
  try {
    //データベース接続情報
      $db = connectDB();
      //echo '接続成功';
  } catch (PDOException $e) {
      echo 'DB接続エラー: ' . $e->getMessage();
      return;
  }

  // エラーを格納する変数
  $err = [];     
  // 「ログイン」ボタンが押されて、POST通信のときname取得
  if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    $sign_in_id_POST = filter_input(INPUT_POST, 'sign_in_id');
    $password = filter_input(INPUT_POST, 'password');
    if ($sign_in_id_POST === '') {
        $err['sign_in_id_POST'] = 'サインインIDは入力必須です。';
        echo $err['sign_in_id_POST'];
        return;
    } 
    //パスワード未入力チェック
    if ($password === '') {
        $err['password'] = 'パスワードは入力必須です。';
        echo $err['password'];
        return;
    }
    // $error 0件の時の処理
    if (count($err) === 0) {
      
      try{
        // DB接続
        $pdo = connectDB();
        // SQLの準備（prepareメソッドにて実装）
        $sql = 'SELECT * FROM user WHERE sign_in_id = ?';
        // sign_in_id_を配列に入れる
        $arr = [];
        $arr[] = $sign_in_id_POST;

        try {
          $stmt = $pdo->prepare($sql);
          $stmt->execute($arr);
          // SQLの結果を返す
          $user = $stmt->fetch();
        } catch(\Exception $e) {
          return false;
        }
        //サインインIDが見つからない場合
        if (!$user) {
          $_SESSION['msg'] = 'サインインIDが一致しません。登録済みのサインインIDかご確認ください';
          header('Location:/php_db/index.php');
          return;
          
        }
        //パスワードの照会
        //ハッシュ化してパスワード比較した。上手く比較ができないので、平文で比較するロジックで実装
        if ($password == $user['password']){
          //ログイン成功
          //セッションハイジャック対策としてセッション再取得
          session_regenerate_id(true);
          $_SESSION['login_user'] = $user;
          header('Location:/php_db/chat.php');
          return;
        }else{
          //パスワードが一致しなかった場合
          $_SESSION['msg'] = 'パスワードが一致しません。';
          header('Location:/php_db/index.php');
          return;
        }
      } catch (PDOException $e) {
      echo 'DB接続エラー: ' . $e->getMessage();
      }
    }
  }  
  // DB接続
  //任意のDB・ユーザー・パスワードを入力する
  function connectDB() {
    $dbh = new PDO('mysql:dbname=pbboard2022;host=localhost;charset=utf8','root','pass');
    return $dbh;
  }      
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>ログイン画面</title>
    </head>
    <body>
        <form action="" method="post">
             <label for=""><span>サインインID</span>
                <input type="text" name="sign_in_id" id=""><br>
            </label>
            <label for=""><span>パスワード</span>
                <input type="text" name="password" id=""><br>
            </label>
            <input type="submit" value="ログイン"/>
        </form>
    </body>
</html>
