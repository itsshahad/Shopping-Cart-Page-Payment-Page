<?php
session_start();

/**
 * Database Connection and Shopping Cart Page
 * Configured for MAMP (Port 3306)
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "root"; // MAMP default password
$database = "cafeteria";
$port = 3306; // MySQL port

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");

if (!isset($_SESSION['user_id'])) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                let alertBox = document.createElement('div');
                alertBox.style.position = 'fixed';
                alertBox.style.top = '50%';
                alertBox.style.left = '50%';
                alertBox.style.transform = 'translate(-50%, -50%)';
                alertBox.style.padding = '20px';
                alertBox.style.background = '#ff4444';
                alertBox.style.color = 'white';
                alertBox.style.borderRadius = '10px';
                alertBox.style.boxShadow = '0px 0px 10px rgba(0, 0, 0, 0.2)';
                alertBox.style.fontSize = '18px';
                alertBox.innerHTML = '⚠️ You must be logged in to access this page.';
                document.body.appendChild(alertBox);
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 3000);
            });
          </script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch items in the shopping cart
$cartItems = $conn->query("SELECT c.cartID, m.name, oi.quantity, oi.price * oi.quantity AS total_price, m.image
                           FROM shopping_cart c
                           JOIN order_items oi ON c.cartID = oi.order_id
                           JOIN menu_items m ON oi.menu_item_id = m.productID
                           WHERE c.user_id = $user_id");

$items = [];
while ($row = $cartItems->fetch_assoc()) {
    $items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="cart-container">
        <div class="cart-header">
            <button class="back-btn" onclick="window.history.back()">←</button>
            <h2>Shopping Cart</h2>
            <span class="cart-icon">🛒</span>
        </div>

        <div class="cart-items">
            <?php $total = 0; ?>
            <?php foreach ($items as $item): ?>
                <?php $total += $item["total_price"]; ?>
                <div class="cart-item">
                    <img src="<?= htmlspecialchars($item['image']) ?>" class="cart-item-img">
                    <div class="cart-item-info">
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p>Quantity: <?= (int) $item['quantity'] ?></p>
                        <p>Price: $<?= number_format((float) $item['total_price'], 2) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary">
            <p>Total: <span class="cart-total">$<?= number_format((float) $total, 2) ?></span></p>
            <?php if (!empty($items)): ?>
                <a href="payment.php" class="checkout-btn">Proceed to Checkout</a>
            <?php else: ?>
                <p>Your cart is empty! Add some products first.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>







