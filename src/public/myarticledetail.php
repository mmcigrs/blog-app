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

$blogId = filter_input(INPUT_GET, 'id');
$sqlUserId = "SELECT user_id FROM blogs WHERE id = $blogId";
$statement = $pdo->prepare($sqlUserId);
$statement->execute();
$userId = $statement->fetch(PDO::FETCH_COLUMN);
if ($userId != $_SESSION['id']) {
    header('Location: ./mypage.php');
    exit();
}

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$sql = 'SELECT * FROM blogs WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->bindValue(':id', $blogId, PDO::PARAM_INT);
$statement->execute();
$myblogsInfo = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>マイ記事詳細ページ</title>
</head>

<body>
  <section>
    <div class="bg-green-300 text-white py-20">
      <div class="container mx-auto my-6 md:my-24">
        <div class="w-full justify-center">
          <div class="container w-full px-4">
            <div class="flex flex-wrap justify-center">
              <div class="w-full lg:w-6/12 px-4">
                <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
                <?php endforeach; ?>
                <div class="">
                  <h2 class="mb-12 text-6xl text-center font-bold text-green-800"><?php print nl2br(
                      $myblogsInfo['title']
                  ); ?></h2>
                </div>
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-white">
                  <div class="flex-auto p-5 lg:p-10">
                    <div class="relative w-full mb-3">
                      <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="content">投稿日時: <?php echo nl2br(
                          $myblogsInfo['created_at']
                      ); ?></label>
                      <div
                        class="border-0 px-3 py-3 bg-gray-300 text-gray-800 rounded text-sm shadow focus:outline-none w-full">
                        <?php echo nl2br($myblogsInfo['content']); ?>
                      </div>
                    </div>
                    <div class="text-right mt-6">
                      <a href="./edit.php?id=<?php echo $_GET['id']; ?>">
                        <button
                          class="bg-yellow-300 text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1"
                          type="submit" style="transition: all 0.15s ease 0s;">編集
                        </button>
                      </a>
                      <a href="../post/delete.php?id=<?php echo $_GET[
                          'id'
                      ]; ?>">
                        <button
                          class="bg-yellow-300 text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1"
                          type="submit" style="transition: all 0.15s ease 0s;">削除
                        </button>
                      </a>
                      <a href="./mypage.php">
                        <button
                          class="bg-yellow-300 text-black mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1"
                          type="submit" style="transition: all 0.15s ease 0s;">マイページへ
                        </button>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>