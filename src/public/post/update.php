<?php
$blogId = filter_input(INPUT_POST, 'blog_id');
$blogTitle = filter_input(INPUT_POST, 'blog_title');
$content = filter_input(INPUT_POST, 'content');

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $dbUserName,
    $dbPassword
);

$sql =
    'UPDATE blogs SET title = :blogTitle, content = :content WHERE id = :blogId';
try {
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':blogTitle', $blogTitle, PDO::PARAM_STR);
    $statement->bindValue(':content', $content, PDO::PARAM_STR);
    $statement->bindValue(':blogId', $blogId, PDO::PARAM_INT);
    $statement->execute();
    header('Location: ../myarticledetail.php?id=' . $blogId);
    exit();
} catch (PDOException $e) {
    session_start();
    $_SESSION['errors'][] = 'ブログ記事の編集に失敗しました。';
    header('Location: ../edit.php');
    exit();
}