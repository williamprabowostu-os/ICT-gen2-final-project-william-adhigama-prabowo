<?php
session_start();

if (isset($_SESSION['username'])) {
  header("Location: welcome.php");
  exit;
}

if (isset($_POST['login'])) {
  require_once 'config.php';

  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['username'];
    header("Location: welcome.php");
    exit;
  } else {
    $error = "Invalid username or password.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
</head>
<body>

  <?php if (isset($error)): ?>
    <div><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="post">
    <div>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <div>
      <button type="submit" name="login">Login</button>
    </div>
  </form>

</body>
</html>