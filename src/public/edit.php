<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ./user/signin.php');
    exit();
}

$blogId = filter_input(INPUT_GET, 'id');
if (empty($blogId)) {
    header('Location: ./mypage.php');
    exit();
}

$dbUserName = 'root';
$dbPassword = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $dbUserName,
    $dbPassword
);

$sqlUserId = 'SELECT user_id FROM blogs WHERE id = :id';
$statement = $pdo->prepare($sqlUserId);
$statement->bindValue(':id', $blogId, PDO::PARAM_INT);
$statement->execute();
$userId = $statement->fetch(PDO::FETCH_COLUMN);
if ($userId != $_SESSION['id']) {
    header('Location: ./mypage.php');
    exit();
}

$sql = "SELECT * FROM blogs WHERE id = $blogId";
$statement = $pdo->prepare($sql);
$statement->execute();
$blogInfomation = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>記事編集フォーム</title>
</head>

<body>
  <section>
    <div class="bg-green-300 text-white py-20">
      <div class="container mx-auto my-6 md:my-24">
        <div class="w-full justify-center">
          <div class="container w-full px-4">
            <div class="flex flex-wrap justify-center">
              <div class="w-full lg:w-6/12 px-4">
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-white">
                  <div class="flex-auto p-5 lg:p-10">
                    <form id="form" action="./post/update.php" method="post">
                      <div class="relative w-full mb-3">
                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2"
                          for="blog_title">タイトル</label>
                        <input type="text" name="blog_title" id="blog_title" value="<?php print $blogInfomation[
                            'title'
                        ]; ?>" class="border-0 px-3 py-3 rounded text-sm shadow w-full
                    bg-gray-300 placeholder-black text-gray-800 outline-none focus:bg-gray-400" placeholder=" "
                          style="transition: all 0.15s ease 0s;" />
                      </div>
                      <div class="relative w-full mb-3">
                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="content">内容</label>
                        <textarea maxlength="300" name="content" id="content" rows="4" cols="80"
                          class="border-0 px-3 py-3 bg-gray-300 placeholder-black text-gray-800 rounded text-sm shadow focus:outline-none w-full"
                          placeholder=""><?php print $blogInfomation[
                              'content'
                          ]; ?></textarea>
                      </div>
                      <div class="text-center mt-6">
                        <button id="submit"
                          class="bg-yellow-300 text-black text-center mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1"
                          type="submit" style="transition: all 0.15s ease 0s;">編集
                        </button>
                      </div>
                      <input type="hidden" name="blog_id" value="<?php print $blogInfomation[
                          'id'
                      ]; ?>">
                    </form>
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