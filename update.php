<?php
//入力チェック(受信確認処理追加)
if(
  !isset($_POST['id']) || $_POST['id']=='' ||
  !isset($_POST['bookname']) || $_POST['bookname']=='' ||
  !isset($_POST['bookurl']) || $_POST['bookurl']=='' ||
  !isset($_POST['detail']) || $_POST['detail']==''
){
  exit('ParamError');
}

//1. POSTデータ取得
$id     = $_POST['id'];
$bookname   = $_POST['bookname'];
$bookurl  = $_POST['bookurl'];
$detail = $_POST['detail'];
date_default_timezone_set('Asia/Tokyo');
$indate = date("Y-m-d H:i:s");

//2. DB接続します(エラー処理追加)

include('functions.php');
$pdo = db_conn();

//3．データ登録SQL作成
$stmt = $pdo->prepare("UPDATE ". $table ." SET bookname=:a1,bookurl=:a2,detail=:a3,indate=:a4 WHERE id=:id");
$stmt->bindValue(':a1', $bookname ,PDO::PARAM_STR);
$stmt->bindValue(':a2', $bookurl ,PDO::PARAM_STR);
$stmt->bindValue(':a3', $detail, PDO::PARAM_STR);
$stmt->bindValue(':a4', $indate, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ登録処理後
if($status==false){
  errorMsg($stmt);
}else{
  header('location: detail.php?id='.$id);
  exit;
}
?>
