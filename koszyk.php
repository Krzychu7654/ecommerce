<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['product_name'], $_POST['product_price'])) {
        $_SESSION['cart'][] = [
            'name' => $_POST['product_name'],
            'price' => floatval($_POST['product_price'])
        ];
        echo "<script>parent.postMessage('added-to-cart', '*');</script>";
        exit;
    }

    if (isset($_POST['remove_index'])) {
        $index = (int) $_POST['remove_index'];
        if (isset($_SESSION['cart'][$index])) {
            array_splice($_SESSION['cart'], $index, 1);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Koszyk</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f4f4f9;
      padding: 20px;
    }
    h2 {
      color: #6030b9;
      text-align: center;
    }
    .cart-list {
      list-style: none;
      padding: 0;
      max-width: 700px;
      margin: 0 auto;
    }
    .cart-item {
      background: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
      padding: 16px 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .cart-details {
      font-size: 15px;
    }
    .remove-btn {
      background: #f44336;
      color: white;
      border: none;
      padding: 6px 12px;
      font-size: 13px;
      border-radius: 5px;
      cursor: pointer;
    }
    .remove-btn:hover {
      background: #c62828;
    }
    .total {
      text-align: center;
      font-size: 18px;
      font-weight: bold;
      margin-top: 25px;
    }
    .back-link {
      text-align: center;
      margin-top: 30px;
    }
    .back-link a {
      text-decoration: none;
      color: #6030b9;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <h2>🛒 Twój koszyk</h2>
  <?php if (!empty($_SESSION['cart'])): ?>
    <ul class="cart-list">
      <?php 
        $total = 0;
        foreach ($_SESSION['cart'] as $index => $item): 
          $total += $item['price'];
      ?>
        <li class="cart-item">
          <div class="cart-details">
            <strong><?= htmlspecialchars($item['name']) ?></strong><br>
            <?= number_format($item['price'], 2) ?> zł
          </div>
          <form method="post">
            <input type="hidden" name="remove_index" value="<?= $index ?>">
            <button class="remove-btn" type="submit">Usuń</button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
    <p class="total">Łączna kwota: <?= number_format($total, 2) ?> zł</p>
  <?php else: ?>
    <p style="text-align:center;">Koszyk jest pusty.</p>
  <?php endif; ?>
  <div class="back-link">
    <a href="index.php">⟵ Powrót do sklepu</a>
  </div>
</body>
</html>