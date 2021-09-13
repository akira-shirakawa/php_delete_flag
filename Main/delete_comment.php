<?php
ini_set('display_errors', 1);
require_once '../Class/Dbc.php';
$comment = new Db('comments');
$time=date('Y-m-d h:i:s', time());
$sql = "update comments set delete_flag=1,created_at=? where id =?";
$stmt = $comment->dbc()->prepare($sql);
$stmt->execute([$time,(int)$_POST['comment_id']]);

header('Location:../View/index.php');