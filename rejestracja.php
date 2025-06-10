<?php
session_start();

$host = 'mysql8';
$db = '01493838_krzysztof';
$user = '01493838_krzysztof';
$pass = 'Krzysiek2525';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass);


try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo "Błąd połączenia z bazą danych: " . $e->getMessage();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $error = "Taki użytkownik już istnieje.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <title>Rejestracja</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="style_auth.css" />
</head>
<body>
  <div class="form-container">
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
      <input type="text" name="username" placeholder="Login" required><br>
      <input type="password" name="password" placeholder="Hasło" required><br>
      <button type="submit">Zarejestruj się</button>
      <p>Masz już konto? <a href="login.php">Zaloguj się</a></p>
    </form>
  </div>
</body>
</html>