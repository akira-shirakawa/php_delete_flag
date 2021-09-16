<?php
ini_set('display_errors', 1);
require_once '../Class/Dbc.php';
$main = new Db('comments');
$comment = new Db('log');
$type = $_POST['data_type'];
if($type == 'create'){
    $main->create(['delete_flag'=>0]);
    $sql = 'select id from comments order by id desc limit 1';
    $stmt = $comment->dbc()->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $comment->create(['comment'=>$_POST['comment'],'comment_id'=>(int)$result['id'],'statue'=>'created']);

}elseif($type == 'edit'){
    $comment->create(['comment'=>$_POST['comment'],'comment_id'=>(int)$_POST['comment_id'],'statue'=>'updated','comment_old'=>$_POST['comment_old']]);
}else{
    $time=date('Y-m-d h:i:s', time());
    $sql = "update comments set delete_flag=1,created_at=? where id =?";
    $stmt = $main->dbc()->prepare($sql);
    $stmt->execute([$time,(int)$_POST['comment_id']]);
    $comment->create(['comment_id'=>(int)$_POST['comment_id'],'statue'=>'deleted']);
}
header('Location:../View/index.php');