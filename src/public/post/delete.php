<?php
session_start();
if (empty($_SESSION['id'])) {
    $_SESSION['errors'][] = 'ログインしてください';
    header('Location: ../user/signin.php');
    exit();
}

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $dbUserName,
    $dbPassword
);

$blogId = filter_input(INPUT_GET, 'id');
$commentSql = 'DELETE FROM comments WHERE blog_id = :blog_id';
$blogSql = 'DELETE FROM blogs WHERE id = :id';
try {
    $statement = $pdo->prepare($commentSql); //記事の削除時に該当記事のコメントも削除する
    $statement->bindValue(':blog_id', $blogId, PDO::PARAM_INT);
    $statement->execute();

    $statement = $pdo->prepare($blogSql);
    $statement->bindValue(':id', $blogId, PDO::PARAM_INT);
    $statement->execute();
    header('Location: ../mypage.php');
    exit();
} catch (PDOException $e) {
    $_SESSION['errors'][] = 'ブログ記事の削除に失敗しました。';
    header('Location: ../user/post_detail.php?id=' . $blogId);
    exit();
}