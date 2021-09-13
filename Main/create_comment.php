<?php
ini_set('display_errors', 1);
require_once '../Class/Dbc.php';
$comment = new Db('comments');
$comment->create(['comment'=>$_POST['comment'],'delete_flag'=>0]);
header('Location:../View/index.php');