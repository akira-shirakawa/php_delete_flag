<?php
ini_set('display_errors', 1);
require_once '../Class/Dbc.php';
$log = new Db('log');
$message = $log->getMessage();
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
   
    <table class="table is-fullwidth">
        <tr><th>ID</th><th>処理</th><th>修正前</th><th>修正後</th><th>修正日時</th></tr>
        <?php foreach($message as $value): ?>
            <tr class="<?php echo $value['statue']?>">
                <td><?php echo $value['id'] ?></td>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="main.js"></script>  
</body>
</html>