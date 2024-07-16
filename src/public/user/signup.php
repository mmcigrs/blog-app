<?php
session_start();
// Null合体演算子(??の前にある式や変数が null か判定して、もしnullの場合は??の後ろの式や値を実行する)
$errors = $_SESSION['errors'] ?? []; 
unset($_SESSION['errors']);

$userName = $_SESSION['userName'] ?? '';
$email = $_SESSION['email'] ?? '';
unset($_SESSION['userName']);
unset($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>signup</title>
</head>

<body>
  <h2>会員登録</h2>

  <?php foreach ($errors as $error): ?>
  <p><?php echo $error; ?></p>
  <?php endforeach; ?>

  <form action="./signup_complete.php" method="POST">

    <!-- アカウント作成ボタン押下後、登録失敗時にsignup.phpを表示 → 入力していた項目をフォームに表示させる -->
    <p><input placeholder="User name" type=“text” name="userName" value="<?php echo $userName; ?>"></p>
    <p><input placeholder="Email" type=“mail” name="email" value="<?php echo $email; ?>"></p>
    <p><input placeholder="Password" type="password" name="password"></p>
    <p><input placeholder="Password確認" type="password" name="confirmPassword"></p>
    <button type="submit">アカウント作成</button>
  </form>

  <a href="./signin.php">ログイン画面へ</a>

</body>

</html>