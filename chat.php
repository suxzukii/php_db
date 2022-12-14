<?php
    session_start();
    //ブラウザ更新したら実行されるプログラム
    try {
        $db = connectDB();
        //echo "接続OK！";
    } catch (PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    } 
    //$sql = "SELECT * FROM interact";
    //$sql = "SELECT * FROM sample";
    $sql = "SELECT user.user_no,user.name,sample.user_no_from, sample.message FROM sample INNER JOIN user ON user.user_no = sample.user_no_from";
    $sth = $db -> query($sql);
    $aryList = $sth -> fetchAll(PDO::FETCH_ASSOC);
    //チャット画面で表示させる連想配列の設定
    //$record = array_column($aryList, 'user_no_from', 'message');
    $record = array_column($aryList, 'name', 'message');
    //fetchで取り出してきたレコードを一行ずる改行
    print_r('<pre>');
    print_r($record);
    print_r('</pre>');
    //iput項目の表示
    print_r('<form action="" method="post">');
        print_r('<input type="text" name="message">');
        print_r('<input type="submit" value="送信">');
    print_r('</form>');   

    //メッセージのinserｔ処理
    if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
        $message = filter_input(INPUT_POST, 'message');
        
        //sessionよりユーザー情報の取得については実装していない。ハードコーディングで対応。
        $user_no_from = '2';
        $user_no_to = '1';
        $access = connectDB();
        //
        $stmt = $access -> prepare("INSERT INTO sample(user_no_from, user_no_to, message
            ) VALUES (
                :user_no_from, :user_no_to, :message
            )");

        //登録するデータをセット
        $stmt->bindParam(':user_no_from', $user_no_from, PDO::PARAM_STR);
        $stmt->bindParam(':user_no_to', $user_no_to, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        //SQL実行
        $stmt->execute();
        header('Location: ./chat.php');
        exit;
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
        <title>チャット画面</title>
    </head>
    <body>
    <a href ='index.php'>戻る</a>
</body>
</html>