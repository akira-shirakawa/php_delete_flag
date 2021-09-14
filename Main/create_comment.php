<?php
ini_set('display_errors', 1);
require_once '../Class/Dbc.php';
$main = new Db('comments');
$comment = new Db('log');
$main->create(['delete_flag'=>0]);
$sql = 'select id from comments order by id desc limit 1';
$stmt = $comment->dbc()->query($sql);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$comment->create(['comment'=>$_POST['comment'],'comment_id'=>(int)$result['id'],'statue'=>'created']);
header('Location:../View/index.php');