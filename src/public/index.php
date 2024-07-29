<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ./user/signin.php');
    exit();
}

if (isset($_GET['order'])) {
    $direction = $_GET['order'];
} else {
    $direction = 'desc';
}

if (isset($_GET['search_query'])) {
    $title = '%' . $_GET['search_query'] . '%';
    $contents = '%' . $_GET['search_query'] . '%';
} else {
    $title = '%%';
    $contents = '%%';
}

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $dbUserName,
    $dbPassword
);

$query = "SELECT * FROM blogs WHERE title LIKE :title OR content LIKE :content ORDER BY id $direction";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':content', $contents, PDO::PARAM_STR);
$stmt->execute();
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>blog一覧</title>
</head>

<?php require_once './components/header.php'; ?>

<body>
  <div class="blogs__wraper bg-green-300 py-20 px-20">

    <div class="ml-8 mb-12">
      <h2 class="mb-2 px-2 text-6xl font-bold text-green-800">blog一覧</h2>
    </div>

    <form action="index.php" method="get">
      <div class="ml-8 mb-6">
        <input name="search_query" type="text" value="<?php echo $_GET[
            'search_query'
        ] ?? ''; ?>" placeholder="キーワードを入力" />
        <input type="submit" value="検索" />
      </div>

      <div class="ml-8">
        <label>
          <input type="radio" name="order" value="desc" class="">
          <span>新着順</span>
        </label>
        <label>
          <input type="radio" name="order" value="asc" class="">
          <span>古い順</span>
        </label>
      </div>
    </form>

    <div class="flex flex-wrap">
      <?php foreach ($posts as $post): ?>
      <div class="blogs bg-white w-1/5 m-8">
        <div class="">
          <img
            src="https://images.unsplash.com/photo-1489396160836-2c99c977e970?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60"
            class="">
        </div>
        <div class="p-5">
          <h1 class="text-2xl font-bold text-green-800 py-2">
            <?php echo $post['title']; ?>
          </h1>
          <p class="bg-white text-sm text-black">
            <?php echo $post['created_at']; ?>
          </p>
          <p class="bg-white text-sm text-black">
            <?php echo mb_strimwidth(
                strip_tags($post['content']),
                0,
                15,
                '…',
                'UTF-8'
            ); ?>
          </p>
          <a href="./detail.php?id=<?php echo $post[
              'id'
          ]; ?>" class="py-2 px-3 mt-4 px-6 text-white bg-green-500 inline-block rounded">記事詳細へ</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</body>

</html>















