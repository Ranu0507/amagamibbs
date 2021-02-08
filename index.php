<?php

date_default_timezone_set("Asia/Tokyo");
$timestamp = time();

$dataFile = "data.dat";
$posts = file ($dataFile, FILE_IGNORE_NEW_LINES);

if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['message'])) {

    if (empty($_POST['user'])) {
        $newData = $_POST['message'] . "|" . "ユーザー名";
    } else {
        $newData = $_POST['message'] . "|" . $_POST['user'];
    }
    $newData .= date("| Y-m-d H:i:s"); 
    array_unshift($posts, $newData);

    $fp = fopen($dataFile, "w");
    fwrite($fp, implode("\n", $posts));
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>一行掲示板</title>
</head>
<body>
    <h1>一行掲示板(<?php echo count($posts)?>件)</h1>
    <form action="" method="post">
        message:<input type="text" name="message">
        name:<input type="text" name="user">
        <input type="submit" value="投稿">
    </form>

    <h2>投稿一覧</h2>
    <ul>
        <?php if (count($posts)) : ?>
        <?php foreach ($posts as $post) :?>
        <?php list($message, $user, $time) = explode("|" , $post); ?>
        <li><?php echo htmlspecialchars($message); ?>(<?php echo htmlspecialchars($user); ?>)-<?php echo htmlspecialchars($time); ?></li>
        <?php endforeach; ?>
        <?php else :?>
        <li>まだ投稿はありません。</li>
        <?php endif; ?>
    </ul>

</body>
</html>