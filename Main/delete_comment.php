<?php
ini_set('display_errors', 1);
require_once '../Class/Dbc.php';
$comment = new Db('comments');
$log = new Db('log');
$time=date('Y-m-d h:i:s', time());
$sql = "update comments set delete_flag=1,created_at=? where id =?";
$stmt = $comment->dbc()->prepare($sql);
$stmt->execute([$time,(int)$_POST['comment_id']]);
$log->create(['comment_id'=>(int)$_POST['comment_id'],'statue'=>'deleted']);
header('Location:../View/index.php');