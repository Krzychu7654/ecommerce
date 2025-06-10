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
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Nieprawidłowy login lub hasło.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <title>Logowanie</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="style_auth.css" />
</head>
<body>
  <div class="form-container">
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
      <input type="text" name="username" placeholder="Login" required><br>
      <input type="password" name="password" placeholder="Hasło" required><br>
      <button type="submit">Zaloguj</button>
      <p>Nie masz konta? <a href="rejestracja.php">Zarejestruj się</a></p>
    </form>
  </div>
</body>
</html>