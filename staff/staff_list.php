<?php
require_once('../env.php');
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login']) == false){
    echo "ログインされていません<br>";
    echo "<a href='../staff_login/staff_login.html'>ログイン画面へ</a>";
    exit();
}else{
    echo $_SESSION['staff_name']."さんログイン中<br>";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スタッフ一覧ページ</title>
</head>
<body>
    <?php
    try{
        //データベース接続
        $dbh = new PDO($dsn,$user,$pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        //SQLの実行
        $sql = "SELECT code,name FROM mst_staff WHERE 1";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        //データベースから切断
        $dbh = null;

        echo "<h2>スタッフ一覧</h2>";
        echo "<form method='post' action='staff_branch.php'>";

        while(true){
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            if($rec == false){
                break;
            }
            echo "<input type='radio' name='staffcode' value='".$rec["code"]."'>";
            echo $rec['name']."<br>";
        }
        echo "<input type='submit' name='disp' value='参照'>";
        echo "<input type='submit' name='add' value='追加'>";
        echo "<input type='submit' name='edit' value='修正'>";
        echo "<input type='submit' name='delete' value='削除'>";
        echo "</form>";
    }catch(Exception $e){
        echo "失敗しました";
        exit();
    }
    ?>
</body>
</html>