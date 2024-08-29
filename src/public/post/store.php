<?php
session_start();
$userId = $_SESSION['id'];
$blogTitle = filter_input(INPUT_POST, 'blog_title');
$content = filter_input(INPUT_POST, 'content');

if (empty($blogTitle) || empty($content)) {
    $_SESSION['errors'] = 'タイトルか内容の入力がありません';
    header('Location: ../create.php');
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
    'INSERT INTO blogs(user_id, title, content) VALUES(:userId, :blogTitle, :content)';
try {
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
    $statement->bindValue(':blogTitle', $blogTitle, PDO::PARAM_STR);
    $statement->bindValue(':content', $content, PDO::PARAM_STR);
    $statement->execute();
    header('Location: ../mypage.php');
    exit();
} catch (PDOException $e) {
    $_SESSION['errors'][] = 'ブログ記事の登録に失敗しました。';
    header('Location: ../create.php');
    exit();
}