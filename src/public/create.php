<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ./user/signin.php');
    exit();
}
$error = $_SESSION['errors'] ?? '';
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>新規記事作成フォーム</title>
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
                    <h4 class="text-2xl mb-4 text-black font-semibold">新規記事</h4>
                    <p class="text-black"><?php echo $error; ?></p>
                    <form id="form" action="./post/store.php" method="post">
                      <div class="relative w-full mb-3">
                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2"
                          for="blog_title">タイトル</label><input type="text" name="blog_title" id="blog_title" class="border-0 px-3 py-3 rounded text-sm shadow w-full
                    bg-gray-300 placeholder-black text-gray-800 outline-none focus:bg-gray-400" placeholder=" "
                          style="transition: all 0.15s ease 0s;" />
                      </div>
                      <div class="relative w-full mb-3">
                        <label class="block uppercase text-gray-700 text-xs font-bold mb-2"
                          for="content">内容</label><textarea maxlength="300" name="content" id="content" rows="4"
                          cols="80"
                          class="border-0 px-3 py-3 bg-gray-300 placeholder-black text-gray-800 rounded text-sm shadow focus:outline-none w-full"
                          placeholder=""></textarea>
                      </div>
                      <div class="text-center mt-6">
                        <button id="submit"
                          class="bg-yellow-300 text-black text-center mx-auto active:bg-yellow-400 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1"
                          type="submit" style="transition: all 0.15s ease 0s;">新規作成
                        </button>
                      </div>
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