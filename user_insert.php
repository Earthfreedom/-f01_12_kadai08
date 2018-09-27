<?php
//入力チェック(受信確認処理追加)
if(
  !isset($_POST['user_name']) || $_POST['user_name']=="" ||
  !isset($_POST['password']) || $_POST['password']=="" 
){
  exit('ParamError');
}

//1. POSTデータ取得
$user_name   = $_POST['user_name'];
$lpw  = $_POST['password'];
date_default_timezone_set('Asia/Tokyo');
$indate = date("Y-m-d H:i:s");

$life_flg=1;
$kanri_flg=0;

$lid=md5(uniqid(rand(),1));

//2. DB接続します(エラー処理追加)
include('functions.php');
$pdo= db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO ". $user_table ."(id, name, lid, lpw, kanri_flg ,life_flg )VALUES(NULL, :a1, :a2, :a3, :a4, :a5)");
$stmt->bindValue(':a1', $user_name, PDO::PARAM_STR);
$stmt->bindValue(':a2', $lid, PDO::PARAM_STR);
$stmt->bindValue(':a3', $lpw, PDO::PARAM_STR);
$stmt->bindValue(':a4', $kanri_flg, PDO::PARAM_STR);
$stmt->bindValue(':a5', $life_flg, PDO::PARAM_STR);
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  errorMsg($stmt);
}else{
  //５．index.phpへリダイレクト
  header('Location: user_index.php');
  exit;
}
?>
