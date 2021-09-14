<?php
ini_set('display_errors', 1);
require_once '../Class/Dbc.php';
$comment = new Db('comments');
$log = new Db('log');
$id = $_GET['id'] ?? null;
$data=$comment->getPagenate($id)[0];
$all_page = $comment->getPagenate($id)[1];
$message = $_GET['message'] ?? null;
if($message){
    $search_result = $comment->search($message);
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
    <a href="log.php" class="navbar-item">
        処理履歴
    </a>
</nav>
<div class="modal js-add-target">
  <div class="modal-background"></div>
  <div class="modal-content">
    <div class="box">
        <form action="../Main/create_comment.php" method="post">
        <p>コメントを追加</p>
            <input type="text" name="comment" id="" class="input">
            <input type="submit" value="送信" class="button">
        </form>
    </div>
  </div>
  <button class="modal-close is-large" aria-label="close"></button>
</div>

<div class="modal js-edit-target">
  <div class="modal-background"></div>
  <div class="modal-content">
    <div class="box">
        <form action="../Main/edit_comment.php" method="post" id="js-edit-form-target">
        <p>コメントを編集</p>
            <input type="text" name="comment" id="js-edit-target" class="input" value="">
            <input type="hidden" name="comment_id" id="js-edit-target-hidden" value="">
            <input type="hidden" name="comment_old" id="js-edit-target-old" value="">
            <input type="submit" value="送信" class="button">
        </form>
    </div>
  </div>
  
</div>
<div class="columns">
    <div class="column"></div>
    <div class="column is-half">
    <div class="head">
        <button class="button is-info js-button-add-target">新規追加</button>
        <div class="search_box">
            <button class="button js-submit-target"><i class="fas fa-search"></i></button>
            <form action="" method="get" id="js-search">
                <input type="text" name ="message" class="search_form_input" placeholder="検索">
            </form>
        </div>
    </div>
    <table class="table is-fullwidth">
        <tr><th>ID</th><th>コメント</th><th></th></tr>
        <?php foreach($search_result ?? $data as $value): ?>
            <tr>
            <td><?php echo $value['id'] ?></td> 
            <td><?php echo $log->getDataNew($value['id'],'comment_id')[0]['comment'] ?? $value['comment'] ?></td>
            <td><button class="<?php echo $value['id'] ?> button is-info js-edit-button">編集</button><button class="<?php echo $value['id'] ?> button is-danger js-delete-button">消去</button></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php if(!$message): ?>
        <?php for($i=1;$i<=$all_page;$i++) :?>
            <a href="?id=<?php echo $i?>" class="pagination-link link-<?php echo $i ?>"><?php echo$i;?></a>
        <?php endfor; ?>
    <?php endif; ?>
    </div>
    <div class="column"></div>
</div>
<form action="../Main/delete_comment.php" method="post" id="js-delete-form-target">
<input type="hidden" name="comment_id" id="js-delete-target">
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="main.js"></script>  
</body>
</html>