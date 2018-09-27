<?php
//入力チェック(受信確認処理追加)
if(
  !isset($_POST['id']) || $_POST['id']=='' ||
  !isset($_POST['user_name']) || $_POST['user_name']=='' ||
  !isset($_POST['password']) || $_POST['password']==''
){
  exit('ParamError');
}

//1. POSTデータ取得
$id     = $_POST['id'];
$name   = $_POST['user_name'];
$lpw  = $_POST['password'];

//2. DB接続します(エラー処理追加)

include('functions.php');
$pdo = db_conn();

//3．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE ". $user_table ." SET name=:a1,lpw=:a2 WHERE id=:id");
$stmt->bindValue(':a1', $name ,PDO::PARAM_STR);
$stmt->bindValue(':a2', $lpw ,PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ登録処理後
if($status==false){
  errorMsg($stmt);
}else{
  header('location: user_detail.php?id='.$id);
  exit;
}
?>
