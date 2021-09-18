<?php
ini_set('display_errors', 1);
require_once '../Class/Dbc.php';
$log = new Db('log');
$main = new Db('comments');
$main_message = $main->getMessage();
$message = $log->getMessage();
$get_message = $_GET['message'] ?? null;
$message_id = $_GET['message_id'] ?? null;
if($get_message){
    $search_result = $log->select($get_message);
}
if($message_id){
    $search_result = $log->getData((int)$message_id,'comment_id');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" defer ></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css" />
    <link rel="stylesheet" href="main.css">
    <title>Document</title>
</head> 
<body>
<nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <a class="navbar-item" href="./">
    <i class="fas fa-home"></i>
    </a>  
</nav>


<div class="columns">
    <div class="column"></div>
    <div class="column is-half">
        <div class="columns">
            <div class="column">
                <p>処理で絞り込み</p>
                <form action="" method="get">
                    <div class="select is-primary">
                        <select name="message">
                            <option value="created">追加のみ</option>
                            <option value="updated">更新のみ</option>
                            <option value="deleted">削除のみ</option>
                        </select>
                        <input type="submit" value="絞り込み" class="button is-small">
                    </div>
                </form>
            </div>
            <div class="column">
                <p>IDで絞り込み</p>
                <form action="" method="get">
                    <div class="select is-primary">
                        <select name="message_id">
                            <?php foreach($main_message as $value): ?>
                                <option value="<?php echo $value['id']?>"><?php echo $value['id']?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" class="button is-small" value="検索">
                    </div>
                </form>
            </div>
        </div>
  
 
    <table class="table is-fullwidth">
        <tr><th>ID</th><th>処理</th><th>修正前</th><th>修正後</th><th>修正日時</th></tr>
        <?php foreach($search_result ?? $message as $value): ?>
            <tr class="<?php echo $value['statue']?>">
                <td><?php echo $value['comment_id'] ?></td>
                <td><?php echo $value['statue'] ?></td>
            <?php if($value['statue'] == 'deleted') :?>
                <td><?php echo  $log->getDataNext($value['comment_id'],'comment_id')[0]['comment']?></td>
            <?php else : ?>
                <td><?php echo $value['comment_old'] ?></td>
            <?php endif; ?>
            <?php if($value['statue'] != 'deleted') :?>   
                <td><?php echo $value['comment']?></td>
            <?php else:?>
                <td></td>
            <?php endif;?>
                <td><?php echo $value['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
   
    </div>
    <div class="column"></div>
</div>
<style>

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="main.js"></script>  
</body>
</html>