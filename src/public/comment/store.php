<?php
session_start();
$userId = $_SESSION['id'];
$blogId = filter_input(INPUT_POST, 'blog_id');
$commenterName = filter_input(INPUT_POST, 'commenter_name');
$commentContent = filter_input(INPUT_POST, 'comment');

if (empty($commenterName) || empty($commentContent)) {
    $_SESSION['errors'] = 'コメント名かコメント内容が入力されていません！';
    header('Location: ../detail.php?id=' . $blogId);
    exit();
}

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $dbUserName,
    $dbPassword
);

$sql =
    'INSERT INTO comments(user_id, blog_id, commenter_name, comment)VALUES(:user_id, :blog_id, :commenter_name, :comment)';
try {
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $statement->bindValue(':blog_id', $blogId, PDO::PARAM_INT);
    $statement->bindValue(':commenter_name', $commenterName, PDO::PARAM_STR);
    $statement->bindValue(':comment', $commentContent, PDO::PARAM_STR);
    $statement->execute();
    header('Location: ../detail.php?id=' . $blogId);
    exit();
} catch (PDOException $e) {
    $_SESSION['errors'][] = 'コメントの投稿に失敗しました。';
    header('Location: ../detail.php?id=' . $blogId);
    exit();
}