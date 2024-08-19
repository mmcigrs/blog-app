<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ./user/signin.php');
    exit();
}

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $dbUserName,
    $dbPassword
);

$sql = 'SELECT * FROM blogs ORDER BY created_at DESC';
$statement = $pdo->prepare($sql);
$statement->execute();

$blogsInfoList = $statement->fetchAll(PDO::FETCH_ASSOC);
$myBlogsInfoList = [];
foreach ($blogsInfoList as $blogsInfo) {
    //ブログを全記事取得して、ログインユーザーの投稿した記事だけに絞り込む
    if ($_SESSION['id'] == $blogsInfo['user_id']) {
        $myBlogsInfoList[] = $blogsInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>マイページ</title>
</head>

<?php require_once './components/header.php'; ?>

<body>
  <div class="blogs__wraper bg-green-300  py-20 px-20">
    <div class="ml-8 mb-12">
      <h2 class="mb-2 px-2 text-6xl font-bold text-green-800">マイページ</h2>
    </div>
    <div class="mx-8 my-0">
      <a href="./create.php">
        <button
          class="bg-transparent hover:bg-green-800 text-gray-600 font-semibold hover:text-white py-2 px-4 border border-green-800 hover:border-transparent rounded">
          新規作成
        </button>
      </a>
    </div>
    <div class="flex flex-wrap">
      <?php foreach ($myBlogsInfoList as $myBlogsInfo): ?>
      <div class="blogs bg-white w-1/5 m-8">
        <div class="">
          <img
            src="https://images.unsplash.com/photo-1489396160836-2c99c977e970?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60"
            class="">
        </div>
        <div class="p-5">
          <h1 class="text-2xl font-bold text-green-800 py-2"><?= htmlspecialchars(
              $myBlogsInfo['title']
          ) ?></h1>
          <p class="bg-white text-sm text-black"><?php echo $myBlogsInfo[
              'created_at'
          ]; ?></p>
          <p class="bg-white text-sm text-black"><?php echo mb_strimwidth(
              strip_tags($myBlogsInfo['content']),
              0,
              15,
              '…',
              'UTF-8'
          ); ?></p>
          <a href="./myarticledetail.php?id=<?php echo $myBlogsInfo[
              'id'
          ]; ?>" class="py-2 px-3 mt-4 px-6 text-white bg-green-500 inline-block rounded">記事詳細へ</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>