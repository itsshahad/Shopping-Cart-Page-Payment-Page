<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "root"; // MAMP default password
$database = "cafeteria";
$port = 3306;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// Fetch items in the shopping cart (assuming user_id is now hardcoded or handled differently)
$user_id = 1; // Set the user_id directly for now, you may adjust this as per your requirement

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
                <div class="cart-item" id="cart-item-<?= $item['cartID'] ?>">
                    <img src="<?= htmlspecialchars($item['image']) ?>" class="cart-item-img">
                    <div class="cart-item-info">
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <p>Quantity: <span id="quantity-<?= $item['cartID'] ?>"><?= (int) $item['quantity'] ?></span></p>
                        <p>Price: SAR <?= number_format((float) $item['total_price'], 2) ?></p>
                    </div>
                    <form method="POST" action="" id="cart-form-<?= $item['cartID'] ?>">
                        <input type="hidden" name="item_id" value="<?= $item['cartID'] ?>">
                        <button type="button" class="btn increase" onclick="updateQuantity(<?= $item['cartID'] ?>, 'increase')">+</button>
                        <button type="button" class="btn decrease" onclick="updateQuantity(<?= $item['cartID'] ?>, 'decrease')">-</button>
                        <button type="submit" name="remove_item" class="btn remove-btn" onclick="removeItem(<?= $item['cartID'] ?>)"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary">
            <p>Total: <span class="cart-total">SAR <?= number_format((float) $total, 2) ?></span></p>
            <?php if (!empty($items)): ?>
                <a href="payment.php?total=<?= urlencode($total) ?>&items=<?= urlencode(serialize($items)) ?>" class="checkout-btn">Proceed to Checkout</a>
            <?php else: ?>
                <p>Your cart is empty! Add some products first.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Snackbar for confirming quantity changes -->
    <div id="snackbar" class="snackbar">
        <p>Quantity updated successfully!</p>
    </div>

    <script>
        // Update quantity in the cart and show snackbar
        function updateQuantity(cartID, action) {
            const quantitySpan = document.getElementById('quantity-' + cartID);

            // Create an AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Update the displayed quantity in the cart
                    const updatedQuantity = parseInt(quantitySpan.textContent) + (action === 'increase' ? 1 : -1);
                    quantitySpan.textContent = updatedQuantity;

                    // Show the confirmation snackbar
                    const snackbar = document.getElementById('snackbar');
                    snackbar.className = "show";
                    setTimeout(function() {
                        snackbar.className = snackbar.className.replace("show", "");
                    }, 3000);
                }
            };
            xhr.send('item_id=' + cartID + '&action=' + action);
        }

        // Remove item from cart
        function removeItem(cartID) {
            const cartItem = document.getElementById('cart-item-' + cartID);

            // Send request to remove item from cart
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    cartItem.remove();
                    // Show the confirmation snackbar for item removal
                    const snackbar = document.getElementById('snackbar');
                    snackbar.textContent = 'Item removed from cart!';
                    snackbar.className = "show";
                    setTimeout(function() {
                        snackbar.className = snackbar.className.replace("show", "");
                    }, 3000);
                }
            };
            xhr.send('item_id=' + cartID + '&action=remove');
        }
    </script>
</body>
</html>






















