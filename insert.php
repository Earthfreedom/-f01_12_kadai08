<?php
//入力チェック(受信確認処理追加)
if(
  !isset($_POST['bookname']) || $_POST['bookname']=="" ||
  !isset($_POST['bookurl']) || $_POST['bookurl']=="" ||
  !isset($_POST['detail']) || $_POST['detail']==""
){
  exit('ParamError');
}

//1. POSTデータ取得
$bookname   = $_POST['bookname'];
$bookurl  = $_POST['bookurl'];
$detail = $_POST['detail'];
date_default_timezone_set('Asia/Tokyo');
$indate = date("Y-m-d H:i:s");

//2. DB接続します(エラー処理追加)
include('functions.php');
$pdo= db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO ". $table ."(id, bookname, bookurl, detail, indate )VALUES(NULL, :a1, :a2, :a3, :a4)");
$stmt->bindValue(':a1', $bookname, PDO::PARAM_STR);
$stmt->bindValue(':a2', $bookurl, PDO::PARAM_STR);
$stmt->bindValue(':a3', $detail, PDO::PARAM_STR);
$stmt->bindValue(':a4', $indate, PDO::PARAM_STR);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  errorMsg($stmt);
}else{
  //５．index.phpへリダイレクト
  header('Location: index.php');
  exit;
}
?>
