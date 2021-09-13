<?php
ini_set('display_errors', 1);
require_once '../Class/Dbc.php';
$comment = new Db('comments');
$time=date('Y-m-d h:i:s', time());
$sql = "update comments set comment = ?, comment_old=?,created_at=? where id =?";
$stmt = $comment->dbc()->prepare($sql);
$stmt->execute([$_POST['comment'],$_POST['comment_old'],$time,(int)$_POST['comment_id']]);

header('Location:../View/index.php');